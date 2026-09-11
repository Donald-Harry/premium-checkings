<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "backend/functions.php";

if (!isset($_SESSION['user_id'])) {
    echo "Unauthorized. Please log in.";
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $first_name = isset($_POST['first_name']) ? mysqli_real_escape_string($conn, secure_input($_POST['first_name'])) : '';
    $last_name = isset($_POST['last_name']) ? mysqli_real_escape_string($conn, secure_input($_POST['last_name'])) : '';
    $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, secure_input($_POST['phone'])) : '';
    $dob = isset($_POST['dob']) ? mysqli_real_escape_string($conn, secure_input($_POST['dob'])) : '';
    $country = isset($_POST['country']) ? mysqli_real_escape_string($conn, secure_input($_POST['country'])) : '';
    $occupation = isset($_POST['occupation']) ? mysqli_real_escape_string($conn, secure_input($_POST['occupation'])) : '';
    $address = isset($_POST['address']) ? mysqli_real_escape_string($conn, secure_input($_POST['address'])) : '';

    if (empty($first_name) || empty($last_name)) {
        echo "First name and Last name are required.";
        exit();
    }

    // Handle Profile Picture upload if provided
    $profile_pic_sql = "";
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_pic'];
        $maxSize = 3 * 1024 * 1024; // 3MB
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

        if ($file['size'] > $maxSize) {
            echo "Profile image is too large. Maximum size is 3MB.";
            exit();
        }

        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $mime = mime_content_type($file['tmp_name']);

        if (!in_array($ext, $allowedExtensions) || !in_array($mime, $allowedMimes)) {
            echo "Invalid image type. Please upload a valid JPG, PNG, GIF, or WEBP image.";
            exit();
        }

        $uploadDir = WEB_ROOT . "backend/account/profileImages/";
        if (!file_exists($uploadDir)) {
            @mkdir($uploadDir, 0777, true);
        }

        $newFileName = "user_" . $user_id . "_" . time() . "." . $ext;
        $targetPath = $uploadDir . $newFileName;

        if (move_uploaded_file($file['tmp_name'], $targetPath)) {
            $profile_pic_sql = ", profile_pic = '{$newFileName}'";
        } else {
            echo "Failed to upload profile picture.";
            exit();
        }
    }

    $update_query = "UPDATE users SET 
        first_name = '{$first_name}',
        last_name = '{$last_name}',
        phone = '{$phone}',
        dob = '{$dob}',
        country = '{$country}',
        occupation = '{$occupation}',
        address = '{$address}'
        {$profile_pic_sql}
        WHERE id = '{$user_id}'";

    if (mysqli_query($conn, $update_query)) {
        echo "success";
        exit();
    } else {
        echo "Failed to update profile: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Invalid request method.";
    exit();
}
