<?php

    /**
     * ajax 接口
     */
    include dirname(__FILE__) . '/init.php';


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
            $registertime = time();
            $query = "INSERT INTO " . oo::logs()->user . " (id, username, password, registerip, registertime) VALUES(NULL, '$username', '$password', '$registerip', '$registertime')";
            oo::logs()->debug(date("Y-m-d H:i:s") . " query " . $query, "select/query.txt");
            $ret = odb::db()->query($query);
            if (!empty($ret)) {
                $aRet['msg'] = "注册成功";
                $aRet['flag'] = 1;
                $param = array(
                    'username' => $username,
                    'id' => $ret['id'],
                );
                functions::session($param);
            }
        }
        echo json_encode($aRet);
        die;
    }

    //登陆
    function _login() {
        $username = request('username');
        $password = request('password');
        $aRet = array();
        if (_cofirm($username)) {
            $aRet['msg'] = "用户名不存在";
            $aRet['flag'] = -1;
        } else {
            $query = "SELECT id, password, nomal FROM " . oo::logs()->user . " WHERE username = '$username' LIMIT 1";
            oo::logs()->debug(date("Y-m-d H:i:s") . " query " . $query, __FUNCTION__ . 'txt');
            $ret = odb::db()->getOne($query);
            if ($ret['password'] !== md5($password)) {
                $aRet['msg'] = "密码错误";
                $aRet['flag'] = -2;
            } else if ($ret['nomal'] == 0) {
                $aRet['msg'] = "账号异常，请联系客服";
                $aRet['flag'] = -3;
            } else {
                $aRet['msg'] = "登陆成功";
                $aRet['flag'] = 1;
                $param = array(
                    'username' => $username,
                    'id' => $ret['id'],
                );
                functions::session($param);
            }
        }
        echo json_encode($aRet);
        die;

    }

    //登出
    function _layout() {
        $username = request('username');
        unset($_SESSION['user']);
        $aRet['flag'] = 1;
        echo json_encode($aRet);
        die;
    }


    //验证用户名是否存在 true 不存在  false 存在
    function _cofirm($username) {
        if (empty($username)) return false;
        $query = "SELECT username FROM " . oo::logs()->user . " WHERE username = '$username' LIMIT 1";
        $ret = odb::db()->getOne($query);
        if (empty($ret)) {
            return true;
        }
        return false;
    }
    