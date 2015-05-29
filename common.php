<?php

    define("IN_WEB", true);
    define("WEB_ROOT", __DIR__);
    define("DS", DIRECTORY_SEPARATOR);
    define("PS", PATH_SEPARATOR);
    define("PRODUCTION_SERVER", true);
    define("PATH_MODEL", WEB_ROOT . DS . 'model');
    define("PATH_LIB", WEB_ROOT . DS . 'lib');
    define("PATH_CONFIG", WEB_ROOT . DS . 'config');
    define("PATH_CFG", WEB_ROOT . DS . 'cfg');
    define("PATH_VIEW", WEB_ROOT . DS . 'view');
    define("PATH_LANG", WEB_ROOT . DS . 'lang');

    include(PATH_MODEL . DS . 'oo.php');
    include (PATH_MODEL . DS . 'odb.php');//实现业务分db
    include(PATH_MODEL . DS . 'ocache.php');//实现业务分cache
    include(PATH_MODEL . DS . 'otable.php');
    include(PATH_LIB . DS . 'functions.php');
    include(PATH_LIB . DS . 'okey.php');

    functions::session_start();
    header('Content-type: text/html;charset=UTF-8');

    function p() {
        $aP = func_get_args();
        $ret = debug_backtrace();
        echo '◆ ' . $ret[0]['file'] . '  Line ' . $ret[0]['line'] . "<br>";
        if (func_num_args() === 1) $aP = $aP[0];
        print_r($aP);
        exit;
    }

    function f() {
        $aP = func_get_args();
        $ret = debug_backtrace();
        echo '◆ ' . $ret[0]['file'] . ' Line ' . $ret[0]['line'] . "<br>";
        $filepath =  WEB_ROOT . DS . 'logs' . DS . $aP[0] . '.php';
        if (!file_exists($filepath))die("文件不存在");
        $string = file_get_contents($filepath);//$string = str_replace("\n", "<br>", $string); // ok
        echo nl2br($string); // ok
        die;
    }

    function microtime_float() {
        list($usec, $sec) = explode(" ", microtime());
        return ((float) $usec + (float) $sec);
    }

    function alterMsg($msg, $start_time = '') {
        $start_time = $start_time ? $start_time : microtime_float();
        $end_time = microtime_float();
        $runtime = round(($end_time - $start_time) * 1000);
        echo "$msg  (times:" . $runtime . "ms);<br>";
    }
    