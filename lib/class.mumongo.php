<?php

    class mumongo {

        private $_client = null;
        private $_connect = null;
        private $_connectd = null;//是否已连接
        private $aServer = array();

        /*
         * mongo 集群
         */

        public function __construct($aServers = null) {
            if (empty($aServers) || !is_array($aServers)) {
                return false;
            }
            $this->aServer = $aServers;
        }

        /**
         * 
         */
        public function connect() {
            if ($this->_connectd) {
                return $this->_connectd;
            } else  {
                $host = $this->aServer['host'];
                $port = $this->aServer['port'];
                $db = $this->aServer['db'];
                try {
                    $this->_connect = new MongoClient("mongodb://{$host}:{$port}");
                    $this->_client = $this->_connect->selectDB($db);
                    $this->_connectd = true;
                } catch (MongoConnectionException $exc) {
                    $this->_connectd = false;
                    oo::logs()->debug(date("Y-m-d H:i:s") . $exc->getTraceAsString(), 'mumongoerror.txt');
                    echo $exc->getTraceAsString();
                }
            }
            return $this->_connectd;
        }

        public function selectCollection($table) {
            if ($table && $this->connect()) {
                return $this->_client->selectCollection($table);
            } else {
                //错误日志
            }
        }

        public function findOne($table, $key) {
            return $this->selectCollection($table)->findOne(array('_id' => $key));
        }

        public function update($table, $key, $aRet) {
            if (!empty($key)) {
                return $this->selectCollection($table)->insert(array('_id' => $key, 'content' => $aRet));
            } else {
                
            }
        }

        public function get($table, $key) {
            if ($table && ($this->selectCollection($table))) {
                return $this->findOne($table, $key);
            }
        }

        public function set($table, $key, $aRet) {
            return $this->update($table, $key, $aRet);
        }

        public function hSet($table, $key, $aRe) {
            if ($this->selectCollection($table)) {
                
            }
        }

        public function delete($table, $key) {
            if ($table && $key) {
                return $this->selectCollection($table)->remove(array("_id" => $key));
            }
        }

        public function remove($table, $key) {
            if ($table && $key) {
                return $this->selectCollection($table)->remove(array("_id" => $key));
            }
        }

        public function __destruct() {
            
        }

    }
    