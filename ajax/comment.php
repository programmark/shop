<?php

    include("init.php");

    function _comment() {
        $param = array(
            'table' => oo::logs()->comment,
            'comment' => request('comment'),
            'time' => time(),
            'ip' => functions::getIp(),
        );
        oo::logs()->debug(date("Y-m-d H:i:s") . " param " . json_encode($param) . " _LINE_ " . __LINE__, "insert_comment.txt");
        $ret = ocache::odb('')->insert($param);
        echo json_encode($ret);
    }

    function _delete() {
        $param = array(
            'table' => oo::logs()->comment,
            'id' => request('id'),
        );
        if (ocache::odb('')->getOne($param)) {
            $ret = ocache::odb('')->delete($param);
        } else {
            $ret = 0;
        }
        echo json_encode($ret);
    }

    function _delCache() {
        $key = request("key");
        $ret = false;
        oo::logs()->debug(date("Y-m-d H:i:s") . " key " . $key . " _LINE_" . __LINE__, __FUNCTION__ . ".txt");
        if (ocache::mumemcached()->delete($key)) {
            $ret = true;
        }
        echo json_encode($ret);
    }
    