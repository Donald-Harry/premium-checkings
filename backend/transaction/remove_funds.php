<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['userId'];
        $removeAmount = mysqli_real_escape_string($conn, $_POST["remove_balance"]);
        
        //VADLIDATION
        if (!empty($removeAmount)) {
            $removeAmount = secure_input($removeAmount);
        } else {
            echo "Please enter balance";
            exit();
        }

        $get_total_balance = $conn->query("SELECT total_balance FROM investment WHERE investment.user_id = '{$user_id}'");
        $balance_row = $get_total_balance->fetch_assoc();

        $previousBalance = $balance_row['total_balance'];
        
        if($previousBalance > $removeAmount){
            $newBalance = $previousBalance - $removeAmount;
        }else{
            $newBalance = $removeAmount - $previousBalance;
        }
        
        $update_tranaction = $conn->query("UPDATE investment SET total_balance='{$newBalance}' WHERE investment.user_id = '{$user_id}'");
        if ($update_tranaction){
            echo "success";
        }else{
            echo "Failed to add balance. Try again later";
        }
    }

    