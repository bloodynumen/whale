<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WhaleController extends CI_Controller
{
    public $_common = array();
    public $template = null;

    public function __construct()
    {
        parent::__construct();
        $this->initCommon();
        $this->initTemplate();
    }

    private function initCommon()
    {
        $this->_common = array(
            'nav' => array(
                array(
                    'name' => '接口测试',
                    'channel_list' => array(
                        array(
                            'link' => '/test/api/area',
                            'name' => '地域配置验证',
                        ),
                        array(
                            'link' => '/test/api/config',
                            'name' => '配置接口',
                        ),
                        array(
                            'link' => '/test/api/report',
                            'name' => '上报接口',
                        ),
                    ),
                ),
            ),
            'user' => array(
                'name' => 'admin',
                'power' => array(),
            ),
            'page' => array(
                'site' => 'Whale',
                'title' => '',
                'url' => '',
            ),
            'whale' => array(
                'layoutDir' => Whale::getOwnPath() . 'views/template/templates/layouts/',
            ),
        );
    }

    private function initTemplate()
    {
        $this->template = new Smarty();
        if (ENVIRONMENT == 'development') {
            $this->template->caching = false;
        } else {
            $this->template->caching = true;
        }
        $tplDir = VIEWPATH . 'template' . DIRECTORY_SEPARATOR;
        $this->template->template_dir = $tplDir . 'templates';
        $this->template->compile_dir = $tplDir . 'templates_c';
        $this->template->cache_dir = $tplDir . 'cache';
        $this->template->left_delimiter = '{{';
        $this->template->right_delimiter = '}}';
        $this->template->assign('_common', $this->_common);
    }
}
