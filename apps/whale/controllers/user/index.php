<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
    * @file index.php
    * @brief 用户行为
    * @author sunhuai
    * @version
    * @date 2014/6/27 17:49:01
 */

class Index extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper(array('url', 'json'));
        $this->load->library('User');
        $this->load->library('Template');
    }

    public function login() {
        $this->template->display("user/login.tpl");
    }

    public function auth() {
        if($this->form_validation->run() == false) {
            $result['error_msg'] = validation_errors();
            return output_json(array(
                'errno' => 1,
                'msg' => validation_errors(),
            ));
        }
        $name = $this->input->post('name');
        $password = $this->input->post('password');

        if ($this->user->login($name, $password)) {
            return output_json(array(
                'errno' => SUCCESS,
                'msg' => '操作成功',
            ));
        } else {
            return output_json(array(
                'errno' => FAILED,
                'msg' => '操作失败',
            ));
        }
    }

    public function logout() {
        $this->user->logout();
        return redirect('/whale/user/index/login');
    }
}

