<?php

class mudb {

    private $_connect = false;
    private $_pdo = null;

    /*
     * mysql 集群
     */
    public function __construct($aServers = null) {
        if (is_array($aServers) && !empty($aServers)) {
            
        }
    }

    /**
     * mysql 连接
     * @return \PDO
     */
    public function connect() {
        if ($this->_pdo && $this->_connect) {
            return true;
        } else {
            $tmp = parse_ini_file(PATH_CONFIG . DS . 'app.ini', true);
            $aIni = $tmp['mysql'];
            $_db = $aIni['db'];
            $_host = $aIni['host'];
            $_user = $aIni['user'];
            $_pwd = $aIni['password'];
            $_port = $aIni['port'];
            $_dsn = "mysql:host={$_host};dbname={$_db};port={$_port}";
            try {
                $this->_pdo = new PDO($_dsn, $_user, $_pwd);
                $this->_connect = true;
                return true;
            } catch (PDOException $e) {
                oo::logs()->debug(date("Y-m-d H:i:s") . ' Mysql Connection failed: ' . $e->getMessage(), "mudberror.txt");
            }
        }
    }

    public function getOne($query) {
        if ($this->connect() && is_string(trim($query))) {
            oo::logs()->debug(date("Y-m-d H:i:s") . " query " . $query, "mysql/getOne.txt");
            $ret = $this->_pdo->query($query)->fetch(PDO::FETCH_ASSOC);
            $this->close();
            return $ret;
        }
    }

    public function getAll($query) {
        if ($this->connect() && is_string(trim($query))) {
            oo::logs()->debug(date("Y-m-d H:i:s") . " query " . $query, "mysql/getAll.txt");
            $ret = $this->_pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
            $this->close();
            return $ret;
        }
    }

    //执行 insert delete update
    public function query($query) {
        if ($this->connect() && is_string(trim($query))) {
            oo::logs()->debug(date("Y-m-d H:i:s") . " sql " . $query, "mysql/query.txt");
            $ret = $this->_pdo->exec($query);
            $this->close();
            return $ret;
        }
    }

    public function close() {
        $this->_pdo = null;
        $this->_connect = false;
    }

}
