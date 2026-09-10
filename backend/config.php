<?php
$db_server = "localhost";
$db_username = "u840384314_premiumcheckin";
$db_password = "Premiumcheckings1234@";
$db_name = "u840384314_premiumcheckin";

// $db_server = "localhost";
// $db_username = "root";
// $db_password = "";
// $db_name = "empowerbank";

$conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);
if (!$conn) {
    echo "not connected" . mysqli_connect_error();
} else {
    // Check and add otp_code column if it doesn't exist
    $check_otp = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'otp_code'");
    if ($check_otp && mysqli_num_rows($check_otp) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `otp_code` VARCHAR(10) DEFAULT NULL AFTER `status`");
    }

    // Check and add otp_expiry column if it doesn't exist
    $check_expiry = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'otp_expiry'");
    if ($check_expiry && mysqli_num_rows($check_expiry) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `otp_expiry` DATETIME DEFAULT NULL AFTER `otp_code`");
    }
}

// SMTP Email Configuration for PHPMailer
if (!defined('SMTP_HOST'))
    define('SMTP_HOST', 'smtp.gmail.com');
if (!defined('SMTP_PORT'))
    define('SMTP_PORT', 587);
if (!defined('SMTP_USERNAME'))
    define('SMTP_USERNAME', 'pamelappamela140@gmail.com');
if (!defined('SMTP_PASSWORD'))
    define('SMTP_PASSWORD', 'vxij ymxy vwor mxsl');
if (!defined('SMTP_SECURE'))
    define('SMTP_SECURE', 'tls');
if (!defined('SMTP_AUTH'))
    define('SMTP_AUTH', true);
if (!defined('SMTP_FROM_EMAIL'))
    define('SMTP_FROM_EMAIL', 'support@premiumcheckings.com');
if (!defined('SMTP_FROM_NAME'))
    define('SMTP_FROM_NAME', 'Premium Checkings');