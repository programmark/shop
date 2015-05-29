<?php
/**
 * Created by PhpStorm. PHP 性能、状态 监控
 * User: mark
 * Date: 15/5/24
 * Time: 23:21
 */

include dirname(__FILE__) . '/crontab.inc.php';
list($sys_load_0, $sys_load_1, $sys_load_2) = sys_getloadavg();
if($sys_load_0 >= 4) {
    $sys_load = '<br />' . '1分钟负载: ' . $sys_load_0 . ', 5分钟负载: ' . $sys_load_1 . ", 15分钟负载: " . $sys_load_2 . '<br />';
    $to = array('18503068868@163.com', 'IP 为 '  . functions::getServerIp(). " 的Linux服务器负载过大，请关注", "Linux负载过大，请关注 " . $sys_load);
    oo::mail()->send($to);
    oo::logs()->debug(date("Y-m-d H:i:s") . json_encode($to), 'sendmail.txt');
}
$aExtension = array('mysql', "pdo_mysql", "redis", "memcached", "curl", "mongo", "sockets", "swoole");
foreach($aExtension as $k => $v) {
    if (!extension_loaded($v)) {
        oo::logs()->debug(date("Y-m-d H:i:s") . $v , 'extension.txt');
        //oo::logs()->warning($v);
    }
}
