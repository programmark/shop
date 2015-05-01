<?php

    class mumongo {

        private $_client = null;
        private $_con = null;

        /*
         * mongo 集群
         */

        public function __construct($aServers = null) {
            if (is_array($aServers) && !empty($aServers)) {
                
            }
        }

        /**
         * 
         */
        public function connect() {
            if (file_exists(PATH_CONFIG . DS . 'app.ini')) {
                try {
                    $aIni = parse_ini_file(PATH_CONFIG . DS . 'app.ini', true);
                    $host = $aIni['mongo']['host'];
                    $port = $aIni['mongo']['port'];
                    $db = $aIni['mongo']['db'];
                    $this->_con = new MongoClient("mongodb://{$host}:{$port}");
                    $this->_client = $this->_con->selectDB($db);
                } catch (MongoConnectionException $exc) {
                    echo $exc->getTraceAsString();
                    die;
                }
                return true;
            }
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
    