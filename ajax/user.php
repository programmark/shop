<?php

    /**
     * ajax 接口
     */
    include dirname(__FILE__) . '/init.php';


    //注册
    function _register() {
        $stime = microtime(true);
        $username = request('username');
        $password = md5(request('password'));
        $aRet = array();
        if (empty($username) || empty($password)) {
            $aRet['msg'] = "用户名密码不能为空";
            $aRet['flag'] = -1;
        } else if (oo::minfo()->isset_username($username)) {
            $aRet['msg'] = "用户名已存在";
            $aRet['flag'] = -2;
        } else {
            $registerip = functions::getIp();
            $registertime = time();
            $query = "INSERT INTO " . oo::logs()->user . " (id, username, password, registerip, registertime) VALUES(NULL, '$username', '$password', '$registerip', '$registertime')";
            $ret = odb::db()->query($query);
            if (isset($ret['success']) && $ret['success'] == 1) {
                $aRet['msg'] = "注册成功";
                $aRet['flag'] = 1;
                $param = array(
                    'username' => $username,
                    'id' => $ret['id'],
                );
                functions::session($param);
                ocache::muredis()->zAdd('online_' . date('Y-m-d'), time(), $username);

                //统计超时注册
                $etime = microtime(true);
                if ($etime - $stime > 1) {
                    oo::logs()->debug(date("Y-m-d H:i:s") . " time " . ($etime - $stime) . " line " . __LINE__, "ajax/register.txt");
                }
            }
        }
        echo json_encode($aRet);
        die;
    }

    //登陆
    function _login() {
        $stime = microtime(true);
        $username = request('username');
        $password = request('password');
        $autologin = request('autologin');
        $aRet = array();
        if (!oo::minfo()->isset_username($username)) {
            $aRet['msg'] = "用户名不存在";
            $aRet['flag'] = -1;
        } else {
            $query = "SELECT id, password, nomal FROM " . oo::logs()->user . " WHERE username = '$username' LIMIT 1";
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
                $ip = functions::getIp();
                $time = time();
                $autologin == 'true' && functions::setcookie(md5('username'), implode('-', array($username, $ret['id'])), 7 * 24 * 3600);
                oo::minfo()->update($ret['id'], array('loginip' => $ip, 'logintime' => $time));
                ocache::muredis()->zAdd('online_' . date('Y-m-d'), $time, $username);

                //统计登陆超时
                $etime = microtime(true);
                if ($etime - $stime > 1) {
                    oo::logs()->debug(date("Y-m-d H:i:s") . " time " . ($etime - $stime) . " line " . __LINE__, "ajax/login.txt");
                }
            }
        }
        echo json_encode($aRet);
        die;

    }

    //登出
    function _layout() {
        $username = request('username');
        unset($_SESSION['user']);
        session_destroy();
        functions::setcookie(md5('username'), '',  - 7 * 24 * 3600);
        ocache::muredis()->zRem('online_' . date('Y-m-d'), $username);
        $aRet['flag'] = 1;
        echo json_encode($aRet);
        die;
    }

    //检测用户名是否存在 1 存在 0 不存在
    function _isset_username() {
        $username = request('username');
        $ret = oo::minfo()->isset_username($username);
        $aRet['flag'] = 0;
        if (!empty($ret)) {
            $aRet['flag'] = 1;
        }
        echo json_encode($aRet);
        die;
    }
    