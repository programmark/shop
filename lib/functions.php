<?php

class functions {

    //remote ip 客户端ip
    public static function getIp() {
        $ip = $_SERVER['REMOTE_ADDR'];
        return (string) $ip;
    }

    //cli 模式 获取服务器IP
    public static function getServerIp() {
        if (php_sapi_name() == "cli") {
            $ss = exec('/sbin/ifconfig eth0 | sed -n \'s/^ *.*addr:\\([0-9.]\\{7,\\}\\) .*$/\\1/p\'', $arr);
            return $arr[0];
        }
        return (string) $_SERVER['HTTP_HOST'];
    }

    public static function curl($url, $timeout = 20) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $data = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //return ($httpcode >= 200 && $httpcode < 300) ? $data : false;
        curl_close($ch);
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
    
    public static function session_start() {
        if (empty(session_id())) {
            session_start();
        }
    }

    public static function session($param){
        if (is_array($param)) {
            $_SESSION['user']['username'] = $param['username'];
            $_SESSION['user']['id'] = $param['id'];
        }
    }

}
