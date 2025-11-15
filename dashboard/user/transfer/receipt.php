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

$email = $user_row['email'];
function format_number($number)
{
    if ($number > 999) {
        return number_format($number);
    } else {
        return $number;
    }
}

$reference = $_GET['transaction'];


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
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
    <style>
        .center {
            width: fit-content;
            margin: auto;
            text-align: center;
        }

        .invoice-card .invoice-header .invoice-logo {
            width: 15rem;
            height: fit-content;
            border-radius: unset;
            overflow: hidden;
        }
    </style>

    
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "transfer";
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

                <!-- Invoice Wrapper Start -->
                <div class="invoice-wrapper">
                    <div class="row">
                        <div class="col-12">
                            <div class="invoice-card card-style mb-30">
                                <div class="invoice-header">
                                    <div class="invoice-for">
                                        <h2 class="mb-10">Transaction Details</h2>
                                    </div>
                                    <div class="invoice-logo navbar-brand">
                                        <!--<img src="<?= ROOT_URL ?>assets/images/logo-no-background.svg" alt="logo">-->
                                        <p style="font-size:1.4em; font-weight:bold">Premium<span style="color:navy">Checkings</span></p>
                                    </div>
                                    <!-- <div class="invoice-date">
                                        <p><span>Date Issued:</span> 20/02/2024</p>
                                        <p><span>Date Due:</span> 20/02/2028</p>
                                        <p><span>Order ID:</span> #5467</p>
                                    </div> -->
                                </div>
                                <div class="table-responsive">
                                    <table class="invoice-table table">
                                        <tbody>
                                            <?php
                                            $get_transaction_history = $conn->query("SELECT * FROM trransfer WHERE userid = '{$userid}' AND reference = '{$reference}'");
                                            if ($get_transaction_history->num_rows > 0) {
                                                while ($row = $get_transaction_history->fetch_assoc()) {
                                            ?>
                                                    <div class="center">
                                                        <h1 class="mb-3 text-warning tf_status">Pending</h1>
                                                        <h6 class="mb-3">Transaction Amount</h6>
                                                        <h2>$<?= format_number($row['amount']) ?></h2>
                                                    </div>
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm">Beneficiary Details</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm">
                                                                <?= $row['recipientname'] ?>
                                                                <br>
                                                                <?= $row['bankname'] ?> | <?= $row['accountnumber'] ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm">Sender Details</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm">
                                                                <?= $user_row['first_name'] ?> <?= $user_row['last_name'] ?>
                                                                <br>
                                                                <?= $companyName ?> | <?= $user_row['account_number'] ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm">Paid On</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm">
                                                                <?= $row['datetime'] ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm">Fees</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm">
                                                                $0
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm">Description</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm">
                                                                <?= $row['remarks'] ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm">Transaction Reference</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm">
                                                                <?= $reference ?>
                                                            </p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="text-sm">Payment Type</p>
                                                        </td>
                                                        <td>
                                                            <p class="text-sm">
                                                                Wire Transfer
                                                            </p>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <div class="note-wrapper warning-alert py-4 px-sm-3 px-lg-5">
                                    <div class="alert">
                                        <h5 class="text-bold mb-15">Notes:</h5>
                                        <p class="text-sm text-gray">
                                            All accounts are to be paid within 7 days from receipt
                                            of invoice. To be paid by cheque or credit card or
                                            direct payment online. If account is not paid within 7
                                            days the credits details supplied as confirmation of
                                            work undertaken will be charged the agreed quoted fee
                                            noted above.
                                        </p>
                                    </div>
                                </div>
                                <div class="invoice-action">
                                    <ul class="d-flex flex-wrap align-items-center justify-content-center">
                                        <li class="m-2">
                                            <a href="#0" class="main-btn primary-btn-outline btn-hover">
                                                Download Invoice
                                            </a>
                                        </li>
                                        <li class="m-2">
                                            <a href="#0" class="main-btn primary-btn btn-hover">
                                                Send Invoice
                                            </a>
                                        </li>
                                    </ul>
                                </div> -->
                            </div>
                            <!-- End Card -->
                        </div>
                        <!-- ENd Col -->
                    </div>
                    <!-- End Row -->
                </div>
                <!-- Invoice Wrapper End -->
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
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>
    <script>
        setInterval(function() {
            var xhr = new XMLHttpRequest();
            var id = '<?= $reference ?>'; // The ID you want to send, modify as necessary
            var tfStatus = document.querySelector(".tf_status");

            // Open a GET request and pass the id as a query parameter
            xhr.open('GET', '<?= ROOT_URL ?>backend/transfer/check_transfer_status.php?id=' + id, true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);

                    if (response.status === "updated") {
                        
                        tfStatus.innerHTML = "Success";
                        tfStatus.classList.remove("text-warning");
                        tfStatus.classList.add("text-success");
                        // console.log("Status has changed to: " + response.newStatus);
                    } else {
                        console.log("No status change");
                    }
                } else {
                    console.error('Error: ' + xhr.status);
                }
            };

            xhr.send(); // Send the request
        }, 10000); // Run every 10 seconds
    </script>
</body>

</html>