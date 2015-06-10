<?php

class logs extends otable {

    public function __construct() {
        
    }

    /*
     * 记录日志
     */

    public function debug($string, $file, $isudp = false) {
        if (empty($string) || empty($file)) return -1;
        if (PRODUCTION_SERVER && $isudp) { //线上和备机房
            $socket = socket_create(AF_INET, sock_, SOL_UDP);
            $pieces = array($string, $file);
            $content = implode(',', $pieces);
            socket_sendto($socket, $content, strlen($content), 0, '192.168.1.104', 50001);
            return true;
        }
        $file = WEB_ROOT . DS . "logs" . DS . $file . ".php";
        $dirname = dirname($file);
        if (!is_dir($dirname))
            @mkdir($dirname, 0777, true);
        if (file_exists($file)) {
            (filesize($file) > 1 * 1024 * 1024) && copy($file, '/tmp/'.$file) && unlink($file); //1M
        }
        file_put_contents($file, $string . "\n", FILE_APPEND);
    }

    /**
     * 扣钱，加钱
     */
    public function addWin($mid, $count, $flag = 0, $desc = '') {
        
    }

    /** 预警
     * @param $str
     */
    public function warning($str) {
        $key = okey::warning();
        ocache::muredis()->rPush($str);
    }

}
