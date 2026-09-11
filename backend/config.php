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

    // Check and add KYC columns if they don't exist
    $check_kyc_status = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'kyc_status'");
    if ($check_kyc_status && mysqli_num_rows($check_kyc_status) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `kyc_status` VARCHAR(50) DEFAULT 'unverified'");
    }

    $check_id_type = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'id_type'");
    if ($check_id_type && mysqli_num_rows($check_id_type) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `id_type` VARCHAR(100) DEFAULT NULL");
    }

    $check_id_number = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'id_number'");
    if ($check_id_number && mysqli_num_rows($check_id_number) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `id_number` VARCHAR(100) DEFAULT NULL");
    }

    $check_id_front = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'id_front'");
    if ($check_id_front && mysqli_num_rows($check_id_front) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `id_front` VARCHAR(255) DEFAULT NULL");
    }

    $check_id_back = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'id_back'");
    if ($check_id_back && mysqli_num_rows($check_id_back) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `id_back` VARCHAR(255) DEFAULT NULL");
    }

    $check_kyc_submitted_at = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'kyc_submitted_at'");
    if ($check_kyc_submitted_at && mysqli_num_rows($check_kyc_submitted_at) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `kyc_submitted_at` DATETIME DEFAULT NULL");
    }

    $check_kyc_reason = mysqli_query($conn, "SHOW COLUMNS FROM `users` LIKE 'kyc_reason'");
    if ($check_kyc_reason && mysqli_num_rows($check_kyc_reason) == 0) {
        mysqli_query($conn, "ALTER TABLE `users` ADD COLUMN `kyc_reason` TEXT DEFAULT NULL");
    }

    // Ensure kycDocuments folder exists
    $kyc_upload_dir = __DIR__ . "/account/kycDocuments";
    if (!file_exists($kyc_upload_dir)) {
        @mkdir($kyc_upload_dir, 0777, true);
    }
}

// SMTP Email Configuration for PHPMailer
if (!defined('SMTP_HOST')) define('SMTP_HOST', 'smtp.hostinger.com');
if (!defined('SMTP_PORT')) define('SMTP_PORT', 465);
if (!defined('SMTP_USERNAME')) define('SMTP_USERNAME', 'premiumcheckingssupport@aution.online');
if (!defined('SMTP_PASSWORD')) define('SMTP_PASSWORD', 'Premiumcheckings1234@');
if (!defined('SMTP_SECURE')) define('SMTP_SECURE', 'ssl');
if (!defined('SMTP_AUTH')) define('SMTP_AUTH', true);
if (!defined('SMTP_FROM_EMAIL')) define('SMTP_FROM_EMAIL', 'premiumcheckingssupport@aution.online');
if (!defined('SMTP_FROM_NAME')) define('SMTP_FROM_NAME', 'Premium Checkings');