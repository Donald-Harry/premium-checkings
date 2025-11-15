<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];

        $update_user_status = $conn->query("UPDATE users SET status='-1' WHERE users.id = '{$user_id}'");
        if ($update_user_status){
            echo "success";
        }
    }