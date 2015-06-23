<?php

class socketServer {
    private $socket = null;//socket链接对象
    private $aServer = array();
    private $tcp = null;

    public function __construct($aServer, $tcp = true) {
        if(!extension_loaded('sockets'))die('The sockets extension is not loaded.');
        if (empty($aServer) || !is_array($aServer)) {
            return false;
        }
        $this->aServer = $aServer;
        $this->tcp = $tcp;
    }

    public function connect() {
        $ip = $this->aServer['ip'];
        $port = $this->aServer['port'];
        if ($this->tcp) {
            if (!$this->socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) {

            }
        }
    }


}
