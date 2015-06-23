<?php
/**
 * Created by PhpStorm. redis统计在线信息
 * User: mark
 * Date: 15/6/13
 * Time: 13:14
 */

include (dirname(__FILE__) . '/crontab.inc.php');//取出所有的元素，再取出值 再进行比较
$on_line = ocache::muredis()->zRange('online_' . date('Y-m-d'), 0, -1);
$expretime = 3 * 60;//3分钟离线
$time = time();
foreach($on_line as $k => $v) {
    $score = ocache::muredis()->ZSCORE('online_' . date('Y-m-d'), $v);//获取最后一次操作时间
    if ($time - $score >= $expretime ) {
        oo::logs()->debug(date('Y-m-d H:i:s') . ' _LINE_ '. __LINE__. ' ' . $v, 'online.txt');
        ocache::muredis()->zRem('online_' . date('Y-m-d'), $v);//移除
    }
}

