<?php

    include '../common.php';


    $sapi_type = php_sapi_name();
    if ($sapi_type != 'cli' && PRODUCTION_SERVER)die("Not Command Line");