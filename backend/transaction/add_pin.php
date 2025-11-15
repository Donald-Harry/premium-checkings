<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $pin = $_POST['transfer_pin'];

        $update_user = $conn->query("UPDATE users SET pin='{$pin}' WHERE users.id='{$user_id}'");
        if($update_user){
            echo "success";
        }else{
            echo "error updating transaction history";
        }
    }