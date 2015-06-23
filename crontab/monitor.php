<?php
/**
 * Created by PhpStorm. PHP 性能、状态 监控 消息队列 redis 预警
 * User: mark
 * Date: 15/5/24
 * Time: 23:21
 */

include dirname(__FILE__) . '/crontab.inc.php';
list($sys_load_0, $sys_load_1, $sys_load_2) = sys_getloadavg();
if($sys_load_0 >= 10) {
    $sys_load = '<br />' . '1分钟负载: ' . $sys_load_0 . ', 5分钟负载: ' . $sys_load_1 . ", 15分钟负载: " . $sys_load_2 . '<br />';
    $to = implode('+_+', array('IP 为 '  . functions::getServerIp(). " 的Linux服务器负载过大，请关注", "Linux负载过大，请关注 " . $sys_load));
    oo::logs()->warning(okey::warning(), $to);
}
$aExtension = array('mysql', 'pdo_mysql', 'redis', 'memcached', 'curl', 'mongo', 'sockets', 'swoole');
foreach($aExtension as $k => $v) {
    if (!extension_loaded($v)) {
        $to = implode('+_+', array($v . '扩展加载失败, 请关注', $v . '扩展加载失败'));
        oo::logs()->warning(okey::warning(), $to);
    }
}


