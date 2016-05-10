<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends WhaleController {

    var $allow_list = array(
        USER_APP_ADMIN,
        USER_MP_ADMIN,
    );

    public function __construct() {
        parent::__construct();
        //用户对应的权限校验
        if (!$this->userPower->auth_user_type($this->allow_list)) {
            $this->load->helper('url');
            redirect('/whale', 'refresh');
            exit();
        }
        //权限校验
        $this->load->library('Nav');
        $this->load->library('User_group');
        $this->load->helper('json');
    }

    public function index() {
        $app = trim($this->input->get('app'));
        $group_list = $this->user_group->get_list($app);

        $this->template->assign('list', $group_list);
        $this->template->assign('header', array(
            'name' => '用户组名称',
        ));
        $this->template->with_common_data = true;
        $this->template->display('user/group.tpl');
    }

    public function add() {
        $operate = __FUNCTION__;
        if ($this->input->method() == 'post') {
            if($this->form_validation->run()) {
                $info = array();
                $info['app'] = $this->input->post('app');
                $info['name'] = $this->input->post('name');
                $info['channel_id_list'] = $this->input->post('channel_id_list');
                if ($this->user_group->add($info)) {
                    return output_json(array(
                        'errno' => SUCCESS,
                        'msg' => '添加成功',
                    ));
                }
            } else {
                return output_json(array(
                    'errno' => FAILED,
                    'msg' => validation_errors(),
                ));
            }
        } else {
            $app = $this->input->get('app');
            $this->template->assign('nav_list', $this->nav->get_user_nav($app));
            $this->template->assign('operate', $operate);
            $this->template->display('user/group_operate.tpl');
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
                    'msg' => '修改成功',
                ));
            } else {
                return output_json(array(
                    'errno' => 1,
                    'msg' => '修改失败',
                ));
            }
        } else {
            $app = $this->input->get('app');
            $group_id = $this->input->get('user_group_id');
            $user_group_info = $this->user_group->get_one($group_id);
            $this->template->assign('nav_list', $this->nav->get_user_nav($app));
            $this->template->assign('user_group_info', $user_group_info);
            $this->template->assign('operate', $operate);
            $this->template->with_common_data = true;
            $this->template->display('user/group_operate.tpl');
        }
    }

    public function del() {
        if($this->form_validation->run()) {
            $id = $this->input->post('user_group_id');

            if ($this->user_group->del($id)) {
                return output_json(array(
                    'errno' => 0,
                    'msg' => '删除成功',
                ));
            } else {
                return output_json(array(
                    'errno' => 1,
                    'msg' => '删除失败',
                ));
            }
        } else {
            $result['error_msg'] = validation_errors();
            return output_json(array(
                'errno' => 1,
                'msg' => validation_errors(),
            ));
        }
    }
}

