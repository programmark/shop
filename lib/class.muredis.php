<?php

    class muredis {

        private $_redis = null;
        private $_connect = null;

        public function __construct() {
            $this->_redis = new Redis();
        }

        public function connect() {
            if (!class_exists("Redis"))die("Requires Redis Excption");
            $aIni = parse_ini_file(PATH_CONFIG . DS . 'app.ini', true);
            $host = $aIni['redis']['host'];
            $port = $aIni['redis']['port'];
            for ($try = 0; $try < 3; $try++) {
                $flag = $this->_redis->connect($host, $port);
                if ($flag){
                    break;
                }
            }
            $flag && $this->_connect = TRUE;
            return $flag;
        }

        public function get($key) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->get($key);
            }
        }

        public function set($key, $value) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->set($key, $value);
            }
        }

        /**
         * 
         * @param type $key
         * @param type $value
         * @param type $offst 0 增 1减
         * @return type
         */
        public function inrc($key, $value, $offst = 0) {
            oo::logs()->debug(date("Y-m-d H:i:s") .__LINE__, "redis.txt");
            if (!empty($key) && $this->connect()) {
                oo::logs()->debug(date("Y-m-d H:i:s"). __LINE__, "redis.txt");
                $offst ? ($ret = $this->_redis->decr($key, $value)) : ($ret = $this->_redis->incr($key, $value));
                return $ret;
            }
        }

        public function delete($key) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->delete($key);
            }
        }
        
        public function close() {
            $this->_redis->close();
            $this->_redis = null;
            $this->_connect = null;
        }
        
        //public function __destruct() {
        //    $this->_redis->close();
        //}

    }
    