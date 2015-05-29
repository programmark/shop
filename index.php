<?php

    include dirname(__FILE__) . '/init.php'; 
    $smarty = oo::smarty();
    
    $smarty->display(PATH_VIEW . DS . 'show.html');
    