<?php

include dirname(__FILE__) . '/../init.php';
defined("IN_WEB") or die("Include Error");

$username = '';
$aMinfo = array();
if ($_SESSION) {
    $username = $_SESSION['user']['username'];
    $aMinfo = oo::minfo()->get($_SESSION['user']['id'], array('registertime', 'username', 'nomal'));
}

if (isset($aMinfo['registertime'])) {
    if (!empty($aMinfo['registertime'])) {
        $aMinfo['registertime'] = date("Y-m-d H:i:s", $aMinfo['registertime']);
    } else {
        $aMinfo['registertime'] = "暂无功能";
    }
}

oo::smarty()->assign('username', $username);
oo::smarty()->assign('registertime', $aMinfo['registertime']);
oo::smarty()->assign('pTitle', "v2ex");
oo::smarty()->display(PATH_VIEW . DS . "index" . DS . 'index.html');


