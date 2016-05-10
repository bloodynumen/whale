<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @file User.php
 * @brief 用户信息
 * @author sunhuai
 * @version
 * @date 2014/8/7 17:28:02
 */
class User
{
    private $CI = null;
    private $collection = null;
    var $type = 0;//用户类型
    var $app = '';
    var $info = array();

    function __construct() {
        session_start();
        $this->CI = &get_instance();
        $this->CI->load->library('Mongod');
        $this->collection = $this->CI->mongod->selectCollection('whale_user');
        if (!$this->collection) {
            $this->collection = $this->CI->mongod->createCollection('whale_user', array(
                'capped' => false,
            ));
        }
        $name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
        if ($name) {
            $this->info = $this->get_user_info($name);
        }
    }

    public function isLogin()
    {
        return $this->info == false ? false : true;
    }
    public function login($name = '', $password = '')
    {
        $info = $this->get_user_info($name, $password);
        if (!$info) {
            return false;
        }
        $_SESSION['name'] = $name;
        $this->info = $info;
        return true;
    }

    public function logout()
    {
        unset($_SESSION['name']);
    }

    public function get_user_list($app) {
        $condition = array(
            'app' => array(
                '$in' => array($app, ''),
            ),
            'type' => array(
                '$lte' => $this->type,//小于等于当前用户权限的
            ),
        );
        $cursor = $this->collection->find($condition);
        $result = array();
        if ($cursor) {
            foreach ($cursor as $one) {
                $id = (string)$one["_id"];
                $result[$id] = $one;
                $result[$id]['_id'] = $id;
            }
        }
        return $result;
    }

    //获取用户的信息
    public function get_user_info($name = '', $password = '') {
        $result = array();
        $condition = array(
            'name' => $name,
        );
        if ($password) {
            $condition['password'] = md5($password);
        }
        $user_info = $this->collection->find($condition, array('_id', 'name', 'type', 'group_list', 'app'))->sort(array('app' => 1))->limit(1)->getNext();
        if ($user_info) {
            $id = (string)$user_info["_id"];
            $user_info[$id]['_id'] = $id;
            $this->app = $user_info['app'];
            $this->type = $user_info['type'];
        }
        return $user_info;
    }

    /**
     * @brief
     *
     * @param $info 参数数组
     *   type USER_MP_ADMIN=>平台管理员 USER_APP_ADMIN=>产品线 管理员 USER_NORMAL=> 普通用户
     *
     * @returns
     */
    public function add($info) {
        if (
            !isset($info['name'])
            || !isset($info['app'])
            || !isset($info['type'])
        ) {
            return false;
        }
        $name = $info['name'];
        if ($info['type'] == USER_MP_ADMIN) {
            $info['app'] = '';
        }
        $user_info = $this->collection->findOne(array(
            'name' => $info['name'],
            'app' => $info['app'],
        ));

        if ($user_info) {
            return false;
        } else {
            return $this->collection->insert($info);
        }
    }

    public function edit($info) {
        if (
            !isset($info['id'])
            || !isset($info['app'])
            || !isset($info['type'])
        ) {
            return false;
        }

        $condition =  array(
            '_id' => new MongoId($info['id']),
        );
        unset($info['id']);
        if ($info['type'] == USER_MP_ADMIN) {
            $info['app'] = '';
        }
        $data = array(
            '$set' => $info,
        );
        return $this->collection->update($condition, $data);
    }

    public function remove_app_user($name, $app) {
        $limit = array(
            'justOne' => true,
        );
        $condition = array(
            '_id' => new MongoId($id),
        );
        return $this->collection->update($condition, $limit);

    }

    public function del($id) {
        $limit = array(
            'justOne' => true,
        );
        $condition = array(
            '_id' => new MongoId($id),
        );
        return $this->collection->remove($condition, $limit);
    }

    //验证用户的类型
    public function auth_type($allow = array()) {
        return in_array($this->type, $allow);
    }
}
