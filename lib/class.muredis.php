<?php

    class muredis {

        private $_redis = null;
        private $_connect = false;
        private $persistent = false;//长连接
        private $aServer = array();//配置

        /**
         * @param null $aServers
         * @param bool $persistent
         */
        public function __construct($aServer, $persistent = false) {
            if (empty($aServer) || !is_array($aServer)) {
                return false;
            }
            $this->_redis = new Redis();
            $this->persistent = $persistent;
            $this->aServer = $aServer;
        }

        /**
         * @return bool
         */
        public function connect() {
            if ($this->_connect) {
                return $this->_connect;
            } else {
                $host = $this->aServer['host'];
                $port = $this->aServer['port'];
                for ($try = 0; $try < 3; $try++) {
                    $this->persistent ? $flag = $this->_redis->pconnect($host, $port) : $flag = $this->_redis->connect($host, $port);
                    if ($flag){
                        break;
                    }
                }
                if ($try == 2 && !$flag) {
                    $this->close();
                    oo::logs()->debug(date("Y-m-d H:i:s") . ' redis connect error .', 'murediserror.txt');
                } else {
                    if (!class_exists("Redis"))die("Requires Redis Excption");
                    $this->_connect = true;
                    return $this->_connect;
                }
            }
        }

        /** 移除给定的一个或多个key。
            如果key不存在，则忽略该命令。
            时间复杂度：
            O(N)，N为要移除的key的数量。
            移除单个字符串类型的key，时间复杂度为O(1)。
            移除单个列表、集合、有序集合或哈希表类型的key，时间复杂度为O(M)，M为以上数据结构内的元素数量。
            返回值：
            被移除key的数量。
         * @param $key
         * @return int
         */
        public function del($key) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->del($key);
            }
        }

        /**
         * @param $key
         * @return bool|string
         */
        public function get($key) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->get($key);
            }
        }

        /**
         * @param $key
         * @param $value
         * @return bool
         */
        public function set($key, $value) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->set($key, $value);
            }
        }

        /** 查找符合给定模式的key。 支持模糊查询
            KEYS *命中数据库中所有key。
            KEYS h?llo命中hello， hallo and hxllo等。
            KEYS h*llo命中hllo和heeeeello等。
            KEYS h[ae]llo命中hello和hallo，但不命中hillo。
            特殊符号用"\"隔开
         * @param $key
         * @return mixed
         */
        public function keys($key){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->keys($key);
            }
        }

        /** 从当前数据库中随机返回(不删除)一个key。
            时间复杂度：
            O(1)
            返回值：
            当数据库不为空时，返回一个key。
            当数据库为空时，返回nil。
         * @return string
         */
        public function randomkey(){
            if ($this->connect()) {
                return $this->_redis->randomKey();
            }
        }

        /** 返回给定key的剩余生存时间(time to live)(以秒为单位)。
            时间复杂度：
            O(1)
            返回值：
            key的剩余生存时间(以秒为单位)。
            当key不存在或没有设置生存时间时，返回-1
         * @param $key
         * @return int
         */
        public function ttl($key) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->ttl($key);
            }
        }

        /** 检查给定key是否存在。
            时间复杂度：
            O(1)
            返回值：
            若key存在，返回1，否则返回0。
         * @param $key
         * @return bool
         */
        public function exists($key) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->exists($key);
            }
        }

        /** 将当前数据库(默认为0)的key移动到给定的数据库db当中。
            如果当前数据库(源数据库)和给定数据库(目标数据库)有相同名字的给定key，或者key不存在于当前数据库，那么MOVE没有任何效果。
            因此，也可以利用这一特性，将MOVE当作锁(locking)原语。
            时间复杂度：
            O(1)
            返回值：
            移动成功返回1，失败则返回0。
         * @param $key
         * @param $dbindex
         * @return bool
         */
        public function move($key, $dbindex) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->move($key, $dbindex);
            }
        }

        /** 将key改名为newkey。
            当key和newkey相同或者key不存在时，返回一个错误。
            当newkey已经存在时，RENAME命令将覆盖旧值。
            时间复杂度：
            O(1)
            返回值：
            改名成功时提示OK，失败时候返回一个错误。
         * @param $keySrc
         * @param $keyDes
         */
        public function rename($keySrc, $keyDes){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->rename($keySrc, $keyDes);
            }
        }

        /** 返回key所储存的值的类型。
            时间复杂度：
            O(1)
            返回值：
            none(key不存在) int(0)
            string(字符串) int(1)
            list(列表) int(3)
            set(集合) int(2)
            zset(有序集) int(4)
            hash(哈希表) int(5)
         * @param $key
         * @return int
         */
        public function type($key) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->type($key);
            }
        }

        /** 当且仅当newkey不存在时，将key改为newkey。
            出错的情况和RENAME一样(key不存在时报错)。
            时间复杂度：
            O(1)
            返回值：
            修改成功时，返回1。
            如果newkey已经存在，返回0
         * @param $key
         * @param $newkey
         * @return bool
         */
        public function renameNx($key, $newkey) {
            if (!empty($key) && !empty($newkey) && $this->connect()) {
                return $this->_redis->renameNx($key, $newkey);
            }
        }

        /** 为给定key设置生存时间。
            当key过期时，它会被自动删除。
            在Redis中，带有生存时间的key被称作“易失的”(volatile)。
            在低于2.1.3版本的Redis中，已存在的生存时间不可覆盖。
            从2.1.3版本开始，key的生存时间可以被更新，也可以被PERSIST命令移除。(详情参见 http://redis.io/topics/expire)。
            时间复杂度：
            O(1)
            返回值：
            设置成功返回1。
            当key不存在或者不能为key设置生存时间时(比如在低于2.1.3中你尝试更新key的生存时间)，返回0。
         * @param $key
         * @param int $seconds
         * @return bool
         */
        public function expire($key, $seconds = 0) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->expire($key, $seconds);
            }
        }

        /** EXPIREAT的作用和EXPIRE一样，都用于为key设置生存时间。
            不同在于EXPIREAT命令接受的时间参数是UNIX时间戳(unix timestamp)。
            时间复杂度：
            O(1)
            返回值：
            如果生存时间设置成功，返回1。
            当key不存在或没办法设置生存时间，返回0。
         * @param $key
         * @param int $timestamp
         * @return bool
         */
        public function expireAt($key, $timestamp=0){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->expireAt($key, $timestamp);
            }
        }

        /**移除给定key的生存时间。
            时间复杂度：
            O(1)
            返回值：
            当生存时间移除成功时，返回1.
            如果key不存在或key没有设置生存时间，返回0。
         * @param $key
         * @return bool
         */
        public function persist($key){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->persist($key);
            }
        }

        /**SORT key [BY pattern] [LIMIT offset count] [GET pattern [GET pattern ...]] [ASC | DESC] [ALPHA] [STORE destination]
            排序，分页等
            参数
            array(
            ‘by’ => ‘some_pattern_*’,
            ‘limit’ => array(0, 1),
            ‘get’ => ‘some_other_pattern_*’ or an array of patterns,
            ‘sort’ => ‘asc’ or ‘desc’,
            ‘alpha’ => TRUE,
            ‘store’ => ‘external-key’
            )
            返回或保存给定列表、集合、有序集合key中经过排序的元素。
            排序默认以数字作为对象，值被解释为双精度浮点数，然后进行比较。
         * @param $key
         * @return array
         */
        public function sort($key, $redis_sort_option = array()) {
            if ($this->connect()) {
                return $this->_redis->sort($key, $redis_sort_option);
            }
        }

        /** hash
         * @param $key
         * @param $field
         * @return string
         */
        public function hGet($key, $field) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->hGet($key, $field);
            }
        }

        /** hash
         * @param $key
         * @param $field
         * @param $value
         * @return int
         */
        public function hSet($key, $field, $value) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->hSet($key, $field, $value);
            }
        }

        /** 返回哈希表key中域的数量
         * @param $key
         * @return int
         */
        public function hLen($key){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->hLen($key);
            }
        }

        /**
         * redis 原子操作
         * @param type $key
         * @param type $value
         * @param type $offst 0 增 1减
         * @return type
         */
        public function inrc($key, $value, $offst = 0) {
            if (!empty($key) && $this->connect()) {
                $offst ? ($ret = $this->_redis->decr($key, $value)) : ($ret = $this->_redis->incr($key, $value));
                return $ret;
            }
        }

        public function delete($key) {
            if (!empty($key) && $this->connect()) {
                return $this->_redis->delete($key);
            }
        }
        
        /** 将一个或多个值value插入到列表key的表头
         * @param $key
         * @param $val
         * @return int
         */
        public function lPush($key, $val){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->lPush($key, $val);
            }
        }

        /** 移除并返回列表key的头元素。当key不存在时，返回nil。
         * @param $key
         * @return string
         */
        public function lPop($key){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->lPop($key);
            }
        }

        /**将一个或多个值value插入到列表key的表尾。
         * @param $key
         * @param $val
         * @return int
         */
        public function rPush($key, $val){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->rPush($key, $val);
            }
        }

        /** 移除并返回列表key的尾元素。当key不存在时，返回nil。
         * @param $key
         * @return string
         */
        public function rPop($key){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->rPop($key);
            }
        }

        /**返回列表key中指定区间内的元素，区间以偏移量start和stop指定。
        下标(index)参数start和stop都以0为底，也就是说，以0表示列表的第一个元素，以1表示列表的第二个元素，以此类推。
        你也可以使用负数下标，以-1表示列表的最后一个元素，-2表示列表的倒数第二个元素，以此类推。
         * @param $key
         * @param $start
         * @param $top
         * @return array
         */
        public function lRange($key, $start, $top){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->lRange($key, $start, $top);
            }
        }

        /** 将列表key下标为index的元素的值甚至为value。
         * 下标(index)参数start和stop都以0为底，也就是说，以0表示列表的第一个元素，以1表示列表的第二个元素，以此类推。
           你也可以使用负数下标，以-1表示列表的最后一个元素，-2表示列表的倒数第二个元素，以此类推。
         * @return string
         */
        public function lSet($key, $index, $val){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->lSet($key, $index, $val);
            }
        }

        /**
         * @param $key
         */
        public function lSize($key){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->lSize($key);
            }
        }

        /**根据参数count的值，移除列表中与参数value相等的元素。
            count的值可以是以下几种：
            count > 0: 从表头开始向表尾搜索，移除与value相等的元素，数量为count。
            count < 0: 从表尾开始向表头搜索，移除与value相等的元素，数量为count的绝对值。
            count = 0: 移除表中所有与value相等的值。
         * @param $key
         * @param $value
         * @param $count
         * @return int
         */
        public function lRem($key, $value, $count){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->lRem($key, $value, $count);
            }
        }

        /** 返回列表key的长度。
            如果key不存在，则key被解释为一个空列表，返回0.
            如果key不是列表类型，返回一个错误
         * @param $key
         * @return int
         */
        public function lLen($key){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->lLen($key);
            }
        }

        /**对一个列表进行修剪(trim)，就是说，让列表只保留指定区间内的元素，不在指定区间之内的元素都将被删除。
        举个例子，执行命令LTRIM list 0 2，表示只保留列表list的前三个元素，其余元素全部删除。
        下标(index)参数start和stop都以0为底，也就是说，以0表示列表的第一个元素，以1表示列表的第二个元素，以此类推。
        你也可以使用负数下标，以-1表示列表的最后一个元素，-2表示列表的倒数第二个元素，以此类推。
        当key不是列表类型时，返回一个错误
         * @param $key
         * @param $start
         * @param $stop
         * @return array
         */
        public function lTrim($key, $start, $stop){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->lTrim($key, $start, $stop);
            }
        }

        /** 将一个或多个member元素加入到集合key当中，已经存在于集合的member元素将被忽略。
         * @param $key
         * @param $val
         * @return int
         */
        public function sAdd($key, $val){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->sAdd($key, $val);
            }
        }

        /** 返回集合key的基数(集合中元素的数量)。
         * @param $key
         * @return int
         */
        public function sCard($key, $val){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->sCard($key);
            }
        }

        /** 移除集合key中的一个或多个member元素，不存在的member元素会被忽略。
         * @param $key
         * @return int
         */
        public function sRem($key, $member){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->sRem($key, $member);
            }//SREM
        }

        /** 将一个或多个member元素加入到集合key当中，已经存在于集合的member元素将被忽略。（有序集合）
         * @param $key
         * @param $val
         * @return int
         */
        public function zAdd($key, $score, $member){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->zAdd($key, $score, $member);
            }
        }

        /** 返回集合key的基数(集合中元素的数量)。
         * @param $key
         * @return int
         */
        public function zCard($key){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->zCard($key);
            }
        }

        /** 移除有序集key中的一个或多个成员，不存在的成员将被忽略。
         * @param $key
         * @return int
         */
        public function zRem($key, $member){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->zRem($key, $member);
            }
        }

        /** 返回有序集key中，成员member的score值
         * @param $key
         * @return int
         */
        public function ZSCORE($key, $member){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->ZSCORE($key, $member);
            }
        }

        /** 移除有序集key中，所有score值介于min和max之间(包括等于min或max)的成员。
         * @param $key
         * @return int
         */
        public function ZREMRANGEBYSCORE($key, $min, $max){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->ZREMRANGEBYSCORE($key, $min, $max);
            }
        }

        /** 返回有序集key中，score值在min和max之间(默认包括score值等于min或max)的成员。
         * @param $key
         * @return int
         */
        public function zCount($key, $min, $max){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->zCount($key, $min, $max);
            }
        }

        /** 返回有序集key中，指定区间内的成员。
        其中成员的位置按score值递增(从小到大)来排序。
        具有相同score值的成员按字典序(lexicographical order)来排列。
        如果你需要成员按score值递减(从大到小)来排列，请使用ZREVRANGE命令。
        下标参数start和stop都以0为底，也就是说，以0表示有序集第一个成员，以1表示有序集第二个成员，以此类推。
        你也可以使用负数下标，以-1表示最后一个成员，-2表示倒数第二个成员，以此类推。。
         * @param $key
         * @param $min
         * $param $max
         * @return int
         */
        public function zRange($key, $min, $max){
            if (!empty($key) && $this->connect()) {
                return $this->_redis->zRange($key, $min, $max);
            }
        }

        /**
         * close
         */
        public function close() {
            $this->_redis->close();
            $this->_redis = null;
            $this->_connect = false;
        }


    }
    