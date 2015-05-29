<?php

    class musocket {
        public $socket = null;

        public function __construct() {
            $this->socket = socket_create($domain, $type, $protocol);
        }
        
        public function send() {
            if ($this->socket) {
                socket_send($this->socket, $buf, $len, $flags);
                $this->close();
            }
        }
        
        public function close() {
            socket_close($this->socket);
            $this->socket = null;
        }

    }
    