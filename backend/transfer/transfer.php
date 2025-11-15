<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
        $accountnumber = mysqli_real_escape_string($conn, $_POST["accountnumber"]);
        $recipientname = mysqli_real_escape_string($conn, $_POST["recipientname"]);
        $bankname = mysqli_real_escape_string($conn, $_POST["bankname"]);
        $accountype = mysqli_real_escape_string($conn, $_POST["accountype"]);
        $recipientcountry = mysqli_real_escape_string($conn, $_POST["recipientcountry"]);
        $swiftcode = mysqli_real_escape_string($conn, $_POST["swiftcode"]);
        $remarks = mysqli_real_escape_string($conn, $_POST["remarks"]);

        //VADLIDATION
        if (!empty($amount)) {
            $amount = secure_input($amount);
        } else {
            echo "Please enter the amount you want to transfer";
            exit();
        }

        if (!empty($accountnumber)) {
            $accountnumber = secure_input($accountnumber);
        } else {
            echo "Please enter the account number";
            exit();
        }

        if (!empty($recipientname)) {
            $recipientname = secure_input($recipientname);
        } else {
            echo "Please enter the recipient name";
            exit();
        }

        if (!empty($bankname)) {
            $bankname = secure_input($bankname);
        } else {
            echo "Please enter the bank name";
            exit();
        }

        if (!empty($accountype)) {
            $accountype = secure_input($accountype);
        } else {
            echo "Please choose an account type";
            exit();
        }

        if (!empty($recipientcountry)) {
            $recipientcountry = secure_input($recipientcountry);
        } else {
            echo "Please enter the recipient's country";
            exit();
        }

        if (!empty($swiftcode)) {
            $swiftcode = secure_input($swiftcode);
        } else {
            echo "Please enter the swift code";
            exit();
        }

        if (!empty($remarks)) {
            $remarks = secure_input($remarks);
        } else {
            $remarks = "";
        }

        //Get the totalbalance
        $getBalance = $conn->query("SELECT totalbal FROM users WHERE id = '{$user_id}'");
        if($getBalance->num_rows > 0){
            while($row = $getBalance->fetch_assoc()){
                $totalBalance = $row['totalbal'];
            }
        }

        if($totalBalance < $amount){

            echo json_encode(["error" => "Insufficient balance"]);
        }else{
            $reference = time().generate_random_alphanumeric(30);
            $insertTransfer = $conn->query("INSERT INTO trransfer(amount, accountnumber, recipientname, bankname, accountype, recipientcountry, swiftcode, remarks, userid, reference) VALUES ('{$amount}','{$accountnumber}','{$recipientname}','{$bankname}','{$accountype}','{$recipientcountry}','{$swiftcode}','{$remarks}','{$user_id}','{$reference}')");
            if($insertTransfer){
                $newBalance = $totalBalance - $amount;
                $updateBalance = $conn->query("UPDATE users SET totalbal='{$newBalance}' WHERE id  = '{$user_id}'");
                $updateInvestment = $conn->query("UPDATE investment SET total_balance='{$newBalance}' WHERE user_id = '{$user_id}'");
                if($updateBalance){
                    echo json_encode(["reference" => $reference, "status" => "success"]);
                    // echo "success";
                }else{
                    echo json_encode(["error" => "Wire Transfer Failed"]);
                }
            }
        }

        
        
    }

    function generate_random_alphanumeric($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters_length = strlen($characters);
        $random_string = '';
        for ($i = 0; $i < $length; $i++) {
            $random_string .= $characters[rand(0, $characters_length - 1)];
        }
        return $random_string;
    }