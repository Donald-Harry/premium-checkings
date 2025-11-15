<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $addBalance = mysqli_real_escape_string($conn, $_POST["addBalance"]);

        //VADLIDATION
        if (!empty($addBalance)) {
            $addBalance = secure_input($addBalance);
        } else {
            echo "Please enter balance";
            exit();
        }

        $get_total_balance = $conn->query("SELECT total_balance, deposit_balance FROM investment WHERE investment.user_id = '{$user_id}'");
        $balance_row = $get_total_balance->fetch_assoc();

        $previousBalance = $balance_row['total_balance'];
        $previousDeposit = $balance_row['deposit_balance'];

        $newBalance = $addBalance + $previousBalance;

        $newDeposit = $addBalance + $previousDeposit;
        
        $update_tranaction = $conn->query("UPDATE investment SET total_balance='{$newBalance}', deposit_balance='{$newDeposit}' WHERE investment.user_id = '{$user_id}'");
        if ($update_tranaction){
            $update_user = $conn->query("UPDATE users SET totalbal='{$newBalance}' WHERE users.id = '{$user_id}'");
            echo "success";
        }else{
            echo "Failed to add balance. Try again later";
        }
    }

    