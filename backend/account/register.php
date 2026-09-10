<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";
    include_once WEB_ROOT."backend/mailer.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
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

        //VADLIDATION
        if (!empty($username)) {
            $username = secure_input($username);
        } else {
            // echo json_encode(["error" => "Please enter your Username"]);
            echo "Please enter your first name";
            exit();
        }

        if (!empty($firstname)) {
            $firstname = secure_input($firstname);
        } else {
            // echo json_encode(["error" => "Please enter your first name"]);
            echo "Please enter your first name";
            exit();
        }

        if (!empty($lastname)) {
            $lastname = secure_input($lastname);
        } else {
            // echo json_encode(["error" => "Please enter your first name"]);
            echo "Please enter your last name";
            exit();
        }

        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                echo "Invalid Email";
                // echo json_encode(["error" => "Invalid Email"]);
                exit();
            }
        } else {
            // echo json_encode(["error" => "Please enter your email"]);
            // echo "Please enter your email";
            exit();
        }

        if (!empty($phone)) {
            $phone = secure_input($phone);
        } else {
            // echo json_encode(["error" => "Please enter your Phone Number"]);
            echo "Please enter your Phone Number";
            exit();
        }

        if (!empty($country)) {
            $country = secure_input($country);
        } else {
            // echo json_encode(["error" => "Please specify your country"]);
            echo "Please specify your country";
            exit();
        }

        if (!empty($dob)) {
            $dob = secure_input($dob);
        } else {
            // echo json_encode(["error" => "Please specify your country"]);
            echo "Please specify your date of birth.";
            exit();
        }

        if (!empty($occupation)) {
            $occupation = secure_input($occupation);
        } else {
            // echo json_encode(["error" => "Please specify your country"]);
            echo "Please specify your occupation";
            exit();
        }

        if (!empty($gender)) {
            $gender = secure_input($gender);
        } else {
            // echo json_encode(["error" => "Please specify your country"]);
            echo "Please specify your gender";
            exit();
        }

        if (!empty($marital_status)) {
            $marital_status = secure_input($marital_status);
        } else {
            // echo json_encode(["error" => "Please specify your country"]);
            echo "Please specify your Marital Status";
            exit();
        }

        if (!empty($account_type)) {
            $account_type = secure_input($account_type);
        } else {
            // echo json_encode(["error" => "Please specify your country"]);
            echo "Please specify your Account Type";
            exit();
        }

        if (!empty($currency)) {
            $currency = secure_input($currency);
        } else {
            // echo json_encode(["error" => "Please specify your country"]);
            echo "Please specify your Currency";
            exit();
        }

        if (!empty($address)) {
            $address = secure_input($address);
        } else {
            // echo json_encode(["error" => "Please specify your country"]);
            echo "Please specify your address";
            exit();
        }

        if (!empty($password)) {
            // if (strlen($password) < 8) {
            //     // echo json_encode(["error" => "Your Password Must Contain At Least 8 Characters!"]);
            //     echo "Your Password Must Contain At Least 8 Characters!";
            //     exit();
            // }
            // elseif (!preg_match("#[0-9]+#", $password)) {
            //     // echo json_encode(["error" => "Your Password must contain at least 1 number!"]);
            //     echo "Your Password must contain at least 1 number!";
            //     exit();
            // }
            // elseif (!preg_match("#[A-Z]+#", $password)) {
            //     // echo json_encode(["error" => "Your Password must contain at least 1 Capital Letter"]);
            //     echo "Your Password must contain at least 1 Capital Letter";
            //     exit();
            // }
            // elseif(!preg_match("#[a-z]+#", $password)){
            //     // echo json_encode(["error" => "Your Password must contain at least 1 Lowercase Letter"]);
            //     echo "Your Password must contain at least 1 Lowercase Letter";
            //     exit();
            // }
        } else {
            // echo json_encode(["error" => "Please enter your password"]);
            echo "Please enter your password";
            exit();
        }

        //Generate the user account number
        function generateRandomNumber() {
            // Set the length limit
            $length = 10;
            
            // Generate random numbers until the length limit is reached
            $number = '';
            while (strlen($number) < $length) {
                $number .= mt_rand(0, 9);
            }
            
            // If the generated number exceeds the length limit, trim it
            $number = substr($number, 0, $length);
            
            return $number;
        }

        // Usage example
        $randomNumber = generateRandomNumber();
        // $accountNumber = time().$randomNumber;
        

        $image = $_FILES['upload_pic'];

        if(empty($image)){
            echo "Please select an image";
            exit();
        }
        // var_dump($image);
        //Get the image data
        $profile = $image['name']; // get the image name
        $tmpName = $image['tmp_name']; // get the image tmp name
        $profileImageSize = $image['size']; // get the image size
        $profileImageType = $image['type']; // get the image type
        $maxSize = 2097152; //2mb
        $allowedFileTypes = ['image/jpeg', 'image/jpg', 'image/gif', 'image/png'];
        $profile = str_replace(' ', '', $profile);
        $renameImage = time().$profile;

        // echo $renameImage; exit();

        $targetFolder = "profileImages/".$renameImage;

        // Validate the image
        if(($profileImageSize > $maxSize) || ($profileImageSize == 0)){
            echo "The file size is too large. It should be less than 2mb";
            exit();
        }else{
            if(in_array($profileImageType, $allowedFileTypes)){
                if(move_uploaded_file($tmpName, $targetFolder)){
                    // echo "yes";
                    //CHECK IF USER ALREADY EXISTS
                     $check = "SELECT * FROM users WHERE email = '{$email}' AND username = '{$username}'";
                     $result = mysqli_query($conn, $check);
                     $result_rows = mysqli_num_rows($result);
                     if($result_rows > 0){
                         // $error = "This email has already been registered. Please login into your account";
                         echo json_encode(["error" => "This email or username has already been registered. Please login into your account"]);
                         exit();
                     }else{
                         // Generate 6-digit OTP code
                         $otp_code = str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);

                         // INSERT INTO DATABASE with status = '0' (pending activation)
                         $insert = "INSERT INTO users(first_name, last_name, username, email, password, phone, dob, country, occupation, gender, marital_status, account_type, currency, profile_pic, address, account_number, totalbal, availbal, status, otp_code, otp_expiry) VALUES ('{$firstname}','{$lastname}','{$username}','{$email}','{$password}','{$phone}','{$dob}','{$country}','{$occupation}','{$gender}','{$marital_status}','{$account_type}','{$currency}','{$renameImage}','{$address}', '{$randomNumber}', '0', '0', '0', '{$otp_code}', DATE_ADD(NOW(), INTERVAL 15 MINUTE))";
             
                         $query = mysqli_query($conn, $insert);
                         if ($query) {
                             $user_id = mysqli_insert_id($conn);
                             // Update the investment account
                             $update_account = mysqli_query($conn, "INSERT INTO investment(user_id, deposit_balance, available_balance, withdrawal) VALUES ('{$user_id}',0,0,0)");

                             // Send OTP email using PHPMailer
                             $fullName = trim($firstname . ' ' . $lastname);
                             send_otp_email($email, $fullName, $otp_code);

                             // Store pending activation in session
                             $_SESSION['pending_activation_user_id'] = $user_id;
                             $_SESSION['pending_activation_email'] = $email;

                             echo "otp_sent";
                             exit();
                         } else {
                             // Return an error message
                             echo "There was an error inserting the user data. Please try again.";
                             // echo "Error: ".mysqli_error($conn);
                         }
                     }
                }
            }
        }
        
        
    }

    