<?php

include dirname(__FILE__) . '/../init.php';
defined("IN_WEB") or die("Include Error");

oo::smarty()->display(PATH_VIEW . DS . "index" . DS . 'index.html');


