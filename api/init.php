<?php

include dirname(__FILE__) . '/../common.php';
$allowip = $config['allowip'];
if (!in_array(functions::getIp(), $allowip)) die("非法操作");
