<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @file MongoBaseCollection.php
 * @brief mongodb,collection操作
 * @author sunhuai
 * @version 1
 * @date 2014/12/31 15:21:43
 */
class MongoBaseCollection
{
    private $collection = null;
    public $CI = null;

    public function __construct($config = array())
    {
        $this->CI = &get_instance();
        $this->CI->load->library('Mongod');
        $collectionName = isset($config['collection']) ? $config['collection'] : '';
        if (!$collectionName)
        {
            exit("are u kidding me?");
        }
        $collectionName = Whale::$app . '_' . $collectionName;
        $this->collection = $this->CI->mongod->selectCollection($collectionName);
        if (!$this->collection) {
            $this->collection = $this->CI->mongod->createCollection($collectionName, array(
                'capped' => false,
            ));
        }
    }

    function getListInfo($offset = 0, $size = 20, $condition = array())
    {
        $result = array();
        $result['list'] = array();
        $result['count'] = $this->collection
            ->find($condition)->count();
        if ($result['count'] == 0) {
            return $result;
        }
        $cursor = $this->collection
            ->find($condition)
            ->sort(array('_id' => -1))
            ->skip($offset)
            ->limit($size);
        if ($cursor)
        {
            $list = array();
            foreach ($cursor as $one)
            {
                $id = (string)$one["_id"];
                $list[$id] = $one;
                $list[$id]['_id'] = $id;
            }
            $result['list'] = $list;
        }
        return $result;
    }

    function add($info)
    {
        return $this->collection->insert($info);
    }

    /**
     * batch add
     * @param array
     * @return boolean
     */
    public function batchAdd($infoList)
    {
        return $this->collection->batchInsert($infoList);
    }

    function update($id, $info)
    {
        $newdata = array(
            '$set' => $info,
        );
        $condition = array(
            '_id' => new MongoId($id),
        );
        return $this->collection->update($condition, $newdata);
    }

    function remove($id)
    {
        $limit = array(
            'justOne' => true,
        );
        $condition = array(
            '_id' => new MongoId($id),
        );
        return $this->collection->remove($condition, $limit);

    }

    public function getAll($condition = array())
    {
        $cursor = $this->collection
            ->find($condition)
            ->sort(array('_id' => -1));
        if ($cursor)
        {
            $list = array();
            foreach ($cursor as $one)
            {
                $id = (string)$one["_id"];
                $list[$id] = $one;
                $list[$id]['_id'] = $id;
            }
            return $list;
        }
        return array();
    }

    /**
     * get collection
     *
     * @return object
     */
    public function getCollection()
    {
        return $this->collection;
    }
}
