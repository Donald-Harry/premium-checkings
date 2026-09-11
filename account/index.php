<?php
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
     	
   <!-- All Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Page Title Here -->
	<title><?= $companyName ?> || Sign In</title>

    <!-- FAVICONS ICON -->
	<link rel="icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">

    <link href="<?= ROOT_URL ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>assets/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/sweetalert2.min.css">
    <link href="<?= ROOT_URL ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>assets/css/custom.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>account/account.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <style>
        html, body{
            height: 100%;
            width: 100%;
        }
    </style>

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <?php //include_once WEB_ROOT."_includes/preloader.inc.php" ?>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div class="account-login">
        <div class="container">
            <!-- <div class="row justify-content-center">
                <div class="col-lg-2">
                    <div class="logo w-100 h-100">
                        <img src="<?= ROOT_URL ?>assets/images/logo/logo.png" class="img-fluid" alt="">
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form inner-content" id="loginform" method="post">
                        <div class="card-body">
                            <div class="title">
                                <h3>Sign In Now</h3>
                                <p>Use the form below to login.</p>
                            </div>
                            <div class="input-head">
                                <div class="row">
                                    <div class="col-lg-12 col-12">
                                        <div class="form-group input-group">
                                            <label><i class="fa-solid fa-envelope"></i></label>
                                            <input class="form-control" type="email" name="email" placeholder="Your email" required="">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group input-group">
                                    <label><i class="fa-solid fa-lock"></i></label>
                                    <input class="form-control" id="first_password" name="password" type="password" placeholder="Your password" required="">
                                    <label class="eye-opener" id="first_password_opener"><i class="fa-solid fa-eye-slash"></i></label>
                                </div>
                            </div>
                            <div class="button">
                                <button class="btn" id="loginbtn" type="submit">Sign me In</button>
                                <a class="btn alt" href="<?= ROOT_URL ?>account/register.php">Sign up Now</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?= ROOT_URL ?>assets/js/pass-show-hide.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.min.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>
    <script>
        const form = document.querySelector("#loginform"),
        loginbtn = form.querySelector("#loginbtn"),
        errortext = form.querySelector("#error-txt");

        form.onsubmit = (e) => {
            e.preventDefault(); // preventing default form submit

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= ROOT_URL ?>backend/account/login.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response ? xhr.response.trim() : '';
                        console.log(data);
                        if (data === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Login successful',
                                closeOnClickOutside: false
                            }).then((result) => {
                                window.location.href = "<?= ROOT_URL ?>dashboard/user/";
                            });
                        } else if (data === 'admin_success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Welcome Admin',
                                closeOnClickOutside: false
                            }).then((result) => {
                                window.location.href = "<?= ROOT_URL ?>dashboard/admin/dashboard.php";
                            });
                        } else if (data === 'not_activated') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Account Not Activated',
                                text: 'Your account is pending email verification. Please enter your OTP code to activate your account.',
                                confirmButtonText: 'Verify OTP Now',
                                confirmButtonColor: '#0d6efd',
                                showCancelButton: true,
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = "<?= ROOT_URL ?>account/verify_otp.php";
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data,
                            });
                        }
                    }
                }
            };
            let formData = new FormData(form);
            xhr.send(formData);
        };
    </script>
</body>
</html>