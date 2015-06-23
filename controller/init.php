<?php

include dirname(__FILE__) . '/../common.php';

$username = '';
$aMinfo = array('registertime'=>'');
if ($_SESSION) {
    $username = $_SESSION['user']['username'];
    $mid = $_SESSION['user']['id'];
} else {
    if (isset($_COOKIE[md5('username')])) {
        $cook = explode('-', $_COOKIE[md5('username')]);
        $username = (string)$cook['0'];
        $mid = (int)$cook[1];
        $param = array(
            'username' => (string)$username,
            'id' => (int)$mid,
        );
        functions::session($param);
        oo::minfo()->update((int)$mid, array('loginip' => functions::getIp(), 'logintime' => time()));
    }
}


if (isset($mid)) {
    $aMinfo = oo::minfo()->get($mid, array('registertime', 'username', 'nomal'));
    ocache::muredis()->zAdd('online_' . date('Y-m-d'), time(), $username);
}
if (isset($aMinfo['registertime'])) {
    if (!empty($aMinfo['registertime'])) {
        $aMinfo['registertime'] = date("Y-m-d H:i:s", $aMinfo['registertime']);
    } else {
        $aMinfo['registertime'] = "暂无功能";
    }

}

$online = ocache::muredis()->zCard('online_' . date('Y-m-d'));//在线人数
oo::smarty()->assign('registertime', $aMinfo['registertime']);
oo::smarty()->assign('online', $online);
oo::smarty()->assign('username', $username);
oo::smarty()->assign('pTitle', "v2ex");