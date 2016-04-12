<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Channel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //权限校验
        $this->load->library('nav');
        $this->load->helper('json');
    }

    public function add() {
        if($this->form_validation->run()) {
            $id = $this->input->post('_id');
            $name = $this->input->post('name');
            $link = $this->input->post('link');
            if ($link[0] != '/') {
                $link = '/' . $link;
            }
            if ($this->nav->add_channel($id, $name, $link)) {
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
            $id = $this->input->post('_id');
            $name = $this->input->post('name');
            $link = $this->input->post('link');
            $channel_id = $this->input->post('channel_id');

            if ($link[0] != '/') {
                $link = '/' . $link;
            }
            if ($this->nav->edit_channel($id, $channel_id, $name, $link)) {
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
            $id = $this->input->post('_id');
            $channel_id = $this->input->post('channel_id');

            if ($this->nav->del_channel($id, $channel_id)) {
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


