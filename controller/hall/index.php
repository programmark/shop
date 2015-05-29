<?php

include dirname(__FILE__) . '/../init.php';

defined("IN_WEB") or die("Include Error");

oo::logs()->debug(date("Y-m-d H:i:s") . " index controller ". __FILE__. " " .__LINE__, 'controller/index.txt', 1);

oo::smarty()->assign('pTitle', "hall center");
oo::smarty()->display(PATH_VIEW . DS . "hall" . DS . 'index.html');


