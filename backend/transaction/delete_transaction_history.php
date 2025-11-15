<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $transactionId = $_POST['transaction_id'];

        $deleteTransferCode = $conn->query("DELETE FROM transaction_history WHERE transaction_history.id = '{$transactionId}' AND transaction_history.user_id = '{$user_id}'");
        if ($deleteTransferCode){
            echo "success";
        }else{
            echo "error". mysqli_error($conn);
        }
    }