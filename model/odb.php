<?php

    class odb {

        public static $config = array();

        public static function db() {
            if (!isset(self::$config['db'])) {
                include PATH_LIB . DS . 'class.mudb.php';
                $param = array();
                self::$config['db'] = new mudb($param);
            }
            return self::$config['db'];
        }

        public static function dbslave() {
            if (!isset(self::$config['dbslave'])) {
                include PATH_LIB . DS . 'class.mudb.php';
                $param = array();
                self::$config['dbslave'] = new mudb($param);
            }
            return self::$config['dbslave'];
        }

    }
    