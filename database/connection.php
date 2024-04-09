<?php

  /* $host = "68.183.224.113";
    $username = "ccsit_rcabarrubias";
    $password = "kcU(0U%g@.gx";
    $db = "ccsit_rcabarrubias"; */

    $host = "localhost";
    $username = "root";
    $password = "";
    $db = "it208";
    $port = 3307;

    //edit a new code for connection
    $connection = mysqli_connect($host, $username, $password, $db, $port);

    if(!$connection)
    {
        die('Connection failed: '.mysqli_connect_error());
    }