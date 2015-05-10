<?php

class socketServer {
    private $sockket = null;
    
    public function __construct($aServer) {
        if(!extension_loaded('sockets'))die('The sockets extension is not loaded.');
    }
}
