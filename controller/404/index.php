<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 15/6/8
 * Time: 22:39
 */

include dirname(__FILE__) . '/../init.php';

oo::smarty()->assign('pTitle', "v2ex");
oo::smarty()->display(PATH_VIEW . DS . "404" . DS . 'index.html');