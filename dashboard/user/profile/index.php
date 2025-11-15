<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "_includes/companyDetails.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../account");
}

$userid = $_SESSION['user_id'];

$get_user_details = $conn->query("SELECT * FROM users WHERE users.id = '{$userid}'");

$user_row = $get_user_details->fetch_assoc();
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
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/quill/bubble.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/quill/snow.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/fullcalendar.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/morris.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/datatable.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "profile";
    include WEB_ROOT . "dashboard/_includes/sidebar.inc.php" ?>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        <?php include WEB_ROOT . "dashboard/_includes/header.inc.php" ?>
        <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>Profile</h2>
                            </div>
                        </div>
                        <!-- end col -->
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <p class="text-muted text-blue">Hello <?= $user_row['username'] ?>, welcome back!</p>
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== title-wrapper end ========== -->

                <!-- ========== profile start ========== -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-sm-6">
                        <div class="card-style mb-30">
                            <div class="custom-block custom-block-profile">
                                <div class="row">
                                    <div class="col-lg-12 col-12 mb-3">
                                        <h6>General</h6>
                                    </div>

                                    <?php

                                    ?>
                                    <div class="col-lg-3 col-12 mb-4 mb-lg-0">
                                        <div class="custom-block-profile-image-wrap">
                                            <img src="<?= ROOT_URL ?>backend/account/profileImages/<?= $user_row['profile_pic'] ?>" class="custom-block-profile-image img-fluid" alt="">

                                            <!-- <a href="<?= ROOT_URL ?>en/user/account/setting.php" class="bi-pencil-square custom-block-edit-icon"></a> -->
                                        </div>
                                    </div>


                                    <div class="col-lg-9 col-12">
                                        <div class="row">
                                            <div class="col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="profileDetails">Full Name</label>
                                                    <p><?= $user_row['first_name'] ?> <?= $user_row['last_name'] ?></p>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="profileDetails">Email Address</label>
                                                    <p><?= $user_row['email'] ?></p>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="profileDetails">Phone</label>
                                                    <p><?= $user_row['phone'] ?></p>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="profileDetails">Birthday</label>
                                                    <p><?= $user_row['dob'] ?></p>
                                                </div>
                                            </div>

                                            <div class="col-sm-6 mb-4">
                                                <div class="form-group">
                                                    <label class="profileDetails">Address</label>
                                                    <p><?= $user_row['address'] ?></p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- ========== profile end ========== -->
            </div>
            <!-- end container -->
        </section>
        <!-- ========== section end ========== -->

        <!-- ========== footer start =========== -->
        <?php include WEB_ROOT . "dashboard/_includes/footer.inc.php" ?>
        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="<?= ROOT_URL ?>dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/Chart.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/apexcharts.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/dynamic-pie-chart.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/moment.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/fullcalendar.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/jvectormap.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/world-merc.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/polyfill.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/quill.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/datatable.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/Sortable.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>

    <script>
        const dataTable = new simpleDatatables.DataTable("#table", {
            searchable: true,
        });
    </script>
</body>

</html>