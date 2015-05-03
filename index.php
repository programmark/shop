<?php

    include('init.php');
    $smarty = oo::smarty();
    p(functions::getIp());
    
    PRODUCTION_SERVER && oo::logs()->debug(date("Y-m-d H:i:s") . " Linux crontab ". " _LINE_ ". __LINE__, "act868_crontab.txt");
    PRODUCTION_SERVER && oo::logs()->debug(date("Y-m-d H:i:s") . " Linux crontab ". " _LINE_ ". __LINE__, "crontab.txt");
    
    p(date("Y-m-d H:i:s"));
    
    $smarty->display(PATH_VIEW . DS . 'show.html');
    