<?php
/**
 * Created by PhpStorm.
 * User: mark
 * Date: 15/6/8
 * Time: 23:13
 */
class minfo {
    
    public function __construct() {}

    /**
     * @param $mid
     * @param array $param
     * @return array
     */
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

    /**
     * @param $mid
     * @param array $param
     * @return bool
     */
    public function update($mid, $param = array()){
        if (!empty($param)) {
            $sql = '';
            foreach ($param as $k => $v) {
                $sql .= (( $k .= "='$v'") . ',');
            }
            $sql = substr($sql, 0, -1);
            $query = "UPDATE " . oo::logs()->user . " SET $sql WHERE id = '$mid'";
            odb::db()->query($query);
            return true;
        }
        return false;
    }

    /**
     * @param $username
     * @return bool 1 存在 0 不存在
     */
    public function isset_username($username){
        if (empty($username)) return false;
        $query = "SELECT username FROM " . oo::logs()->user . " WHERE username = '$username' LIMIT 1";
        $ret = odb::db()->getOne($query);
        if (!empty($ret)) {
            return true;
        }
        return false;
    }
}