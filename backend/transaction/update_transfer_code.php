<?php
    session_start();
    include $_SERVER['APP'];
    include_once WEB_ROOT."backend/config.php";
    include_once WEB_ROOT."backend/functions.php";

    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $user_id = $_POST['user_id'];
        $transferCodeId = $_POST['transferCodeId'];
        $firstcodename = mysqli_real_escape_string($conn, $_POST["firstcodename"]);
        $firstcodenumber = mysqli_real_escape_string($conn, $_POST["firstcodenumber"]);
        $secondcodename = mysqli_real_escape_string($conn, $_POST["secondcodename"]);
        $secondcodenumber = mysqli_real_escape_string($conn, $_POST["secondcodenumber"]);
        $thirdcodename = mysqli_real_escape_string($conn, $_POST["thirdcodename"]);
        $thirdcodenumber = mysqli_real_escape_string($conn, $_POST["thirdcodenumber"]);

        //VADLIDATION
        if (!empty($firstcodename)) {
            $firstcodename = secure_input($firstcodename);
        } else {
            echo "Please enter your first transfer code name";
            exit();
        }

        if (!empty($firstcodenumber)) {
            $firstcodenumber = secure_input($firstcodenumber);
        } else {
            echo "Please enter your first transfer code number";
            exit();
        }

        if (!empty($secondcodename)) {
            $secondcodename = secure_input($secondcodename);
        } else {
            echo "Please enter your second transfer code name";
            exit();
        }

        if (!empty($secondcodenumber)) {
            $secondcodenumber = secure_input($secondcodenumber);
        } else {
            echo "Please enter your second transfer code number";
            exit();
        }

        if (!empty($thirdcodename)) {
            $thirdcodename = secure_input($thirdcodename);
        } else {
            echo "Please enter your third transfer code name";
            exit();
        }

        if (!empty($thirdcodenumber)) {
            $thirdcodenumber = secure_input($thirdcodenumber);
        } else {
            echo "Please enter your third transfer code number";
            exit();
        }

        $updateCodes = $conn->query("UPDATE transfercodes SET first_code_name='{$firstcodename}',first_code_number='{$firstcodenumber}',second_code_name='{$secondcodename}',second_code_number='{$secondcodenumber}',third_code_name='{$thirdcodename}',third_code_number='{$thirdcodenumber}' WHERE transfercodes.user_id = '{$user_id}' AND transfercodes.id = '{$transferCodeId}'");
        if($updateCodes){
            echo "success";
        }
        
        
    }

    