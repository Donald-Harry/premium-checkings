<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $firstname = mysqli_real_escape_string($conn, $_POST["firstname"]);
        $lastname = mysqli_real_escape_string($conn, $_POST["lastname"]);
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $phone = mysqli_real_escape_string($conn, $_POST["phone"]);
        $dob = mysqli_real_escape_string($conn, $_POST["dob"]);
        $country = mysqli_real_escape_string($conn, $_POST["country"]);
        $occupation = mysqli_real_escape_string($conn, $_POST["occupation"]);
        $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
        $marital_status = mysqli_real_escape_string($conn, $_POST["marital_status"]);
        $account_type = mysqli_real_escape_string($conn, $_POST["account_type"]);
        $currency = mysqli_real_escape_string($conn, $_POST["currency"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        $address = mysqli_real_escape_string($conn, $_POST["address"]);

        if(empty($country)){
            echo "Please enter a country again.";
        }

        $image = $_FILES['upload_pic'];
        $profile_pic = $image['name'];

        
        if(empty($profile_pic)){
            $get_existing_pic = $conn->query("SELECT profile_pic FROM users WHERE users.id = '{$user_id}'");
            $pic_row = $get_existing_pic->fetch_assoc();
            
            $profile_pic = $pic_row['profile_pic'];            
        }else{
            $tmpName = $image['tmp_name']; // get the image tmp name
            $profileImageSize = $image['size']; // get the image size
            $profileImageType = $image['type']; // get the image type
            $maxSize = 2097152; //2mb
            $allowedFileTypes = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png'];
            $profile = str_replace(' ', '', $profile_pic);
            $profile_pic = time().$profile;

            // echo $renameImage; exit();

            $targetFolder = "profileImages/".$profile_pic;

            // Validate the image
            if(($profileImageSize > $maxSize) || ($profileImageSize == 0)){
                echo "The file size is too large. It should be less than 2mb";
                exit();
            }else{
                if(in_array($profileImageType, $allowedFileTypes)){
                    if(move_uploaded_file($tmpName, $targetFolder)){
                        // echo "Upload successful";
                    }
                }else{
                    echo "Upload a valid profile image";
                }
            }
        }

        // Update profile
        $update_profile = $conn->query("UPDATE users SET first_name='{$firstname}',last_name='{$lastname}',username='{$username}',email='{$email}',password='{$password}',phone='{$phone}',dob='{$dob}',country='{$country}',occupation='{$occupation}',gender='{$gender}',marital_status='{$marital_status}',account_type='{$account_type}',currency='{$currency}',profile_pic='{$profile_pic}',address='{$address}' WHERE users.id = '{$user_id}'");
        if($update_profile){
            echo "success";   
        }
        // else {
        //     echo mysqli_error($conn);
        // }
    }