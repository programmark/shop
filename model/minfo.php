<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 15/6/8
 * Time: 23:13
 */
class minfo {
    
    public function __construct() {}

    public function get($mid, $param = array()){
        $param = implode(',' , $param);
        $aRet = array();
        if (!empty($param)) {//从db中取部分值
            $query = "SELECT $param FROM " . oo::logs()->user . " WHERE id = '$mid'";
        } else {
            $query = "SELECT * FROM " . oo::logs()->user . " WHERE id = '$mid'";
        }
        $aRet = odb::dbslave()->getOne($query);
        return $aRet;
    }

    public function update($mid, $param = array()){
        if (!empty($param)) {
            $sql = '';
            foreach ($param as $k => $v) {
                $sql .= (( $k .= "='$v'") . ',');
            }
            $sql = substr($sql, 0, -1);
        }
        if (!empty($param)) {
            $query = "UPDATE " . oo::logs()->user . " SET $sql WHERE id = '$mid'";
            odb::db()->query($query);
            return true;
        }
        return false;
    }
}