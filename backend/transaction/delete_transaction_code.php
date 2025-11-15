<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $transferCodeId = $_POST['transferCodeId'];

        $deleteTransferCode = $conn->query("DELETE FROM transfercodes WHERE transfercodes.id = '{$transferCodeId}' AND transfercodes.user_id = '{$user_id}'");
        if ($deleteTransferCode){
            echo "success";
        }
    }