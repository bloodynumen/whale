<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['nav/group/add'] = array(
    array(
        'field' => 'name',
        'label' => '频道组名称',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'app',
        'label' => 'app',
        'rules' => 'trim|required',
    ),
);
$config['nav/group/edit'] = array(
    array(
        'field' => '_id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'name',
        'label' => '频道组名称',
        'rules' => 'trim|required',
    ),
);
$config['nav/group/del'] = array(
    array(
        'field' => '_id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
);
$config['nav/channel/add'] = array(
    array(
        'field' => 'name',
        'label' => '频道名称',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'link',
        'label' => '链接',
        'rules' => 'trim|required',
    ),
    array(
        'field' => '_id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
);
$config['nav/channel/edit'] = array(
    array(
        'field' => 'name',
        'label' => '频道名称',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'link',
        'label' => '链接',
        'rules' => 'trim|required',
    ),
    array(
        'field' => '_id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'channel_id',
        'label' => 'channel_id',
        'rules' => 'trim|required',
    ),
);
$config['nav/channel/del'] = array(
    array(
        'field' => '_id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'channel_id',
        'label' => 'channel_id',
        'rules' => 'trim|required',
    ),
);

$config['user/manage/add'] = array(
    array(
        'field' => 'app',
        'label' => 'app',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'name',
        'label' => '用户名',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'password',
        'label' => '密码',
        'rules' => 'required',
    ),
    array(
        'field' => 'type',
        'label' => '用户类型',
        'rules' => 'trim|intval|required',
    ),
);
$config['user/manage/edit'] = array(
    array(
        'field' => 'app',
        'label' => 'app',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'type',
        'label' => '用户类型',
        'rules' => 'trim|intval|required',
    ),
);
$config['user/manage/del'] = array (
    array(
        'field' => 'id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
);
$config['user/group/add'] = array(
    array(
        'field' => 'app',
        'label' => 'app',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'name',
        'label' => '用户组名称',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'channel_id_list[]',
        'label' => '功能频道',
        'rules' => 'required',
    ),
);
$config['user/group/edit'] = array(
    array(
        'field' => 'user_group_id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'name',
        'label' => '用户组名称',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'channel_id_list[]',
        'label' => '选择功能频道',
        'rules' => 'required',
    ),
);
$config['user/group/del'] = array(
    array(
        'field' => 'user_group_id',
        'label' => 'id',
        'rules' => 'trim|required',
    ),
);

$config['user/index/auth'] = array(
    array(
        'field' => 'name',
        'label' => 'name',
        'rules' => 'trim|required',
    ),
    array(
        'field' => 'password',
        'rules' => 'required',
    ),
);
