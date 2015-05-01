<?php

    class oo {

        public static $config = array();

        public function __construct() {
            
        }

        /**
         * 
         * @return \debugModel
         */
        public static function logs() {
            if (!isset(self::$config['logs'])) {
                include_once PATH_MODEL . DS . 'class.logs.php';
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
                include_once PATH_MODEL . DS . 'class.mail.php';
                self::$config['mail'] = new mail();
            }
            return self::$config['mail'];
        }

        public static function payment() {
            if (!isset(self::$config['payment'])) {
                include_once PATH_MODEL . DS . 'class.payment.php';
                self::$config['memcached'] = new payment();
            }
            return self::$config['payment'];
        }

    }
    