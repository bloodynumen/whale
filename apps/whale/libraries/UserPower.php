<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
    * @file User_power.php
    * @brief 用户权限
    * @author sunhuai
    * @version 
    * @date 2014/9/15 15:01:28
 */

class UserPower {
    private $CI = null;

    function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('Mongod');
        $this->collection = $this->CI->mongod->selectCollection('whale_nav');
        if (!$this->collection) {
            $this->collection = $this->CI->mongod->createCollection('whale_nav', array(
                'capped' => false,
            ));
        }
    }

    public function valid_power() {
        //base 服务 由服务自己判断用户身份来限制
        if (APPNAME == 'whale') {
            return true;
        }
        //各个产品线首页是允许访问的
        $app_path = '/' . APPNAME . '/';
        if ($_SERVER['PATH_INFO'] == $app_path || $_SERVER['PATH_INFO'] . '/' == $app_path) {
            return true;
        }
        $user_info = $this->CI->user->info;
        //用户虽然可以登陆 但没有添加角色
        if (!$user_info) {
            return false;
        }
        return $this->valid_url($user_info);
    }

    public function valid_url($usr_info) {
        //whale 下程序 根据用户type来控制权限
        if (APPNAME == 'whale') {
            return true;
        }
        //身份类型限制
        if ($this->auth_user_type(array(USER_MP_ADMIN, USER_APP_ADMIN))){
            return true;
        }
        $this->CI->load->library('user_group');
        $channel_list = $this->CI->user_group->get_channel_list($this->CI->user->app);
        if ($channel_list) {
            $path_info = $_SERVER['PATH_INFO']; 
            foreach ($channel_list as $channel) {
                if (strpos($path_info, $channel['link']) === 0) {
                    return true;
                }
            }
        }
        return false;
    }

    //验证用户的类型
    public function auth_user_type($allow = array()) {
        foreach ($allow as $type) {
            if ($this->CI->user->type == $type) {
                return true;
            }
        }
        return false;
    }

}

