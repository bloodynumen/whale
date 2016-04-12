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
            ),
            'user' => array(
                'name' => 'admin',
                'power' => array(),
            ),
            'page' => array(
                'title' => '',
                'url' => '',
            ),
            'tpl' => array(
                'whale' => array(
                    'layout' => Whale::getOwnPath() . 'views/template/templates/layouts/main.layout.tpl',
                ),
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
