<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Index extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();
        //权限校验
        $this->load->library('nav');
    }

    public function index() {
        $app = trim($this->input->get('app'));
        $nav_list = $this->nav->get_user_nav($app);

        $this->smarty->assign('nav_list', $nav_list);
        $this->smarty->with_common_data = true;
        $this->smarty->base_view('nav/index.tpl');
    }

}
