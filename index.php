<?php

    include('init.php'); 
    p(ocache::mumemcached()->set("ad", 1234));
    
    $smarty->display(PATH_VIEW . DS . 'show.html');
    