<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $transferId = $_POST['withdrawId'];
        $amount = mysqli_real_escape_string($conn, $_POST["withdrawAmount"]);
        $accountnumber = mysqli_real_escape_string($conn, $_POST["accountnumber"]);
        $recepientname = mysqli_real_escape_string($conn, $_POST["recepientname"]);
        $bankname = mysqli_real_escape_string($conn, $_POST["bankname"]);
        $accounttype = mysqli_real_escape_string($conn, $_POST["accounttype"]);
        $countries = mysqli_real_escape_string($conn, $_POST["country"]);
        $scode = mysqli_real_escape_string($conn, $_POST["scode"]);
        $purpose = mysqli_real_escape_string($conn, $_POST["purpose"]);
        $status = mysqli_real_escape_string($conn, $_POST["status"]);

        $updateTransfer = $conn->query("UPDATE trransfer SET amount='{$amount}',accountnumber='{$accountnumber}',recipientname='{$recepientname}',bankname='{$bankname}',accountype='{$accounttype}',recipientcountry='{$countries}',swiftcode='{$scode}',remarks='{$purpose}',status='{$status}' WHERE id = '{$transferId}' AND userid = '{$user_id}'");

        if($updateTransfer){
            echo "success";
        }else{
            echo "error".mysqli_error($conn);
        }
    }