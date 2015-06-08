<?php

include dirname(__FILE__) . '/../init.php';
defined("IN_WEB") or die("Include Error");

$username = '';
if ($_SESSION) {
    $username = $_SESSION['user']['username'];
}
oo::smarty()->assign('username', $username);
oo::smarty()->assign('pTitle', "v2ex");
oo::smarty()->display(PATH_VIEW . DS . "index" . DS . 'index.html');


