<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends MY_Admin_Controller {
    
    public function __construct() {
        parent::__construct();
        //权限校验
        $this->load->library('user_group');
        $this->load->helper('json');
    }

    public function index() {
        $app = trim($this->input->get('app'));
        $user_list = $this->user->get_user_list($app);
        $group_list = $this->user_group->get_list($app);
        $user_type = $this->config->item('user_type');

        //产品线管理员 仅仅可以添加普通用户
        if ($this->user->type != USER_MP_ADMIN) {
            unset($user_type[USER_MP_ADMIN]);
            unset($user_type[USER_APP_ADMIN]);
        }

        if ($user_list) {
            $group_name_map = array();
            foreach ($group_list as $group_info) {
                $group_name_map[$group_info['_id']] = $group_info['name'];
            }
            foreach ($user_list as $k => $user) {
                if (isset($user['group_list']) && $user['group_list']) {
                    foreach ($user['group_list'] as $group_id) {
                        if (isset($group_name_map[$group_id]))
                        {
                            $user_list[$k]['group_name_list'][] = $group_name_map[$group_id];
                        }
                    }
                } else {
                    $user_list[$k]['group_list'] = array();
                }
            }
        }

        $this->smarty->assign('user_list', $user_list);
        $this->smarty->assign('group_list', $group_list);
        $this->smarty->assign('header', array(
            'uname' => '用户名',
            'type' => '用户类别',
            'group_name_list' => '用户组列表',
        ));
        $this->smarty->assign('user_type', $user_type);
        $this->smarty->with_common_data = true;
        $this->smarty->base_view('user/manage.tpl');
    }

    public function add() {
        if($this->form_validation->run()) {
            $info = array();
            $info['app'] = $this->input->post('app');
            $info['uname'] = $this->input->post('uname');
            $info['type'] = $this->input->post('type');
            $info['group_list'] = $this->input->post('group_list');

            if ($this->user->add($info)) {
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
            $result['error_msg'] = validation_errors();
            return output_json(array(
                'errno' => 1,
                'message' => validation_errors(),
            ));
        }
    }

    public function edit() {
        if($this->form_validation->run()) {
            $info['app'] = $this->input->post('app');
            $info['id'] = $this->input->post('id');
            $info['type'] = $this->input->post('type');
            $info['group_list'] = $this->input->post('group_list');

            if ($this->user->edit($info)) {
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
            $result['error_msg'] = validation_errors();
            return output_json(array(
                'errno' => 1,
                'message' => validation_errors(),
            ));
        }
    }

    public function del() {
        if($this->form_validation->run()) {
            $id = $this->input->post('id');
            if ($this->user->del($id)) {
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

