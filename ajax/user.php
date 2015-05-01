<?php

    /**
     * ajax 接口
     */
    include("init.php");

    function _submit() {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        PRODUCTION_SERVER && oo::logs()->debug(date("Y-m-d H:i:s") . "_name " . $name . " __FUNCTION__ " . __FUNCTION__, __FUNCTION__ . ".txt");
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
        PRODUCTION_SERVER  && oo::logs()->debug(date("Y-m-d H:i:s") . "_pwd " . $pwd . " __FUNCTION__ " . __FUNCTION__, __FUNCTION__ . ".txt");
        $aRet = array();
        if (empty($name) || empty($pwd)) {
            $aRet['msg'] = "用户名密码不能为空";
            $aRet['state'] = "err";
        } else {
            $aRet['msg'] = "提交成功";
            $aRet['state'] = "ok";
        }
        echo json_encode($aRet);
        die;
    }
    
    function _register() {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        PRODUCTION_SERVER && oo::logs()->debug(date("Y-m-d H:i:s") . "_name " . $name . "__FUNCTION__" . __FUNCTION__, __FUNCTION__ . ".txt");
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
        PRODUCTION_SERVER  && oo::logs()->debug(date("Y-m-d H:i:s") . "_pwd " . $pwd . " __FUNCTION__ " . __FUNCTION__, __FUNCTION__ . ".txt");
        $aRet = array();
        if (empty($name) || empty($pwd)) {
            $aRet['msg'] = "用户名密码不能为空";
            $aRet['state'] = "err";
        } else {
            $aRet['msg'] = "提交成功";
            $aRet['state'] = "ok";
        }
        echo json_encode($aRet);
        die;
    }

    function _comment() {
        $comment = isset($_POST['comment']) ? $_POST['comment'] : $_GET['comment'];
        oo::logs()->debug(date("Y-m-d H:i:s") . "_comment " . $comment . " __FUNCTION__ " . __FUNCTION__, __FUNCTION__ . ".txt");
        if (!empty($comment)) {
            $aRet['msg'] = "提交成功";
            $aRet['state'] = "ok";
        } else {
            $aRet['msg'] = "内容不能为空";
            $aRet['state'] = "err";
        }
        echo json_encode($aRet);
    }
    
    function _getList($type) {
        
    }
    