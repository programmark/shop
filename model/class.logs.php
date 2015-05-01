<?php

    class logs extends otable {

        public function __construct() {
            
        }

        /*
         * 记录日志
         */

        public function debug($string, $file) {
            if (empty($string) || empty($file)) return -1;
            $file =  WEB_ROOT . DS . "logs" . DS  . $file . ".php";
            if (PRODUCTION_SERVER) { //线上和备机房
                $dirname = dirname($file);
                if (!is_dir($dirname)) @mkdir($dirname, 0777, true);
                if (file_exists($file)) {
                    (filesize($file) > 1 * 1024 * 1024) && unlink($file);//1M
                }
                file_put_contents($file, $string . "\n", FILE_APPEND);
            }
        }

        /**
         * 扣钱，加钱
         * 
         */
        public function addWin($mid, $count, $flag = 0, $desc = '') {
            
        }

    }
    