<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
    * @file User_group.php
    * @brief 用户组
    * @author sunhuai(v_sunhuai@baidu.com)
    * @version 
    * @date 2014/9/14 22:54:53
 */

class User_group
{
    private $CI = null;
    private $collection = null;

    function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->library('Mongod');
        $this->collection = $this->CI->mongod->selectCollection('whale_user_group');
        if (!$this->collection) {
            $this->collection = $this->CI->mongod->createCollection('whale_user_group', array(
                'capped' => false,
            ));
        }
    }

    public function get_list($app = '') {
        $condition = array(
            'app' => $app,
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

    //获取用户组的信息
    public function get_one($id = '') {
        if (!$id) {
            return array();
        }
        $condition = array(
            '_id' => new MongoId($id),
        );
        $row = $this->collection->findOne($condition);
        if ($row) {
            $row['_id'] = (string)$row["_id"];
        }
        return $row;
    }

    /**
        * @brief 
        *
        * @param $info 参数数组
        *
        * @returns 
     */
    public function add($info) {
        if (!isset($info['app'])
            || !isset($info['channel_id_list'])
            || !isset($info['name'])
        ) {
            return false;
        }
        return $this->collection->insert($info);
    }

    public function edit($info) {
        if (!isset($info['id'])
            || !isset($info['channel_id_list'])
            || !isset($info['name'])
        ) {
            return false;
        }
        $condition = array(
            '_id' => new MongoId($info['id']),
        );
        unset($info['id']);
        $data = array(
            '$set' => $info,
        );
        return $this->collection->update($condition, $data);
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

    public function get_many($condition) {
        $result = array();
        $cursor = $this->collection->find($condition)->sort(array('_id' => 1));
        if ($cursor) {
            foreach ($cursor as $one) {
                $id = (string)$one["_id"];
                $result[$id] = $one;
                $result[$id]['_id'] = $id;
            }
        }
        return $result;
    }

    //获取用户的频道id列表
    public function get_channel_id_list($app) {
        $user_info = $this->CI->user->info;
        $channel_id_list = array();
        $group_id_list = array();
        if (isset($user_info['group_list'])) {
            foreach ($user_info['group_list'] as $group_id) {
                $group_id_list[] = new MongoId($group_id);
            }
        }
        $condition = array(
            '_id' => array(
                '$in' => $group_id_list,
            ),
        );
        //获取用户组以及其频道id
        $user_group_list = $this->get_many($condition);
        if ($user_group_list) {
            foreach ($user_group_list as $group) {
                $channel_id_list = array_merge($channel_id_list, $group['channel_id_list']);
            }
            $channel_id_list = array_unique($channel_id_list);
            return $channel_id_list;
        }
        return array();
    }

    //获取用户的频道列表
    public function get_channel_list ($app) {
        $channel_id_list = $this->get_channel_id_list($app);
        if (!$channel_id_list) {
            return array();
        }
        foreach ($channel_id_list as $channel_id) {
            $channel_id_obj_list[] = new MongoId($channel_id);
        }
        $condition = array(
            'channel_list.channel_id' => array(
                '$in' => $channel_id_obj_list,
            ),
        );
        $channel_list = array();
        $collection = $this->CI->mongod->selectCollection('whale_nav');
        $cursor = $collection->find($condition)->sort(array('_id' => 1));
        if ($cursor) {
            foreach ($cursor as $one) {
                foreach ($one['channel_list'] as $channel) {
                    $channel_id = (string)$channel['channel_id'];
                    if (in_array($channel_id, $channel_id_list)) {
                        $channel_list[] = $channel;
                    }
                }
            }
        }
        return $channel_list;
    }
}

