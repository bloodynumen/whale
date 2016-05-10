<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends WhaleController {

    var $allow_list = array(
        USER_APP_ADMIN,
        USER_MP_ADMIN,
    );

    public function __construct() {
        parent::__construct();
        //权限校验
        //用户对应的权限校验
        if (!$this->userPower->auth_user_type($this->allow_list)) {
            $this->load->helper('url');
            redirect('/whale', 'refresh');
            exit();
        }
    }

    public function index() {
        $app = trim($this->input->get('app'));
        $nav_list = $this->nav->get_user_nav($app);

        $this->template->assign('nav_list', $nav_list);
        $this->template->display('nav/index.tpl');
    }

}
