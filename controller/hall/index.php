<?php

include 'init.php';

defined("IN_WEB") or die("Include Error");

//$string = "sssssdddd\"wwwwwf";
//p($string);

$commentList = array();
oo::smarty()->assign('items', $commentList);
oo::smarty()->display(PATH_VIEW . DS . "hall" . DS . 'comment.html');


