<?php

    class mumemcached {

        private $_mem = null;
        private $_connected = null;//是否已连接

        public function __construct() {
            $this->_mem = new Memcached();
        }

        /*
         * connect
         */

        public function connect() {
            if ($this->_mem && $this->_connected) {
                return true;
            } else {
                $aIni = parse_ini_file(PATH_CONFIG . DS . 'app.ini', true);
                $host = $aIni['memcached']['host'];
                $port = $aIni['memcached']['port'];
                //重连三次
                for ($try = 0; $try < 3; $try++) {
                    $flag = $this->_mem->addServer($host, $port);
                    if ($flag) {
                        $this->_connected = true;
                        break;
                    }
                }
                if (!class_exists("Memcached")) die("Requires Memcached Excption");
                $try == 2 && !$flag && oo::logs()->debug(date("Y-m-d H:i:s") . " memcached unconnect", "memcachederror.txt");
                return $flag ? $flag : 0;
            }
        }

        public function get($key) {
            if ($key && $this->connect()) {
                return $this->_mem->get($key);
            }
        }

        public function set($key, $value, $expiration = 86400) {
            if ($key && $this->connect()) {
                return $this->_mem->set($key, $value, $expiration);
            }
        }

        /**
         * 
         * @param type $key
         * @param type $offset
         * @param int $flag 0加1减
         * @return type
         */
        public function increment($key, $offset, $flag = 0) {
            if ($key && $this->connect()) {
                $flag ? ($ret = $this->_mem->decrement($key, $offset)) : ($ret = $this->_mem->increment($key, $offset));
                if ($this->_mem->getResultCode() == Memcached::RES_NOTFOUND) {
                    oo::logs()->debug(date("Y-m-d H:i:s"). __FILE__ . " " . __LINE__, "incre_txt");
                    $this->_mem->set ($key, 0);
                    //$flag ? ($ret = $this->_mem->decrement($key, $offset)) : ($ret = $this->_mem->increment($key, $offset));
                }
                if ($this->_mem->getResultCode() == Memcached::RES_SUCCESS)return $ret;
            }
        }

        public function delete($key) {
            if ($key && $this->connect()) {
                $this->_mem->delete($key);
                if ($this->_mem->getResultCode() == Memcached::MEMCACHED_SUCCESS) {
                    return true;
                } else {
                    return false;
                }
            }
        }

        public function getMulti(array $keys) {
            if ($keys && $this->connect()) {
                return $this->_mem->getMulti($keys);
            }
        }

        public function setOption($options) {
            if ($this->connect()) {
                $this->_mem->setOptions($options);
            }
        }
        
        public function close() {
            if ($this->connect()) {
                $this->_mem = $this->_connected = null;
            }
        }

    }
    