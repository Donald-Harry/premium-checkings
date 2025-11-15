<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $withdrawAmount = mysqli_real_escape_string($conn, $_POST["withdrawAmount"]);
        $accountnumber = mysqli_real_escape_string($conn, $_POST["accountnumber"]);
        $recepientname = mysqli_real_escape_string($conn, $_POST["recepientname"]);
        $bankname = mysqli_real_escape_string($conn, $_POST["bankname"]);
        $accounttype = mysqli_real_escape_string($conn, $_POST["accounttype"]);
        $countries = mysqli_real_escape_string($conn, $_POST["country"]);
        $scode = mysqli_real_escape_string($conn, $_POST["scode"]);
        $purpose = mysqli_real_escape_string($conn, $_POST["purpose"]);
        $withdrawalstatus = mysqli_real_escape_string($conn, $_POST["withdrawalstatus"]);

        //VADLIDATION
        if (!empty($withdrawAmount)) {
            $withdrawAmount = secure_input($withdrawAmount);
        } else {
            echo "Please enter your withdraw amount";
            exit();
        }

        if (!empty($accountnumber)) {
            $accountnumber = secure_input($accountnumber);
        } else {
            echo "Please enter your account number";
            exit();
        }

        if (!empty($recepientname)) {
            $recepientname = secure_input($recepientname);
        } else {
            echo "Please enter recepient name";
            exit();
        }

        if (!empty($bankname)) {
            $bankname = secure_input($bankname);
        } else {
            echo "Please enter bank name";
            exit();
        }

        if (!empty($accounttype)) {
            $accounttype = secure_input($accounttype);
        } else {
            echo "Please enter account type";
            exit();
        }

        if (!empty($countries)) {
            $countries = secure_input($countries);
        } else {
            echo "Please enter your country";
            exit();
        }

        if (!empty($scode)) {
            $scode = secure_input($scode);
        } else {
            echo "Please enter your scode";
            exit();
        }

        if (!empty($purpose)) {
            $purpose = secure_input($purpose);
        } else {
            $purpose = "";
        }

        if (!empty($withdrawalstatus)) {
            $withdrawalstatus = secure_input($withdrawalstatus);
        } else {
            echo "Please enter withdrawal status";
            exit();
        }

        $createWithdrawHistory = $conn->query("INSERT INTO withdraw(withdraw_amount, account_number, recepientname, bankname, accounttype, country, scode, purpose, withdrawalstatus, user_id) VALUES ('{$withdrawAmount}','{$accountnumber}','{$recepientname}','{$bankname}','{$accounttype}','{$countries}','{$scode}','{$purpose}','{$withdrawalstatus}','{$user_id}')");
        if($createWithdrawHistory){
            echo "success";
        }
        
        
    }