<?php

    class ocache {

        public static $config = array();

        /**
         * 
         * @return type
         */
        public static function mumongo() {
            if (!isset(self::$config['mongo'])) {
                include_once PATH_LIB . DS . 'class.mumongo.php';
                self::$config['mumongo'] = new mumongo();
            }
            return self::$config['mumongo'];
        }

        /**
         * 
         * @return type
         */
        public static function mumemcached() {
            if (!isset(self::$config['mumemcached'])) {
                include_once PATH_LIB . DS . 'class.mumemcached.php';
                self::$config['mumemcached'] = new mumemcached();
            }
            return self::$config['mumemcached'];
        }
        
        /**
         * 
         * @return type
         */
        public static function muredis() {
            if (!isset(self::$config['muredis'])) {
                include PATH_LIB . DS . 'class.muredis.php';
                self::$config['muredis'] = new muredis();
            }
            return self::$config['muredis'];
        }

    }
    