<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "_includes/companyDetails.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../../account");
    exit();
}

$userid = $_SESSION['user_id'];

$user_id = $amount = $accountnumber = $recipientname = $recipientcountry = $bankname = $accountype = $swiftcode = $remarks = "";


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $accountnumber = mysqli_real_escape_string($conn, $_POST["accountnumber"]);
    $recipientname = mysqli_real_escape_string($conn, $_POST["recipientname"]);
    $bankname = mysqli_real_escape_string($conn, $_POST["bankname"]);
    $accountype = mysqli_real_escape_string($conn, $_POST["accountype"]);
    $recipientcountry = mysqli_real_escape_string($conn, $_POST["recipientcountry"]);
    $swiftcode = mysqli_real_escape_string($conn, $_POST["swiftcode"]);
    $remarks = mysqli_real_escape_string($conn, $_POST["remarks"]);
}

if (empty($user_id) && empty($amount)) {
    header("Location: ../index.php");
}

$get_code = $conn->query("SELECT * FROM transfercodes WHERE user_id = '{$user_id}'");
if ($get_code->num_rows > 0) {
    while ($row = $get_code->fetch_assoc()) {
        $code_name = $row['first_code_name'];
    }
}else{
    $code_name = "There is no code name";
}

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
    <?php $location = "transfer"; include WEB_ROOT . "dashboard/_includes/sidebar.inc.php" ?>
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
                                <h2>Transfer</h2>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <div class="card-header">
                                <p>Kindly validate this transaction with your account <?= $code_name ?>! Don't have it? kindly contact email: support@dirtyscripts.shop</p>
                            </div>
                            <form method="POST" action="<?= ROOT_URL ?>dashboard/user/transfer/security/check_2.php" id="transfer_form" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                <input type="hidden" name="amount" value="<?= $amount ?>">
                                <input type="hidden" name="accountnumber" value="<?= $accountnumber ?>">
                                <input type="hidden" name="recipientname" value="<?= $recipientname ?>">
                                <input type="hidden" name="bankname" value="<?= $bankname ?>">
                                <input type="hidden" name="accountype" value="<?= $accountype ?>">
                                <input type="hidden" name="recipientcountry" value="<?= $recipientcountry ?>">
                                <input type="hidden" name="swiftcode" value="<?= $swiftcode ?>">
                                <input type="hidden" name="remarks" value="<?= $remarks ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label><?= $code_name ?></label>
                                            <input class="form-control" name="code_1" placeholder="*****" type="text" required="">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button class="main-btn primary-btn btn-hover m-2">
                                                Transfer
                                            </button>
                                            <button type="reset" class="main-btn danger-btn-outline m-2">
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