<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "backend/functions.php";
include_once WEB_ROOT . "backend/mailer.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $firstname = isset($_POST["firstname"]) ? mysqli_real_escape_string($conn, secure_input($_POST["firstname"])) : '';
    $middle_name = isset($_POST["middle_name"]) ? mysqli_real_escape_string($conn, secure_input($_POST["middle_name"])) : '';
    $lastname = isset($_POST["lastname"]) ? mysqli_real_escape_string($conn, secure_input($_POST["lastname"])) : '';
    $username = isset($_POST["username"]) ? mysqli_real_escape_string($conn, secure_input($_POST["username"])) : '';
    $email = isset($_POST["email"]) ? mysqli_real_escape_string($conn, secure_input($_POST["email"])) : '';
    $phone = isset($_POST["phone"]) ? mysqli_real_escape_string($conn, secure_input($_POST["phone"])) : '';
    $country = isset($_POST["country"]) ? mysqli_real_escape_string($conn, secure_input($_POST["country"])) : '';
    $account_type = isset($_POST["account_type"]) ? mysqli_real_escape_string($conn, secure_input($_POST["account_type"])) : 'Savings Account';
    $pin = isset($_POST["pin"]) ? mysqli_real_escape_string($conn, secure_input($_POST["pin"])) : '';
    $password = isset($_POST["password"]) ? mysqli_real_escape_string($conn, secure_input($_POST["password"])) : '';
    $confirm_password = isset($_POST["confirm_password"]) ? mysqli_real_escape_string($conn, secure_input($_POST["confirm_password"])) : '';

    // Optional fields with defaults
    $currency = !empty($_POST["currency"]) ? mysqli_real_escape_string($conn, secure_input($_POST["currency"])) : '$';
    $dob = !empty($_POST["dob"]) ? mysqli_real_escape_string($conn, secure_input($_POST["dob"])) : '';
    $occupation = !empty($_POST["occupation"]) ? mysqli_real_escape_string($conn, secure_input($_POST["occupation"])) : '';
    $gender = !empty($_POST["gender"]) ? mysqli_real_escape_string($conn, secure_input($_POST["gender"])) : '';
    $marital_status = !empty($_POST["marital_status"]) ? mysqli_real_escape_string($conn, secure_input($_POST["marital_status"])) : '';
    $address = !empty($_POST["address"]) ? mysqli_real_escape_string($conn, secure_input($_POST["address"])) : '';

    // Combine middle name if provided
    $full_first_name = !empty($middle_name) ? trim($firstname . ' ' . $middle_name) : $firstname;

    // VALIDATION
    if (empty($firstname)) {
        echo "Please enter your legal first name.";
        exit();
    }

    if (empty($lastname)) {
        echo "Please enter your legal last name.";
        exit();
    }

    if (empty($username)) {
        echo "Please enter a unique username.";
        exit();
    }

    if (strlen($username) < 3) {
        echo "Username must be at least 3 characters long.";
        exit();
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Please provide a valid email address.";
        exit();
    }

    if (empty($phone)) {
        echo "Please enter your phone number.";
        exit();
    }

    if (empty($country)) {
        echo "Please select your country.";
        exit();
    }

    if (empty($account_type)) {
        echo "Please select an account type.";
        exit();
    }

    if (empty($pin)) {
        echo "Please enter a 4-digit transaction PIN.";
        exit();
    }

    if (!preg_match('/^[0-9]{4}$/', $pin)) {
        echo "Transaction PIN must be exactly 4 digits.";
        exit();
    }

    if (empty($password)) {
        echo "Please enter your password.";
        exit();
    }

    if (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
        exit();
    }

    if (!empty($confirm_password) && $password !== $confirm_password) {
        echo "Password and confirmation do not match.";
        exit();
    }

    // Generate 10-digit random account number
    $randomNumber = '';
    while (strlen($randomNumber) < 10) {
        $randomNumber .= mt_rand(0, 9);
    }

    // Profile picture handling: default if none uploaded
    $renameImage = 'default.png';
    if (isset($_FILES['upload_pic']) && !empty($_FILES['upload_pic']['name']) && $_FILES['upload_pic']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['upload_pic'];
        $profile = str_replace(' ', '', $image['name']);
        $tmpName = $image['tmp_name'];
        $profileImageSize = $image['size'];
        $profileImageType = $image['type'];
        $maxSize = 2097152; // 2MB
        $allowedFileTypes = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png'];

        if ($profileImageSize <= $maxSize && in_array($profileImageType, $allowedFileTypes)) {
            $newImageName = time() . '_' . $profile;
            $targetFolder = WEB_ROOT . "backend/account/profileImages/" . $newImageName;
            if (move_uploaded_file($tmpName, $targetFolder)) {
                $renameImage = $newImageName;
            }
        }
    }

    // Check if user already exists
    $clean_email = strtolower(trim($email));
    $clean_username = strtolower(trim($username));
    $check = "SELECT * FROM users WHERE LOWER(email) = '{$clean_email}' OR LOWER(username) = '{$clean_username}'";
    $result = mysqli_query($conn, $check);
    if ($result && mysqli_num_rows($result) > 0) {
        echo "This email or username has already been registered. Please log in.";
        exit();
    }

    // Generate 6-digit OTP code
    $otp_code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

    // Insert user into database
    $insert = "INSERT INTO users(first_name, last_name, username, email, password, phone, dob, country, occupation, gender, marital_status, account_type, currency, profile_pic, address, account_number, totalbal, availbal, status, otp_code, otp_expiry, pin) 
               VALUES ('{$full_first_name}', '{$lastname}', '{$username}', '{$email}', '{$password}', '{$phone}', '{$dob}', '{$country}', '{$occupation}', '{$gender}', '{$marital_status}', '{$account_type}', '{$currency}', '{$renameImage}', '{$address}', '{$randomNumber}', 0.00, 0.00, '0', '{$otp_code}', DATE_ADD(NOW(), INTERVAL 15 MINUTE), '{$pin}')";

    $query = mysqli_query($conn, $insert);
    if ($query) {
        $user_id = mysqli_insert_id($conn);

        // Update the investment account
        @mysqli_query($conn, "INSERT INTO investment(user_id, deposit_balance, available_balance, withdrawal) VALUES ('{$user_id}', 0, 0, 0)");

        // Send OTP email using PHPMailer
        $fullName = trim($full_first_name . ' ' . $lastname);
        send_otp_email($email, $fullName, $otp_code);

        // Store pending activation in session
        $_SESSION['pending_activation_user_id'] = $user_id;
        $_SESSION['pending_activation_email'] = $email;

        echo "otp_sent";
        exit();
    } else {
        echo "Registration error: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}