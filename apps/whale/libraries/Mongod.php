<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mongod
{
    public $CI = null;
    private $client = null;
    private $db = null;
    private $config = array();
    private $serverStatus = true;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->config('mongodb');
        $this->config = $this->CI->config->item('mongo');
        $this->connect();
    }

    private function connect() {
        $dbName = $this->config['db'];
        $auth = '';
        if (isset($this->config['username']) && isset($this->config['password'])) {
            $auth .= $this->config['username'] . ':' . $this->config['password'] . '@';
        }
        $server = 'mongodb://' . $this->config['host'] . ':' . $this->config['port'];
        $opt = $this->config['opt'];
        try {
            $this->client = new MongoClient($server, $opt);
        } catch(MongoConnectionException $e) {
            $info_msg = 'mongo connection error';
            $info_msg .= ' exception ' . $e->getMessage();
            log_message('info', $info_msg);
            $this->serverStatus = false;
            return false;
        }
        $this->db = $this->client->selectDB($dbName);
        return true;
    }

    public function selectCollection($collectionName) {
        if (!$this->serverStatus) {
            return false;
        }
        return $this->db->selectCollection($collectionName);
    }

    public function createCollection($name, $opt) {
        if (!$this->serverStatus) {
            return false;
        }
        return $this->db->createCollection($name, $opt);
    }
}

