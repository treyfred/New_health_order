<?php

    // $database= new mysqli("db","user","userpassword","edoc");
    $database= new mysqli("localhost","root","","edoc");
    if ($database->connect_error){
        die("Connection failed:  ".$database->connect_error);
    }

?>