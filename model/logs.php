<?php

class logs extends otable {

    public function __construct() {
        
    }

    /*** 记录日志
     * @param $string
     * @param $file
     * @param int $size
     * @param bool $isudp
     * @return bool|int
     */
    public function debug($string, $file, $size = 1, $isudp = false) {
        if (empty($string) || empty($file)) return -1;
        if (PRODUCTION_SERVER && $isudp) { //线上和备机房
            $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
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
            (filesize($file) > $size * 1024 * 1024) && copy($file, '/tmp/'.$file) && unlink($file); //1M
        }
        file_put_contents($file, $string . "\n", FILE_APPEND);
    }

    /** 扣钱，加钱
     * @param $mid
     * @param $count
     * @param int $flag
     * @param string $desc
     */
    public function addWin($mid, $count, $flag = 0, $desc = '') {
        
    }

    /** 预警队列
     * @param $key
     * @param $data
     * @param bool $db
     */
    public function warning($key, $data, $db = false) {
        $len = ocache::muredis()->rPush($key, $data);
        oo::logs()->debug(date("Y-m-d H:i:s"). ' len ' . $len . ' data ' . $data, 'warning.txt');
        if ($db) {
            $query = "INSERT INTO " . oo::logs()->warning . " (id, key, comment) VALUES (NULL, '$key', '$data')";
            odb::db()->query($query);
        }
    }

    /** 发送任务
     * @param $key
     */
    public function task($key, $cmd='') {
        if ($cmd == 'size') {

        }
        $aRet = explode('+_+', ocache::muredis()->rPop($key));
        if (!empty($aRet[0])) {
            $t = oo::$config['mailname'];
            if (count($t) > 1) {
                foreach ($t as $k => $v) {
                    oo::mail()->send(array($v, $aRet[0], $aRet[1]));
                }
            } else {
                oo::mail()->send(array($t[0], $aRet[0], $aRet[1]));
            }
        }
    }

}
