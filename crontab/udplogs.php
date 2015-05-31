<?php

include dirname(__FILE__) . '/crontab.inc.php';

$args = getopt('h:p:');
if (!$socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)) {
    oo::logs()->debug(date("Y-m-d H:i:s") . " socket connect failed", "socketerror.txt");
}
//socket_set_option($socket,SOL_SOCKET, SO_REUSEADDR,1 );
socket_bind($socket, $args['h'], $args['p']);
while (1) {
    $ip = '';
    $port = 0;
    $content = socket_recvfrom($socket, $buf, 4096, 0, $ip, $port);
    if ($content == -1) break;

    socket_close($socket);

    $aRet = explode(',', $buf);

    $file = WEB_ROOT . DS . "logs" . DS . $aRet[1] . ".php";
    oo::logs()->debug(date("Y-m-d H:i:s") . $content . " " . json_encode($buf). " ip " . $args['h']. " port " . $args['p'], "socket.txt");
    $dirname = dirname($file);
    if (!is_dir($dirname))
        @mkdir($dirname, 0777, true);
    if (file_exists($file)) {
        (filesize($file) > 1 * 1024 * 1024) && unlink($file); //1M
    }
    file_put_contents($file, $aRet[0] . "\n", FILE_APPEND);
}



