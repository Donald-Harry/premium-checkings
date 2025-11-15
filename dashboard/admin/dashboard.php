<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
include_once WEB_ROOT . "backend/config.php";

if ($_SESSION['admin_login'] != true) {
    header("Location: index.php");
}

$get_details = $conn->query("SELECT * FROM users");
$get_users_row_number = $get_details->num_rows;

$get_active_accounts = $conn->query("SELECT * FROM users WHERE users.status = '0'");
$active_accounts_rows = $get_active_accounts->num_rows;
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
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/datatable.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/admin/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "dashboard"; include WEB_ROOT . "dashboard/admin/_includes/sidebar.inc.php" ?>
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
                <!-- ========== title-wrapper end ========== -->
                <div class="row">
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon purple">
                                <i class="lni lni-wallet"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Total Customers</h6>
                                <h3 class="text-bold mb-10"><?= $get_users_row_number ?></h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon success">
                                <i class="lni lni-dollar"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Active Accounts</h6>
                                <h3 class="text-bold mb-10"><?= $active_accounts_rows ?></h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon primary">
                                <i class="lni lni-credit-cards"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Total Transactions</h6>
                                <h3 class="text-bold mb-10">$0.00</h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->
                <!-- ========== tables-wrapper start ========== -->
                <div class="tables-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <h6 class="mb-10">Transactions</h6>
                                <div class="table-responsive">
                                    <table id="table" class="table">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <!-- <th>Status</th> -->
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $count = 0;
                                            if ($get_details->num_rows > 0) {
                                                while ($row = $get_details->fetch_assoc()) {
                                            ?>
                                                    <tr>
                                                        <td data-label="Serial No"><?= ++$count ?></td>
                                                        <td data-label="Name"><?= $row['first_name'] ?> <?= $row['last_name'] ?></td>
                                                        <td data-label="Email"><?= $row['email'] ?></td>
                                                        <!-- <td data-label="Status"><span class="badge badge-success">activated</span></td> -->
                                                        <td data-label="Action"><a href="<?= ROOT_URL ?>dashboard/admin/users/details.php?user=<?= $row['id'] ?>" class="btn btn-sm btn-primary">Detail</a></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- ========== tables-wrapper end ========== -->
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
    <script>
        const dataTable = new simpleDatatables.DataTable("#table", {
            searchable: true,
        });
    </script>
</body>

</html>