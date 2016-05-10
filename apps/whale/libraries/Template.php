<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @file Template.php
 * @brief 模板类
 * @author sunhuai
 * @version 1
 * @date 2016/5/9 15:21:43
 */
class Template
{
    private $instance = null;

    public function __construct()
    {
        $this->instance = new Smarty();
        if (ENVIRONMENT == 'development') {
            $this->instance->caching = false;
        } else {
            $this->instance->caching = true;
        }
        $tplDir = VIEWPATH . 'template' . DIRECTORY_SEPARATOR;
        $this->instance->template_dir = $tplDir . 'templates';
        $this->instance->compile_dir = $tplDir . 'templates_c';
        $this->instance->cache_dir = $tplDir . 'cache';
        $this->instance->left_delimiter = '{{';
        $this->instance->right_delimiter = '}}';
        $this->instance->addPluginsDir(Whale::getOwnPath() . 'common/smarty_plugins');

        //带合并
        $this->_common = array(
            'whale' => array(
                'layoutDir' => Whale::getOwnPath() . 'views/template/templates/layouts/',
            ),
        );
        $this->assign('_common', $this->_common);
    }

    public function assign($name = '', $var = '')
    {
        return $this->instance->assign($name, $var);
    }

    public function display($tpl = '')
    {
        return $this->instance->display($tpl);
    }

}
