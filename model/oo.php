<?php

    class oo {

        public static $config = array();

        public function __construct() {

        }

        public static function config($config) {
            self::$config =  array_merge($config, self::$config);
        }

        /**
         * @return mixed
         */
        public static function logs() {
            if (!isset(self::$config['logs'])) {
                include_once PATH_MODEL . DS . 'logs.php';
                self::$config['logs'] = new logs();
            }
            return self::$config['logs'];
        }

        /**
         * 
         * @return type
         */
        public static function smarty() {
            if (!isset(self::$config['smarty'])) {
                include_once PATH_LIB . DS . 'smarty' . DS . 'libs' . DS . 'Smarty.class.php';
                self::$config['smarty'] = new Smarty();
                self::$config['smarty']->compile_dir = PATH_LIB . DS . 'smarty' . DS . 'templates_c';
            }
            return self::$config['smarty'];
        }

        /**
         * 
         * @return type
         */
        public static function mail() {
            if (!isset(self::$config['mail'])) {
                include_once PATH_LIB . DS . 'class.mail.php';
                self::$config['mail'] = new mail();
            }
            return self::$config['mail'];
        }

        /**
         * @return mixed
         */
        public static function payment() {
            if (!isset(self::$config['payment'])) {
                include_once PATH_MODEL . DS . 'payment.php';
                self::$config['memcached'] = new payment();
            }
            return self::$config['payment'];
        }


        /**
         * @return mixed
         */
        public static function minfo(){
            if (!isset(self::$config['minfo'])) {
                include_once PATH_MODEL . DS . 'minfo.php';
                self::$config['minfo'] = new minfo();
            }
            return self::$config['minfo'];
        }

    }
    