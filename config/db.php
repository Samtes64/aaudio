<?php
    define('DB_HOST','localhost');
    define('DB_USER','lawga');
    define('DB_PASS','iRent4life');
    define('DB_NAME','aaudio');

    // create connection
    $connection = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);

    // check connection
    if($connection->connect_error){
        die('Connection failed!' . $connection->connect_error);
    }

    // echo 'CONNECTED';