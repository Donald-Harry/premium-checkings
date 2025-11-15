<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT."backend/config.php";
include_once WEB_ROOT."backend/functions.php";

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $user_id = $_POST['user_id'];
    $ticketType = mysqli_real_escape_string($conn, $_POST["ticket_type"]);
    $message = mysqli_real_escape_string($conn, $_POST["message"]);

    if(empty($ticketType) || $ticketType == "not_selected"){
        $_SESSION['message'] = "Please select a ticket type";
        header("Location: ../../dashboard/user/support/open-tickets.php");
        exit();
    }else{
        if(!empty($message)){
            $insert = $conn->query("INSERT INTO tickets(ticket_type, message, user_id) VALUES ('{$ticketType}','{$message}','{$user_id}')");
            if($insert){
                $_SESSION['message'] = "success";
                header("Location: ../../dashboard/user/support/open-tickets.php");
                exit();
            }
        }else{
            $_SESSION['message'] = "Please type your complaint";
            header("Location: ../../dashboard/user/support/open-tickets.php");
            exit();
        }
    }
}