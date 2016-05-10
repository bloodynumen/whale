<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WhaleController extends CI_Controller
{
    public $_common = array();
    public $template = null;

    public function __construct()
    {
        parent::__construct();
        $this->initUser();
        $this->initCommon();
        $this->initTemplate();
        //考虑是否移除
        $this->initOpLog();
    }

    private function initCommon()
    {
        $this->_common = array(
            //'nav' => array(
            //    array(
            //        'name' => '接口测试',
            //        'channel_list' => array(
            //            array(
            //                'link' => '/test/api/area',
            //                'name' => '地域配置验证',
            //            ),
            //            array(
            //                'link' => '/test/api/config',
            //                'name' => '配置接口',
            //            ),
            //            array(
            //                'link' => '/test/api/report',
            //                'name' => '上报接口',
            //            ),
            //        ),
            //    ),
            //),
            'user' => array(
                'name' => $this->user->info['name'],
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

        $this->load->library('Nav');
        $this->_common['nav'] = $this->nav->get_app_nav();
    }

    private function initTemplate()
    {
        $this->load->library('Template');
        $this->template->assign('_common', $this->_common);
    }

    private function initUser()
    {
        $this->load->helper('url');
        //验证用户
        $this->load->library('User');
        if ($this->user->isLogin() == false) {
            redirect('/whale/user/index/login');
            exit();
        }

        //验证用户的权限
        $this->load->library('UserPower', [], 'userPower');
        if (!$this->userPower->valid_power()) {
            redirect('/' . APPNAME);
            exit();
        }
    }

    private function initOpLog()
    {
        //记录操作日志
        $this->load->library('user_operation');
        $this->user_operation->record();
    }

}
