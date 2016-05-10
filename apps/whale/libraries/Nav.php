<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
    * @file Nav.php
    * @brief 导航管理
    * @author sunhuai
    * @version
    * @date 2014/8/7 17:28:02
 */

class Nav {
    private $CI = null;
    private $collection = null;

    function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('Mongod');
        $this->collection = $this->CI->mongod->selectCollection('whale_nav');
        if (!$this->collection) {
            $this->collection = $this->CI->mongod->createCollection('whale_nav', array(
                'capped' => false,
            ));
        }
    }

    //获取用户的导航信息 包含管理员和默认的欢迎导航
    public function get_app_nav() {
        $welcome_nav = $this->get_welcome_nav();
        $user_nav = $this->get_user_nav();
        $nav = array_merge($welcome_nav, $user_nav);
        if ($this->CI->user->type >= USER_APP_ADMIN) {
            $system_nav = $this->get_system_nav();
            $nav = array_merge($nav, $system_nav);
        }
        return $nav;
    }

    //获取用户的导航信息 不包括管理员和默认的欢迎导航
    public function get_user_nav($app = '') {
        if (!$app) {
            $app = APPNAME;
        }
        $result = array();
        $channel_id_list = array();
        $channel_id_obj_list = array();
        $condition = array();
        //mp管理员和app管理员 直接获取所有的导航
        if ($this->CI->userPower->auth_user_type(array(USER_MP_ADMIN, USER_APP_ADMIN))) {
            $condition = array(
                'app' => $app,
            );
        } else {
            //获取用户组以及其频道id
            $this->CI->load->library('user_group');
            $channel_id_list = $this->CI->user_group->get_channel_id_list($app);
            if ($channel_id_list) {
                foreach ($channel_id_list as $channel_id) {
                    $channel_id_obj_list[] = new MongoId($channel_id);
                }
                $condition = array(
                    'channel_list.channel_id' => array(
                        '$in' => $channel_id_obj_list,
                    ),
                );
            }
        }
        //获取导航数据结果
        if ($condition) {
            $cursor = $this->collection->find($condition)->sort(array('_id' => 1));
            if ($cursor) {
                foreach ($cursor as $one) {
                    $id = (string)$one["_id"];
                    $result[$id] = $one;
                    $result[$id]['_id'] = $id;
                }
            }
        }
        if ($result) {
            //处理数据结果
            foreach ($result as $k => $group) {
                if (isset($group['channel_list'])
                    && $group['channel_list']) {
                    foreach ($group['channel_list'] as $channel_k => $channel) {
                        //前端数据调用
                        $result[$k]['channel_list'][$channel_k]['_id'] = $group['_id'];
                        $result[$k]['channel_list'][$channel_k]['channel_id'] = (string)$channel['channel_id'];
                    }
                }
            }
            //移除多余的无权限频道
            if ($channel_id_list) {
                foreach ($result as $k => $group) {
                    if (isset($group['channel_list'])
                        && $group['channel_list']) {
                        foreach ($group['channel_list'] as $channel_k => $channel) {
                            if (!in_array($channel['channel_id'], $channel_id_list)) {
                                unset($result[$k]['channel_list'][$channel_k]);
                            }
                        }
                    }
                }

            }
        }
        return $result;
    }

    //管理员级别用户的系统导航
    public function get_welcome_nav() {
        return array(
            'welcome' => array(
                'name' => '欢迎',
                'channel_list' => array(
                    array(
                        'name' => '欢迎',
                        'link' => '/' . APPNAME,
                    ),
                ),
            ),
        );
    }

    //管理员级别用户的系统导航
    public function get_system_nav() {
        return array(
            'system' => array(
                'name' => '系统功能',
                'channel_list' => array(
                    array(
                        'name' => '导航管理',
                        'link' => '/whale/nav/index?app=' . APPNAME,
                        'target' => '_blank',
                    ),
                    array(
                        'name' => '用户管理',
                        'link' => '/whale/user/manage?app=' . APPNAME,
                        'target' => '_blank',
                    ),
                    array(
                        'name' => '角色管理',
                        'link' => '/whale/user/group?app=' . APPNAME,
                        'target' => '_blank',
                    ),
                    array(
                        'name' => '操作日志查看',
                        'link' => '/whale/log/op?app=' . APPNAME,
                        'target' => '_blank',
                    ),
                ),
            )
        );
    }

    //频道组
    public function add_group($app = '', $name = '') {
        $data = array(
            'name' => $name,
            'app' => $app,
        );
        return $this->collection->insert($data);
    }

    public function edit_group($id, $name) {
        $newData = array(
            '$set' => array(
                'name' => $name,
            ),
        );
        $condition = array(
            '_id' => new MongoId($id),
        );
        return $this->collection->update($condition, $newData);

    }

    public function del_group($id) {
        $limit = array(
            'justOne' => true,
        );
        $condition = array(
            '_id' => new MongoId($id),
        );
        return $this->collection->remove($condition, $limit);

    }

    //频道
    public function add_channel($id, $name, $url) {
        $condition = array(
            '_id' => new MongoId($id),
        );
        $group = $this->collection->findOne($condition);
        if (!$group) {
            return false;
        }
        $channel_data = array(
            'channel_id' => new MongoId(),
            'name' => $name,
            'link' => $url,
        );
        $data = array(
            '$push' => array(
                'channel_list' => $channel_data,
            )
        );
        return $this->collection->update($condition, $data);
    }

    public function edit_channel($id, $channel_id, $name, $url) {
        $condition = array(
            '_id' => new MongoId($id),
            'channel_list.channel_id' => new MongoId($channel_id),
        );
        $group = $this->collection->findOne($condition);
        if (!$group) {
            return false;
        }
        $key = '';
        foreach ($group['channel_list'] as $index => $channel) {
            if ($channel_id == ((string)$channel['channel_id'])) {
                $key = 'channel_list.' . $index;
                break;
            }
        }
        $data = array(
            '$set' => array(
                $key . '.name' => $name,
                $key . '.link' => $url,
            )
        );
        return $this->collection->update($condition, $data);
    }

    public function del_channel($id, $channel_id) {
        $condition = array(
            '_id' => new MongoId($id),
            'channel_list.channel_id' => new MongoId($channel_id),
        );
        $data = array(
            '$pull' => array(
                'channel_list' => array(
                    'channel_id' => new MongoId($channel_id),
                ),
            ),
        );
        return $this->collection->update($condition, $data);
    }
}
