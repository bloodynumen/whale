<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends MY_Admin_Controller {

    public function __construct() {
        parent::__construct();
        //权限校验
        $this->load->library('nav');
        $this->load->library('user_group');
        $this->load->helper('json');
    }

    public function index() {
        $app = trim($this->input->get('app'));
        $group_list = $this->user_group->get_list($app);

        $this->smarty->assign('list', $group_list);
        $this->smarty->assign('header', array(
            'name' => '用户组名称',
        ));
        $this->smarty->with_common_data = true;
        $this->smarty->base_view('user/group.tpl');
    }

    public function add() {
        $operate = __FUNCTION__;
        if($this->form_validation->run()) {
            $info = array();
            $info['app'] = $this->input->post('app');
            $info['name'] = $this->input->post('name');
            $info['channel_id_list'] = $this->input->post('channel_id_list');
            if ($this->user_group->add($info)) {
                return output_json(array(
                    'errno' => 0,
                    'message' => '添加成功',
                ));
            } else {
                return output_json(array(
                    'errno' => 1,
                    'message' => '添加失败',
                ));
            }
        } else {
            $app = $this->input->get('app');
            $this->smarty->assign('nav_list', $this->nav->get_user_nav($app));
            $this->smarty->assign('operate', $operate);
            $this->smarty->with_common_data = true;
            $this->smarty->base_view('user/group_operate.tpl');
        }
    }

    public function edit() {
        $operate = __FUNCTION__;
        if($this->form_validation->run()) {
            $info = array();
            $info['id'] = $this->input->post('user_group_id');
            $info['name'] = $this->input->post('name');
            $info['channel_id_list'] = $this->input->post('channel_id_list');
            if ($this->user_group->edit($info)) {
                return output_json(array(
                    'errno' => 0,
                    'message' => '修改成功',
                ));
            } else {
                return output_json(array(
                    'errno' => 1,
                    'message' => '修改失败',
                ));
            }
        } else {
            $app = $this->input->get('app');
            $group_id = $this->input->get('user_group_id');
            $user_group_info = $this->user_group->get_one($group_id);
            $this->smarty->assign('nav_list', $this->nav->get_user_nav($app));
            $this->smarty->assign('user_group_info', $user_group_info);
            $this->smarty->assign('operate', $operate);
            $this->smarty->with_common_data = true;
            $this->smarty->base_view('user/group_operate.tpl');
        }
    }

    public function del() {
        if($this->form_validation->run()) {
            $id = $this->input->post('user_group_id');

            if ($this->user_group->del($id)) {
                return output_json(array(
                    'errno' => 0,
                    'message' => '删除成功',
                ));
            } else {
                return output_json(array(
                    'errno' => 1,
                    'message' => '删除失败',
                ));
            }
        } else {
            $result['error_msg'] = validation_errors();
            return output_json(array(
                'errno' => 1,
                'message' => validation_errors(),
            ));
        }
    }
}

