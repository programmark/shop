<?php

    class odb {

        public static $config = array();

        public static function db() {
            if (!isset(self::$config['db'])) {
                include_once PATH_LIB . DS . 'class.mudb.php';
                self::$config['db'] = new mudb(oo::$config['mysql'], false);
            }
            return self::$config['db'];
        }

        public static function dbslave() {
            if (!isset(self::$config['dbslave'])) {
                include_once PATH_LIB . DS . 'class.mudb.php';
                self::$config['dbslave'] = new mudb(oo::$config['mysql'], false);
            }
            return self::$config['dbslave'];
        }

    }
    