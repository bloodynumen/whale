<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
    * @file index.php
    * @brief 用户行为
    * @author sunhuai(v_sunhuai@baidu.com)
    * @version 
    * @date 2014/6/27 17:49:01
 */

class Index extends CI_Controller {

    public function logout() {
        $this->load->library('user');
        $this->user->logout();
    }
}

