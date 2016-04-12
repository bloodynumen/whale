<?php
/**
 * @file performance.php
 * @brief 性能日志查看
 * @author sunhuai(sunhuai@baidu.com)
 * @version 
 * @date 2015/7/15 17:49:01
 */

class Performance extends CI_Controller {
    private $dataDir = '';

    public function __construct() {
        parent::__construct();
        $this->load->helper('directory');
        $this->dataDir = APP_DATAPATH . 'performance/';
        mk_dir(APP_DATAPATH);
        mk_dir($this->dataDir);
        $this->load->library(
            'MongoBase',
            array(
                'collection' => '_performance',
            ),
            'mongoBase'
        );
    }

    public function index() {
        $page = $this->input->get('page') ? $this->input->get('page') : 1;
        $size = $this->input->get('size') ? $this->input->get('size') : 20;
        $app = $this->input->get('app');
        $offset = ($page - 1) * $size;
        $list = array();
        $collection = $this->mongoBase->getCollection();

        $ops = array(
            array(
                '$match' => array(
                    'app' => $app,
                ),
            ),
            array(
                '$group' => array(
                    '_id' => '$uri',
                    'requests' => array(
                        '$sum' => 1,
                    ),
                    'avg_cost' => array(
                        '$avg' => '$cost',
                    ),
                ),
            ),
        );
        $results = $collection->aggregate($ops);
        $list = $results ? $results['result'] : array();
        
        $this->smarty->assign('list', $list);
        $this->smarty->assign('fields', array(
            '_id'   => 'uri',
            'requests' => '请求次数',
            'avg_cost'   => '页面平均总耗时',
        ));
        $this->smarty->baseView('performance/index.tpl');
    }

    //crontab 任务
    public function run() {
        if (!$this->input->is_cli_request()) {
            return false;
        }
        $yesterday = date('Y-m-d', strtotime('-1 days'));
        $this->load->config('performance');
        $appList = $this->config->item('appList', 'performance');
        $fileList = array();
        foreach ($appList as $app) {
            $appDir = $this->dataDir . $app . '/';
            mk_dir($appDir);
            $logFile = APPSPATH . "$app/" . 'logs/log-' . $yesterday . '.php';
            if(file_exists($logFile)) {
                $dataFile = $appDir . $yesterday . '.data';
                $command = sprintf('grep "Total execution time:" %s | grep "log_id" | awk \'{print $1,$2,$11}\' > %s', $logFile, $dataFile);
                system($command);
                $fileList[$app] = $dataFile;
            }
        }
        $data = array();
        foreach ($fileList as $app => $dataFile) {
            if(file_exists($dataFile)) {
                $content = file_get_contents($dataFile);
                if (!$content) {
                    continue;
                }
                $lines = explode("\n", $content);
                foreach ($lines as $line) {
                    if (!$line) {
                        continue;
                    }
                    $items = explode(" ", $line);
                    $dataItem = array();
                    $dataItem['log_id'] = str_replace('log_id:', '', $items[0]);
                    $dataItem['uri'] = $items[1];
                    $dataItem['cost'] = (float)$items[2];
                    $dataItem['app'] = $app;
                    $dataItem['day'] = $yesterday;
                    $data[] = $dataItem;
                }
            }
        }
        var_dump($this->mongoBase->batchAdd($data));
    }
}

