<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";

if ($_SESSION['admin_login'] != true) {
    header("Location: ../index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">
    <title><?= $companyName ?> || Dashboard</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/lineicons.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/all.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/datatable.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/iziToast.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/admin/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "addUsers";
    include WEB_ROOT . "dashboard/admin/_includes/sidebar.inc.php" ?>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        <?php include WEB_ROOT . "dashboard/admin/_includes/header.inc.php" ?>
        <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>Dashboard</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <p class="text-muted text-blue">Hello Admin, welcome back!</p>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <form action="#" id="addUser" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 col-12">
                                        <div class="input-style-1">
                                            <label for="firstname" class="required">First Name</label>
                                            <input class="form-control" type="text" name="firstname" required="" id="firstname">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-6 col-12">
                                        <div class="input-style-1">
                                            <label class="form-control-label required" for="lastname">Last Name</label>
                                            <input class="form-control" type="text" name="lastname" required="" id="lastname">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-6 col-12">
                                        <div class="input-style-1">
                                            <label for="username">Username</label>
                                            <input class="form-control" type="text" name="username" id="username">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-6 col-12">
                                        <div class="input-style-1">
                                            <label for="email" class="required">Email </label>
                                            <input class="form-control" type="email" name="email" required="" id="email">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-md-6 col-12">
                                        <div class="input-style-1">
                                            <label class="required">Mobile Number </label>
                                            <div class="input-group ">
                                                <span class="input-group-text mobile-code"><i class="fa-solid fa-phone"></i></span>
                                                <input type="number" name="phone" value="" id="mobile" class="form-control checkUser" required="">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-sm-6 col-12">
                                        <div class="input-style-1">
                                            <label for="dob">Date of Birth</label>
                                            <input class="form-select" type="date" name="dob" id="dob">
                                        </div>
                                        <!-- end select -->
                                    </div>
                                    <!-- end col -->
                                    <div class="col-sm-6 col-12">
                                        <div class="select-style-1">
                                            <label for="country">Country</label>
                                            <div class="select-position">
                                                <select name="country" id="country">
                                                    <option value="nga">Nigeria</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-sm-6 col-12">
                                        <div class="input-style-1">
                                            <label for="occupation">Occupation</label>
                                            <input class="form-control" type="text" name="occupation" id="occupation">
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-sm-6 col-12">
                                        <div class="">
                                            <label for="gender" class="d-block">Gender</label>
                                            <div class="form-check form-check-inline">
                                                <input checked class="form-check-input" type="radio" name="gender" id="male" value="male">
                                                <label class="form-check-label" for="male">Male</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                                <label class="form-check-label" for="female">Female</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="gender" id="other" value="other">
                                                <label class="form-check-label" for="other">Other</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-sm-6 col-12">
                                        <div class="input-style-1">
                                            <label for="marital_status">Marital Status</label>
                                            <input class="form-control" type="text" name="marital_status" id="marital_status">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-sm-6 col-12">
                                        <div class="input-style-1">
                                            <label for="account_type">Account Type</label>
                                            <input class="form-control" type="text" name="account_type" id="account_type">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="input-style-1">
                                            <label for="password">Password</label>
                                            <input class="form-control" type="password" name="password" id="password">
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="select-style-1">
                                            <label for="currency">Currency</label>
                                            <select name="currency" class="form-control" id="currency">
                                                <option value="$">Dollar</option>
                                                <option value="€">Euro</option>
                                                <option value="£">Pound</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-12">
                                        <div class="input-style-1">
                                            <label for="upload_pic">Upload Picture</label>
                                            <input class="form-control" type="file" name="upload_pic" id="upload_pic">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label for="address">Address</label>
                                            <input class="form-control" type="text" name="address" value="35 Shepherd St London W1J 7HZ, UK" id="address">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button id="addbtn" class="main-btn primary-btn btn-hover m-2">
                                                Add User
                                            </button>
                                            <button class="main-btn danger-btn-outline m-2">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- end row -->
                            </form>
                        </div>
                        <!-- end card -->
                    </div>
                    <!-- end col -->
                </div>
                <!-- End Row -->
            </div>
            <!-- end container -->
        </section>
        <!-- ========== section end ========== -->

        <!-- ========== footer start =========== -->
        <?php include WEB_ROOT . "dashboard/admin/_includes/footer.inc.php" ?>
        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="<?= ROOT_URL ?>dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/datatable.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/jquery.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/iziToast.js"></script>
    <script>
        window.onload = function(argument) {
            var country = document.querySelector('#country')
            $.ajax({
                url: '<?= ROOT_URL ?>_includes/countries.php',
                beforeSend: function(argument) {

                },
                success: function(res) {
                    res = JSON.parse(res);
                    for (i = 0; i < res.length; i++) {
                        country.innerHTML += "<option value=" + res[i].code + ">" + res[i].name + "</option>";
                    }

                }
            });

        }
    </script>

    <script>
        const form = document.querySelector("#addUser"),
            addbtn = form.querySelector("#addbtn"),
            errortext = form.querySelector("#error-txt");

        form.onsubmit = (e) => {
            e.preventDefault(); // preventing form from submitting
        }

        addbtn.onclick = () => {
            // console.log("Working good");
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= ROOT_URL ?>backend/account/register.php", true);
            xhr.onload = () => {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        let data = xhr.response;
                        console.log(data);
                        if (data == 'success') {
                            iziToast.show({
                                title: 'Hey',
                                message: `Registration successful`,
                                position: "topRight",
                                backgroundColor: '#90EE90'
                            });
                            // function moveOn(){
                            //     location.href = '<?= ROOT_URL ?>';
                            // }                     
                            // setTimeout(moveOn, 2000);
                        } else {
                            iziToast.show({
                                title: 'Hey',
                                message: data,
                                position: "topRight",
                                backgroundColor: '#FF474C'
                            });
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