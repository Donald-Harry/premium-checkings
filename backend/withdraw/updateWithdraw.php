<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $withdrawId = $_POST['withdrawId'];
        $withdrawAmount = mysqli_real_escape_string($conn, $_POST["withdrawAmount"]);
        $accountnumber = mysqli_real_escape_string($conn, $_POST["accountnumber"]);
        $recepientname = mysqli_real_escape_string($conn, $_POST["recepientname"]);
        $bankname = mysqli_real_escape_string($conn, $_POST["bankname"]);
        $accounttype = mysqli_real_escape_string($conn, $_POST["accounttype"]);
        $countries = mysqli_real_escape_string($conn, $_POST["country"]);
        $scode = mysqli_real_escape_string($conn, $_POST["scode"]);
        $purpose = mysqli_real_escape_string($conn, $_POST["purpose"]);
        $withdrawalstatus = mysqli_real_escape_string($conn, $_POST["withdrawalstatus"]);

        $updateWithdrawHistory = $conn->query("UPDATE withdraw SET withdraw_amount='{$withdrawAmount}',account_number='{$accountnumber}',recepientname='{$recepientname}',bankname='{$bankname}',accounttype='{$accounttype}',country='{$countries}',scode='{$scode}',purpose='{$purpose}',withdrawalstatus='{$withdrawalstatus}' WHERE withdraw.user_id = '{$user_id}' AND withdraw.id = '{$withdrawId}'");
        if($updateWithdrawHistory){
            echo "success";
        }else{
            echo "error".mysqli_error($conn);
        }
        
        
    }