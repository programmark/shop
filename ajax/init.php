<?php

    //初始化
    require dirname(__FILE__) . '/../common.php';

    $cmd = isset($_GET['cmd']) ? '_' . $_GET['cmd'] : '_' . $_POST['cmd'];
    if (function_exists($cmd)) {
        $cmd();
    } else {
        die("Params Error");
    }
    
    function request($param) {
        return  (isset($_GET[$param]) && !empty($_GET[$param])) ? $_GET[$param] : (isset($_POST[$param]) && !empty($_POST[$param]) ? $_POST[$param] : "") ;
    }
    

    