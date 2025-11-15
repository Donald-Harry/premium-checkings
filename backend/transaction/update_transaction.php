<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $transaction_id = $_POST['transaction_id'];
        $transaction_date = mysqli_real_escape_string($conn, $_POST["transaction_date"]);
        $transaction_time = mysqli_real_escape_string($conn, $_POST["transaction_time"]);
        $transaction_description = mysqli_real_escape_string($conn, $_POST["transaction_description"]);
        $transaction_status = mysqli_real_escape_string($conn, $_POST["transaction_status"]);
        $transaction_amount = mysqli_real_escape_string($conn, $_POST["transaction_amount"]);
        $bank_name = mysqli_real_escape_string($conn, $_POST["bank_name"]);
        $account_name = mysqli_real_escape_string($conn, $_POST["account_name"]);

        //VADLIDATION
        if (!empty($transaction_date)) {
            $transaction_date = secure_input($transaction_date);
        } else {
            echo "Please enter your first transfer code name";
            exit();
        }

        if (!empty($transaction_time)) {
            $transaction_time = secure_input($transaction_time);
        } else {
            echo "Please enter your first transfer code number";
            exit();
        }

        if (!empty($transaction_description)) {
            $transaction_description = secure_input($transaction_description);
        } else {
            echo "Please enter your second transfer code name";
            exit();
        }

        if (!empty($transaction_status)) {
            $transaction_status = secure_input($transaction_status);
        } else {
            echo "Please enter your second transfer code number";
            exit();
        }

        if (!empty($transaction_amount)) {
            $transaction_amount = secure_input($transaction_amount);
        } else {
            echo "Please enter your third transfer code name";
            exit();
        }

        if (!empty($bank_name)) {
            $bank_name = secure_input($bank_name);
        } else {
            echo "Please enter your third transfer code number";
            exit();
        }

        if (!empty($account_name)) {
            $account_name = secure_input($account_name);
        } else {
            echo "Please enter your third transfer code number";
            exit();
        }

        $updateTransactionHistory = $conn->query("UPDATE transaction_history SET transaction_date='{$transaction_date}',transaction_time='{$transaction_time}',transaction_description='{$transaction_description}',transaction_status='{$transaction_status}',transaction_amount='{$transaction_amount}',bank_name='{$bank_name}',account_name='{$account_name}' WHERE transaction_history.id = '{$transaction_id}' AND transaction_history.user_id = '{$user_id}'");
        if($updateTransactionHistory){
            echo "success";
        }else{
            echo "error updating transaction history";
        }
        
        
    }