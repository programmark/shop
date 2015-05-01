<?php

    //初始化
    require '../common.php';

    $cmd = isset($_GET['cmd']) ? '_' . $_GET['cmd'] : '_' . $_POST['cmd'];
    if (!empty($cmd)) {
        $cmd();
    }
    
    function request($param) {
        return  (isset($_GET[$param]) && !empty($_GET[$param])) ? $_GET[$param] : (isset($_POST[$param]) && !empty($_POST[$param]) ? $_POST[$param] : "") ;
    }
    

    