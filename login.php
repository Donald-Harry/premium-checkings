<?php
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
?>
<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">

    <!--====== Title ======-->
    <title><?= $websitetitle ?></title>

    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--====== Favicon Icon ======-->
    <link rel="shortcut icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/png">

    <!--====== Slick CSS ======-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/slick.css">

    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/lineicons.css">

    <!--====== Line Icons CSS ======-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/font-awesome.min.css">

    <!-- Updated fontawesome -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/all.css">

    <!--====== Animate CSS ======-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/animate.css">

    <!--====== Bootstrap CSS ======-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/bootstrap.min.css">

    <!--====== Default CSS ======-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/default.css">

    <!--====== Style CSS ======-->
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/custom.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/responsive.css">

</head>

<body>
    <!--[if IE]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
  <![endif]-->



    <!--====== PRELOADER PART START ======-->
    <?php include_once WEB_ROOT . "_includes/preloader.inc.php" ?>
    <!--====== PRELOADER PART ENDS ======-->

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
                                    <!-- <label class="eye-opener" id="first_password_opener"><i class="fa-solid fa-eye-slash"></i></label> -->
                                </div>
                            </div>
                            <div class="button">
                                <button class="btn" id="loginbtn" type="submit">Sign me In</button>
                                <!--<a class="btn alt" href="<?= ROOT_URL ?>account/register.php">Sign up Now</a>-->
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



    <!--====== Jquery js ======-->
    <script src="<?= ROOT_URL ?>assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/vendor/modernizr-3.7.1.min.js"></script>

    <!--====== Bootstrap js ======-->
    <script src="<?= ROOT_URL ?>assets/js/popper.min.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/bootstrap.min.js"></script>

    <!--====== Main js ======-->
    <script src="<?= ROOT_URL ?>assets/js/main.js"></script>

    <!-- <script src="<?= ROOT_URL ?>assets/js/pass-show-hide.js"></script> -->
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.min.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>
    <script>
        const form = document.querySelector("#loginform"),
        loginbtn = form.querySelector("#loginbtn"),
        errortext = form.querySelector("#error-txt");

        form.onsubmit = (e) =>{
            e.preventDefault(); // preventing form from submitting
        }

        loginbtn.onclick = ()=>{
            // console.log("Working good");
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= ROOT_URL ?>backend/account/login.php", true);
            xhr.onload = () =>{
                if(xhr.readyState === XMLHttpRequest.DONE){
                    if(xhr.status === 200){
                        let data = xhr.response ? xhr.response.trim() : '';
                        console.log(data);
                        if(data == 'success'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Login successful',
                                closeOnClickOutside: false
                            }).then((result) => {
                                window.location.href = "<?= ROOT_URL ?>dashboard/user/";
                            });
                        }else if(data == 'admin_success'){
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Welcome Admin',
                                closeOnClickOutside: false
                            }).then((result) => {
                                window.location.href = "<?= ROOT_URL ?>dashboard/admin/dashboard.php";
                            });
                        }else if(data == 'not_activated'){
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
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: data,
                            })
                        }
                    }
                }
            }
            //we have to send the form data through ajax to php
            let formData = new FormData(form); //creating new formdata object
            xhr.send(formData); //sending the form data to php
        }
    </script>

</body>

</html>