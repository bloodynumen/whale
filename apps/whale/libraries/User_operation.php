<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
    * @file User_power.php
    * @brief 用户权限
    * @author sunhuai(v_sunhuai@baidu.com)
    * @version
    * @date 2014/9/15 15:01:28
 */

class User_Operation {
    private $CI = null;

    function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('Mongod');
        $this->collection = $this->CI->mongod->selectCollection('whale_op_record');
        if (!$this->collection) {
            $this->collection = $this->CI->mongod->createCollection('whale_op_record', array(
                'capped' => true,
                'size' => 400*1024*1024,//200M
            ));
        }
        $this->collection->ensureIndex(array('app' => 1));
        $this->collection->ensureIndex(array('editor' => 1));
        $this->collection->ensureIndex(array('path_info' => 1));
        $this->collection->ensureIndex(array('ctime' => 1));
    }

    public function record() {
        $options = array(
            'w' => 1,
        );
        $directory = $this->CI->router->fetch_directory();
        $class = $this->CI->router->fetch_class();
        $method = $this->CI->router->fetch_method();
        $info = array(
            'app' => APPNAME,
            'get_params' => $_GET,
            'post_params' => $_POST,
            'directory' => $directory,
            'class' => $class,
            'method' => $method,
            'editor' => $this->CI->user->info['name'],
            'path_info' => $_SERVER['PATH_INFO'],
            'ctime' => $_SERVER['REQUEST_TIME'],
        );
        return $this->collection->insert($info, $options);
    }

    public function getListInfo($offset, $size, $condition = array())
    {
        $result = array();
        $result['list'] = array();
        $result['count'] = $this->collection
            ->find($condition)->count();
        if ($result['count'] == 0) {
            return $result;
        }
        $cursor = $this->collection
            ->find($condition)
            ->sort(array('_id' => 1))
            ->skip($offset)
            ->limit($size);
        if ($cursor)
        {
            $list = array();
            foreach ($cursor as $one)
            {
                $id = (string)$one["_id"];
                $list[$id] = $one;
                $list[$id]['_id'] = $id;
            }
            $result['list'] = $list;
        }
        return $result;
    }
}
