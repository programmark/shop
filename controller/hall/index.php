<?php

include 'init.php';

defined("IN_WEB") or die("Include Error");

//$ret = ocache::mumemcached()->set("a", 123);
//$ret = ocache::mumemcached()->get("a");
$ret = ocache::muredis()->get("b");
p($ret);

PRODUCTION_SERVER && oo::logs()->debug(date("Y-m-d H:i:s") . " Linux crontab " . " _LINE_ " . __LINE__, "crontab_log.txt");

$string = "sssssdddd\"wwwwwf";
p($string);
//f("mysql/query.txt");
//mysql pdo
/*
  $param = array(
  'table' => oo::logs()->tbluser,
  'name' => "desc",
  'password' => md5(123456),
  );
 */
//$ret = odb::db()->insert($param);
//p($ret);
//$password = md5("suzhousuyuhan");
//$sql = "INSERT INTO " . oo::logs()->tbluser . "(id, name, password) VALUES(NULL, 'suzhousuyuhan', '$password')";
//$sql = "DELETE FROM " .  oo::logs()->tbluser . " WHERE name='0'";
$sql = "SELECT * FROM " . oo::logs()->tbluser;
$ret = odb::db()->getOne($sql);
p($ret);

//mongo
//$ret = ocache::mumongo()->set("testlinux","aa", "ccccccccccccc");
//$ret = ocache::mumongo()->delete("testlinux","aa");
//p($ret);
//memcached
$ret = ocache::mumemcached()->increment("d", 20);
//p($ret);die;
//reids
$ret = ocache::muredis()->delete("a");
p($ret);

//memcached 获取
if ($ret = ocache::mumemcached()->get("commentList")) {
    $commentList = unserialize($ret);
} else {
    $aComment = array(
        'table' => oo::logs()->comment,
        'desc' => "desc",
        'limit' => 20,
        'index' => 'id',
    );
    $commentList = ocache::odb('')->getList($aComment);
    ocache::mumemcached()->set("commentList", serialize($commentList), 5 * 60); //缓存5分钟
}
foreach ($commentList as $key => $val) {
    $commentList[$key]['time'] = date("Y-m-d H:i:s", $val['time']);
}

oo::smarty()->assign('items', $commentList);
oo::smarty()->display(PATH_VIEW . DS . "hall" . DS . 'comment.html');


