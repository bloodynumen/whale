<?php
class Op extends MY_Admin_Controller {
  public function __construct() {
    parent::__construct();
    //权限校验
    $this->load->library('user_group');
    $this->load->library('user_operation', null, 'op');
    $this->load->helper('json');
  }

  public function index() {
    $page = $this->input->get('page') ? $this->input->get('page') : 1;
    $size = $this->input->get('size') ? $this->input->get('size') : 20;
    $offset = ($page - 1) * $size;
    $condition = array(
      'app' => $this->input->get('app'),
    );
    if ($this->input->get('editor'))
    {
      $condition['editor'] = trim($this->input->get('editor'));
    }
    if ($this->input->get('path'))
    {
      $condition['path_info'] = trim($this->input->get('path'));
    }
    if ($this->input->get('begin_datetime'))
    {
      $condition['ctime']['$gt'] = strtotime($this->input->get('begin_datetime'));
    }
    if ($this->input->get('end_datetime'))
    {
      $condition['ctime']['$lt'] = strtotime($this->input->get('end_datetime'));
    }
    $result = $this->op->getListInfo($offset, $size, $condition);
    $pagination = array(
      'page' => $page,
      'size' => $size,
      'total' => $result['count'],
    );
    $this->smarty->assign('list', $result['list']);
    $this->smarty->assign('pagination', $pagination);
    $this->smarty->assign('fields', array(
      'app' => 'app',
      'get_params' => 'get参数',
      'post_params' => 'post参数',
      'path_info' => 'path',
      'directory' => '目录',
      'class' => 'class',
      'method' => 'method',
      'editor' => '操作人',
      'ctime' => '操作时间',
    ));
    $this->smarty->view('op/index.tpl');
  }
}

