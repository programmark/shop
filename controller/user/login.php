<?php

include dirname(__FILE__) . '/../init.php';
defined("IN_WEB") or die("Include Error");


oo::smarty()->assign('pTitle', "v2ex");
oo::smarty()->display(PATH_VIEW . DS . "user" . DS . 'login.html');


