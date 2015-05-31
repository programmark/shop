<?php

include dirname(__FILE__) . '/crontab.inc.php';
set_time_limit(0);

oo::logs()->debug(date("Y-m-d H:i:s") . " dolist dolist dolist dolist" . __FILE__ . " " . __LINE__, "dolist.txt", 1);
oo::logs()->debug(date("Y-m-d H:i:s") . " dolist " . __FILE__ . " " . __LINE__, "dolist.txt");

