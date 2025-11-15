<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
?>
<!doctype html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">
    <title><?= $companyName ?> || Admin Dashboard</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/lineicons.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/all.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/style.css">

    <link href="<?= ROOT_URL ?>en/css/style.css" rel="stylesheet">


</head>

<body>
    <main class="main-wrapper full-width">
        <div class="row g-0 auth-row">

            <div class="col-lg-6">
                <div class="auth-cover-wrapper bg-primary-100">
                    <div class="auth-cover">
                        <div class="title text-center">

                            <!-- image -->
                            <!-- <div class="mb-2">
                                <img src="<?= ROOT_URL ?>assets/images/logo.jpeg" class="img-fluid user-select-none">
                            </div> -->

                            <h1 class="text-white mb-10"><?= $companyName ?></h1>

                            <p class="text-light">Welcome To <?= $companyName ?></p>

                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">

                <div class="auth-wrapper">
                    <div class="flex-grow-1">
                        <form method="post" action="<?= ROOT_URL ?>backend/account/admin_login.php" id="auth-form" enctype="multipart/form-data">
                            <div class="row py-3">
                                <div class="col-sm-10 col-md-9 m-auto">
                                    <h4 class="text-center fw-light mb-3">
                                        <i class="bi-stars animate__animated animate__delay-1s animate__flash "></i>
                                        <span class="d-block mt-2">Hi Admin</span>
                                    </h4>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-envelope"></i>
                                            </span>
                                            <input type="email" placeholder="Email" class="form-control" name="email" required="">
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <div class="input-group">
                                            <span class="input-group-text">
                                                <i class="bi bi-lock"></i>
                                            </span>
                                            <input type="password" placeholder="Password" class="form-control" name="password" required="">
                                        </div>
                                    </div>
                                    <div class="">
                                        <button class="btn btn-outline-success w-100" type="submit">
                                            <i class="bi bi-power"></i> - Login
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </form>
                    </div>
                </div>

            </div>

        </div>
    </main>

    <!-- JAVASCRIPT FILES -->
    <script src="<?= ROOT_URL ?>dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>

</body>

</html>