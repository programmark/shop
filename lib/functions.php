<?php

class functions {

    /** remote ip 客户端ip
     * @return string
     */
    public static function getIp() {
        $ip = $_SERVER['REMOTE_ADDR'];
        return (string) $ip;
    }

    /** cli 模式 获取服务器IP
     * @return string
     */
    public static function getServerIp() {
        if (php_sapi_name() == "cli") {
            $ss = exec('/sbin/ifconfig eth0 | sed -n \'s/^ *.*addr:\\([0-9.]\\{7,\\}\\) .*$/\\1/p\'', $arr);
            return $arr[0];
        }
        return (string) $_SERVER['HTTP_HOST'];
    }

    /**
     * @param $url
     * @param int $timeout
     * @param bool $post 是否post链接 默认get
     * @return array|mixed|string
     */
    public static function curl($url, $data = array(), $timeout = 20, $post = false) {
        if (function_exists('curl_init')) {
            $ch = curl_init();
            $data = http_build_query($data);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
            if ($post) {
                curl_setopt($ch, CURLOPT_POST, 1);//设置为POST方式
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//POST数据
            } else {
                curl_setopt($ch, CURLOPT_URL, $url .'?' .$data);
            }
            curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
            $data = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //return ($httpcode >= 200 && $httpcode < 300) ? $data : false;
            curl_close($ch);
            if ($httpcode != 200) return array();
            if (!$data) {
                $ctx = stream_context_create(array(
                        'http' => array(
                            'timeout' => 1
                        )
                    )
                );
                $data = @file_get_contents($url, 0, $ctx);
            }
            return $data;
        }
    }

    /**
     * session start
     */
    public static function session_start() {
        ini_set("session.save_handler", "redis");
        ini_set("session.save_path","tcp://192.168.1.103:6379");
        ini_set("session.gc_maxlifetime", 24 * 60 * 60);//24 hour
        if (!session_id()) {
            session_start();
        }
    }

    /**
     * @param $param
     */
    public static function session($param) {
        if (is_array($param)) {
            $_SESSION['user']['username'] = $param['username'];
            $_SESSION['user']['id'] = $param['id'];
        }
    }

    /**
     * @param $key
     * @param $val
     * @param int $time
     * @param string $domain
     */
    public static function setcookie($key, $val, $time = 0, $domain = '/') {
        $time = time() + $time;
        setcookie($key, $val, $time, $domain);
    }

    /**
     * @return float
     */
    public static function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    /**
     * @param $msg
     * @param string $start_time
     */
    public static function alterMsg($msg, $start_time = '') {
        $start_time = $start_time ? $start_time : microtime_float();
        $end_time = microtime_float();
        $runtime = round(($end_time - $start_time) * 1000);
        echo "$msg  (times:" . $runtime . "ms);<br>";
    }

    public static function init() {
        self::session_start();//开启session
        if (php_sapi_name() != 'cli') {//非命令行
            ocache::muredis()->inrc(okey::pv(), 1);//统计每日PV
        }
    }

}
