<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //权限校验
        $this->load->library('nav');
        $this->load->helper('json');
    }

    public function add() {
        if($this->form_validation->run()) {
            $app = $this->input->post('app');
            $name = $this->input->post('name');
            if ($this->nav->add_group($app, $name)) {
                return output_json(array(
                    'errno' => 0,
                    'msg' => '添加成功',
                ));
            } else {
                return output_json(array(
                    'errno' => 1,
                    'msg' => '添加失败',
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

    public function edit() {
        if($this->form_validation->run()) {
            $id = $this->input->post('_id');
            $name = $this->input->post('name');

            if ($this->nav->edit_group($id, $name)) {
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
            $result['error_msg'] = validation_errors();
            return output_json(array(
                'errno' => 1,
                'msg' => validation_errors(),
            ));
        }
    }

    public function del() {
        if($this->form_validation->run()) {
            $id = $this->input->post('_id');

            if ($this->nav->del_group($id)) {
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

