<?php

    /**
     * ajax 接口
     */
    include dirname(__FILE__) . '/init.php';

    //登陆
    function _login() {
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        PRODUCTION_SERVER && oo::logs()->debug(date("Y-m-d H:i:s") . "_name " . $name . " __FUNCTION__ " . __FUNCTION__, __FUNCTION__ . ".txt");
        $pwd = isset($_POST['pwd']) ? $_POST['pwd'] : '';
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

    //注册
    function _register() {
        $username = request('username');
        $password = md5(request('password'));
        $aRet = array();
        if (empty($username) || empty($password)) {
            $aRet['msg'] = "用户名密码不能为空";
            $aRet['flag'] = -1;
        } else if (!_cofirm($username)) {
            $aRet['msg'] = "用户名已存在";
            $aRet['flag'] = -2;
        } else {
            $registerip = functions::getIp();
            $query = "INSERT INTO " . oo::logs()->user . " (id, username, password, registerip) VALUES(NULL, '$username', '$password', '$registerip')";
            oo::logs()->debug(date("Y-m-d H:i:s") . " query " . $query, "select/query.txt ");
            $ret = odb::db()->query($query);
            if (!empty($ret)) {
                $aRet['msg'] = "注册成功";
                $aRet['flag'] = 1;
            }
        }
        echo json_encode($aRet);
        die;
    }

    //登出
    function _layout() {

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

    //验证用户名是否存在 true 不存在  false 存在
    function _cofirm($username) {
        if (empty($username)) return false;
        $query = "SELECT username FROM " . oo::logs()->user . " WHERE username = '$username'";
        $ret = odb::db()->getOne($query);
        if (empty($ret)) {
            return true;
        }
        return false;
    }
    