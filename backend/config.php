<?php
    $db_server = "localhost";
    $db_username = "u755862803_premiumcheck";
    $db_password = "Premium1234@!";
    $db_name = "u755862803_premiumcheck";

    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);
    if(!$conn){
        echo "not connected". mysqli_connect_error();
    }