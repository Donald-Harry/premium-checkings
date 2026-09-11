<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "backend/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = mysqli_real_escape_string($conn, secure_input($_POST["email"]));
    $password = mysqli_real_escape_string($conn, secure_input($_POST["password"]));

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // echo json_encode(["error" => "Invalid Email"]);
            echo "Invalid Email";
            exit();
        }
    } else {
        // echo json_encode(["error" => "Please enter your email"]);
        echo "Please enter your email";
        exit();
    }

    if (empty($password)) {
        // echo json_encode(["error" => "Please enter your password"]);
        echo "Please enter your password";
        exit();
    }

    // Check if logging in as admin (admin@gmail.com or email in admin table)
    $clean_email = strtolower(trim($email));
    $check_admin_email = mysqli_query($conn, "SELECT * FROM admin WHERE LOWER(email) = '{$clean_email}'");
    $is_admin_email = ($clean_email === 'admin@gmail.com') || ($check_admin_email && mysqli_num_rows($check_admin_email) > 0);

    if ($is_admin_email) {
        $check_admin = "SELECT * FROM admin WHERE LOWER(email) = '{$clean_email}' AND password = '{$password}'";
        $result_admin = mysqli_query($conn, $check_admin);
        if ($result_admin && mysqli_num_rows($result_admin) > 0) {
            $row = mysqli_fetch_assoc($result_admin);
            $user_id = $row['id'];
            $_SESSION['admin_login'] = true;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['admin_email'] = $row['email'];
            echo "admin_success";
            exit();
        } else {
            echo "Incorrect password";
            exit();
        }
    }

    $check = "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'";
    $result = mysqli_query($conn, $check);
    $result_rows = mysqli_num_rows($result);
    if ($result_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        $user_id = $row['id'];

        // Check if account is activated
        if ($row['status'] == '0') {
            $_SESSION['pending_activation_user_id'] = $user_id;
            $_SESSION['pending_activation_email'] = $row['email'];
            echo "not_activated";
            exit();
        }

        // Check if account is banned
        if ($row['status'] == '-1') {
            echo "This account has been banned. Please contact support.";
            exit();
        }

        echo "success";
        $_SESSION['userlogin'] = true;
        $_SESSION['user_id'] = $user_id;
        exit();
    } else {
        // Check if email exists in users table to provide accurate feedback
        $check_user_email = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        if ($check_user_email && mysqli_num_rows($check_user_email) > 0) {
            echo "Incorrect password";
        } else {
            echo "This user does not exist in our database";
        }
        exit();
    }
}
