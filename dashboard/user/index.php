<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "_includes/companyDetails.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../account");
}

$userid = $_SESSION['user_id'];


$get_user_details = $conn->query("SELECT * FROM users WHERE users.id = '{$userid}'");
$user_row = $get_user_details->fetch_assoc();

$email = $user_row['email'];

$get_transaction_details = $conn->query("SELECT * FROM investment WHERE user_id = '{$userid}'");
if ($get_transaction_details->num_rows > 0) {
    while ($transacion_row = $get_transaction_details->fetch_assoc()) {
        $deposit = $transacion_row['deposit_balance'];
        $available_balance = $transacion_row['total_balance'];
    }
} else {
    $deposit = 0;
}

$get_total_withdraw = $conn->query("SELECT SUM(withdraw_amount) AS total_withdraw FROM withdraw WHERE withdraw.user_id = '{$userid}'");
if ($get_total_withdraw->num_rows > 0) {
    while ($withdraw_row = $get_total_withdraw->fetch_assoc()) {
        $withdraw = $withdraw_row['total_withdraw'];
    }
    if($withdraw == null){
        $withdraw = 0;
    }
} else {
    $withdraw = 0;
}

$get_total_transaction = $conn->query("SELECT SUM(transaction_amount) AS total_transaction FROM transaction_history WHERE user_id = '{$userid}'");
if ($get_total_transaction->num_rows > 0) {
    while ($transaction_row = $get_total_transaction->fetch_assoc()) {
        $transaction = $transaction_row['total_transaction'];
    }
    if($transaction == null){
        $transaction = 0;
    }
} else {
    $transaction = 0;
}

function format_number($number){
    if($number > 999){
        return number_format($number);
    }else{
        return $number;
    }
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
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
</head>

<body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php include WEB_ROOT . "dashboard/_includes/sidebar.inc.php" ?>
    <!-- ======== sidebar-nav end =========== -->

    <!-- ======== main-wrapper start =========== -->
    <main class="main-wrapper">
        <!-- ========== header start ========== -->
        <?php include WEB_ROOT . "dashboard/_includes/header.inc.php" ?>
        <!-- ========== header end ========== -->

        <!-- ========== section start ========== -->
        <section class="section">
            <div class="container-fluid">
                <?php
                    if($user_row['status'] == '-1'){
                ?>
                <div class="alert alert-danger mt-4" role="alert">
                  This account has been banned
                </div>
                <?php
                    }

                    $kyc_status = !empty($user_row['kyc_status']) ? $user_row['kyc_status'] : 'unverified';
                    $has_kyc_docs = !empty($user_row['id_front']) && !empty($user_row['id_back']);
                    if (!$has_kyc_docs && $kyc_status !== 'rejected') {
                        $kyc_status = 'unverified';
                    }

                    if ($kyc_status === 'unverified') {
                ?>
                <div class="alert alert-warning mt-4 p-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 shadow-sm rounded-3 border-0" style="background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%); border-left: 5px solid #ffc107 !important;" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <div style="font-size: 2.2rem; color: #b78103;">
                            <i class="lni lni-warning"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading mb-1 fw-bold" style="color: #664d03;">Identity Verification Required (KYC)</h5>
                            <p class="mb-0" style="color: #7a5c00; font-size: 0.95rem;">
                                You haven't completed your KYC verification. Please upload the <strong>front and back</strong> of your government ID card to ensure account security and avoid restrictions.
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="<?= ROOT_URL ?>dashboard/user/kyc" class="btn btn-warning fw-bold px-4 py-2 text-nowrap text-dark" style="box-shadow: 0 2px 6px rgba(0,0,0,0.12);">
                            <i class="lni lni-shield"></i> Complete KYC Now
                        </a>
                    </div>
                </div>
                <?php
                    } elseif ($kyc_status === 'pending') {
                ?>
                <div class="alert alert-info mt-4 p-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 shadow-sm rounded-3 border-0" style="background: linear-gradient(135deg, #e8f7ff 0%, #d1ecf1 100%); border-left: 5px solid #0dcaf0 !important;" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <div style="font-size: 2.2rem; color: #087990;">
                            <i class="lni lni-timer"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading mb-1 fw-bold" style="color: #055160;">KYC Under Review</h5>
                            <p class="mb-0" style="color: #0c5460; font-size: 0.95rem;">
                                Your ID card documents (front and back) have been submitted and are currently being reviewed by our compliance team.
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="<?= ROOT_URL ?>dashboard/user/kyc" class="btn btn-outline-info fw-bold px-3 py-2 text-nowrap">
                            View Submission
                        </a>
                    </div>
                </div>
                <?php
                    } elseif ($kyc_status === 'rejected') {
                ?>
                <div class="alert alert-danger mt-4 p-3 d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 shadow-sm rounded-3 border-0" style="background: linear-gradient(135deg, #ffeef0 0%, #f8d7da 100%); border-left: 5px solid #dc3545 !important;" role="alert">
                    <div class="d-flex align-items-center gap-3">
                        <div style="font-size: 2.2rem; color: #b02a37;">
                            <i class="lni lni-cross-circle"></i>
                        </div>
                        <div>
                            <h5 class="alert-heading mb-1 fw-bold" style="color: #842029;">KYC Verification Rejected</h5>
                            <p class="mb-0" style="color: #842029; font-size: 0.95rem;">
                                Your ID verification was not approved<?= !empty($user_row['kyc_reason']) ? ': ' . htmlspecialchars($user_row['kyc_reason']) : '. Please re-upload clear photos of the front and back of your ID card.' ?>
                            </p>
                        </div>
                    </div>
                    <div>
                        <a href="<?= ROOT_URL ?>dashboard/user/kyc" class="btn btn-danger fw-bold px-4 py-2 text-nowrap">
                            Re-submit ID Card
                        </a>
                    </div>
                </div>
                <?php
                    }
                ?>
                <!-- ========== title-wrapper start ========== -->
                <div class="title-wrapper pt-30">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="title">
                                <h2>Overview</h2>
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
                    <div class="col-xl-6 col-lg-6 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon purple">
                                <i class="lni lni-wallet"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Account Number</h6>
                                <h3 class="text-bold mb-10"><?= $user_row['account_number'] ?></h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-6 col-lg-6 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon success">
                                <i class="lni lni-dollar"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Available Balance</h6>
                                <h3 class="text-bold mb-10">$<?= format_number($available_balance) ?></h3>
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
                                <h6 class="mb-10">Deposits</h6>
                                <h3 class="text-bold mb-10">$<?= format_number($deposit) ?></h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon orange">
                                <i class="lni lni-user"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Withdrawals</h6>
                                <h3 class="text-bold mb-10">$<?= format_number($withdraw) ?></h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon orange">
                                <i class="lni lni-user"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Transactions</h6>
                                <h3 class="text-bold mb-10">$<?= format_number($transaction) ?></h3>
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
                                                <th>Amount</th>
                                                <th>Time</th>
                                                <th>Date</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Bank Name</th>
                                                <th>Account Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $count = 0;
                                                $get_transaction_history = $conn->query("SELECT * FROM transaction_history WHERE user_id = '{$userid}'");
                                                if($get_transaction_history->num_rows > 0){
                                                    while($row = $get_transaction_history->fetch_assoc()){
                                                        
                                            ?>
                                            <tr>
                                                <td><?= ++$count ?></td>
                                                <td class="" scope="row">
                                                    $<?= $row['transaction_amount']?>
                                                </td>
                                                <td><?= $row['transaction_time']?></td>
                                                <td><?= $row['transaction_date']?></td>
                                                <td><?= $row['transaction_description']?></td>
                                                <td scope="row">
                                                    <span class="badge text-bg-warning">
                                                        <?= $row['transaction_status']?>
                                                    </span>
                                                </td>
                                                <td><?= $row['bank_name']?></td>
                                                <td><?= $row['account_name']?></td>
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
        <?php include WEB_ROOT . "dashboard/_includes/footer.inc.php" ?>
        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="<?= ROOT_URL ?>dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>
</body>

</html>