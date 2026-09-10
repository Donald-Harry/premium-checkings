<?php
$db_server = "localhost";
$db_username = "u840384314_premiumcheckin";
$db_password = "Premiumcheckings1234@";
$db_name = "u840384314_premiumcheckin";

$conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);
if (!$conn) {
    echo "not connected" . mysqli_connect_error();
}