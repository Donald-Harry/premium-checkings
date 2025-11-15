<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
include_once WEB_ROOT . "backend/config.php";

if ($_SESSION['admin_login'] != true) {
    header("Location: ../index.php");
}

$user_id = $_GET["user"];

$get_user_details = $conn->query("SELECT * FROM users WHERE users.id = '{$user_id}'");
if ($get_user_details->num_rows > 0) {
    while ($row = $get_user_details->fetch_assoc()) {
        $username = $row['username'];
        $account_number = $row['account_number'];
        $email = $row['email'];
        $phone = $row['phone'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $dob = $row['dob'];
        $country = $row['country'];
        $occupation = $row['occupation'];
        $gender = $row['gender'];
        $marital_status = $row['marital_status'];
        $account_type = $row['account_type'];
        $currency = $row['currency'];
        $profile_pic = $row['profile_pic'];
        $address = $row['address'];
        $password = $row['password'];
    }
}

$get_transaction_details = $conn->query("SELECT * FROM investment WHERE investment.user_id = '{$user_id}'");
if ($get_transaction_details->num_rows > 0) {
    while ($transaction_row = $get_transaction_details->fetch_assoc()) {
        $balance = $transaction_row['total_balance'];
        $deposit_balance = $transaction_row['deposit_balance'];
        $withdraw_balance = $transaction_row['withdrawal'];
        $transferred = $transaction_row['transfer'];
    }
}

// $get_transfer_history = $conn->query("SELECT * FROM `trransfer` WHERE userid = '{$user_id}'");
// if($get_transfer_history->num_rows > 0) {
//     while($transfer_row = $get_transfer_history->fetch_assoc()) {
//         $transfer_amount = $transfer_row['amount'];
//         $transfer_account_number = $transfer_row['accountnumber'];
//         $transfer_recipient_name = $transfer_row['recipientname'];
//         $transfer_bankname = $transfer_row['bankname'];
//         $transfer_accountype = $transfer_row['accountype'];
//         $transfer_recipientcountry = $transfer_row['recipientcountry'];
//         $transfer_swiftcode = $transfer_row['swiftcode'];
//         $transfer_remarks = $transfer_row['remarks'];
//         $transfer_reference = $transfer_row['reference'];
//         $transfer_datetime = $transfer_row['datetime'];
//         $transfer_status = $transfer_row['status'];
//     }
// }

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
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/style.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/utility.css">
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/admin/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "dashboard";
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
                <!-- ========== title-wrapper end ========== -->
                <div class="row">
                    <div class="col-xl-8 col-lg-4 col-sm-6">
                        <div class="icon-card mb-30">
                            <div class="icon purple">
                                <i class="lni lni-wallet"></i>
                            </div>
                            <div class="content">
                                <h6 class="mb-10">Balance</h6>
                                <h3 class="text-bold mb-10">$<?= $balance ?></h3>
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
                                <h6 class="mb-10">Deposited</h6>
                                <h3 class="text-bold mb-10">$<?= $balance //$deposit_balance  ?></h3>
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
                                <h6 class="mb-10">Withdrawn</h6>
                                <h3 class="text-bold mb-10">$<?= $withdraw_balance ?></h3>
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
                                <h6 class="mb-10">Total Transferred</h6>
                                <h3 class="text-bold mb-10">$<?= $transferred ?></h3>
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
                                <h6 class="mb-10">Beneficiaries</h6>
                                <h3 class="text-bold mb-10">0</h3>
                            </div>
                        </div>
                        <!-- End Icon Cart -->
                    </div>
                    <!-- End Col -->
                </div>
                <!-- End Row -->

                <div class="col-12">
                    <div class="d-flex flex-wrap gap-3">
                        <div class="flex-fill">
                            <button data-bs-toggle="modal" data-bs-target="#add_balance" class="btn btn--success btn--shadow w-100 btn-lg bal-btn tooltips">
                                <i class="fa-solid fa-circle-plus"></i> Balance
                                <span class="tooltiptext">Add Balance</span>
                            </button>
                        </div>

                        <div class="flex-fill">
                            <button data-bs-toggle="modal" data-bs-target="#remove_balance" class="btn btn--danger btn--shadow w-100 btn-lg bal-btn tooltips" data-act="sub">
                                <i class="fa-solid fa-circle-minus"></i> Balance
                                <span class="tooltiptext">Remove Balance</span>
                            </button>
                        </div>

                        <div class="flex-fill">
                            <a href="#" target="_blank" class="btn btn--primary btn--gradi btn--shadow w-100 btn-lg">
                                <i class="fa-solid fa-arrow-right-to-bracket"></i> Login as User
                            </a>
                        </div>

                        <!-- <div class="flex-fill">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal">
                                <i class="fa-solid fa-eye"></i> See account/card details
                            </button>
                        </div> -->

                        <div class="flex-fill">
                            <button type="button" data-bs-toggle="modal" data-bs-target="#transferPin" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal">
                                <i class="fa-solid fa-eye"></i> Set transfer pin
                            </button>
                        </div>

                        <div class="flex-fill">
                            <button type="button" id="ban_user" class="btn btn--danger btn--gradi btn--shadow w-100 btn-lg userStatus">
                                <i class="fa-solid fa-ban"></i> Ban User
                            </button>
                            <form action="" method="post" class="d-none" id="ban_user_form">
                                <input type="hidden" name="user_id" id="ban_user_id" value="<?= $user_id ?>">
                            </form>
                        </div>

                        <div class="flex-fill">
                            <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#createbillingcode">
                                <i class="fa-solid fa-money-bills"></i> Create Billing Code
                            </button>
                        </div>

                        <div class="flex-fill">
                            <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#transaction">
                                <i class="fa-solid fa-money-bill-transfer"></i> Create Transaction history
                            </button>
                        </div>

                        <div class="flex-fill">
                            <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#createwithdrawal">
                                <i class="fa-solid fa-money-bill-transfer"></i> Create Withdraw history
                            </button>
                        </div>

                        <div class="flex-fill">
                            <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#updatebillingcode">
                                <i class="fa-solid fa-money-bills"></i> Update Billing Code
                            </button>
                        </div>

                        <div class="flex-fill">
                            <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#updatetransactionhistory">
                                <i class="fa-solid fa-money-bill-transfer"></i> Update Transaction history
                            </button>
                        </div>


                        <div class="flex-fill">
                            <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#updatewithdrawhistory">
                                <i class="fa-solid fa-money-bill-transfer"></i> Update Withdraw history
                            </button>
                        </div>

                        <div class="flex-fill">
                            <button type="button" class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#ransferhistory">
                                <i class="fa-solid fa-money-bill-transfer"></i> Transfer history
                            </button>
                        </div>
                    </div>

                    <div class="modals">
                        <!-- add transfer pin Modal -->
                        <div class="modal fade" id="transferPin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Transfer Pin</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" id="add_pin_form" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="addAmount" class="form-label">Transfer Pin<span style="color: red">*</span></label>
                                                <input type="number" name="transfer_pin" class="form-control" id="addAmount">
                                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                            </div>
                                            <!-- <div class="mb-3">
                                                            <label for="addAmountRemark" class="form-label">Remarks<span style="color: red">*</span></label>
                                                            <textarea name="" class="form-control" id="addAmountRemark" rows="5"></textarea>
                                                        </div> -->
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                            <button type="submit" id="add_pin_btn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- add balance Modal -->
                        <div class="modal fade" id="add_balance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Balance</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" id="add_balance_form" method="post">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="addAmount" class="form-label">Amount<span style="color: red">*</span></label>
                                                <input type="number" name="addBalance" class="form-control" id="addAmount">
                                                <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                            </div>
                                            <!-- <div class="mb-3">
                                                            <label for="addAmountRemark" class="form-label">Remarks<span style="color: red">*</span></label>
                                                            <textarea name="" class="form-control" id="addAmountRemark" rows="5"></textarea>
                                                        </div> -->
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                            <button type="submit" id="add_balance_btn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- remove balance Modal -->
                        <div class="modal fade" id="remove_balance" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Remove Balance</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post" id="remove_amount_form">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="removeAmount" class="form-label">Amount<span style="color: red">*</span></label>
                                                <input type="number" class="form-control" name="remove_balance" id="removeAmount">
                                                <input type="hidden" name="userId" value="<?= $user_id ?>">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                            <button type="submit" id="remove_amount_btn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- create billing code balance Modal -->
                        <div class="modal fade" id="createbillingcode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="createtransferbillingcode" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="createtransferbillingcode">Create Transfer Billing Code for <span class="text-primary"><?= $first_name ?> <?= $last_name ?></span> Account</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" id="createBillingCodeForm" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                            <div class="mb-3">
                                                <label for="firstcodename" class="form-label">First Code Name<span style="color: red">*</span></label>
                                                <input type="text" name="firstcodename" class="form-control" id="firstcodename">
                                            </div>
                                            <div class="mb-3">
                                                <label for="firstcodenumber" class="form-label">First Code Number <span style="color: red">*</span></label>
                                                <input type="text" name="firstcodenumber" class="form-control" id="firstcodenumber">
                                            </div>
                                            <div class="mb-3">
                                                <label for="secondcodename" class="form-label">Second Code Name <span style="color: red">*</span></label>
                                                <input type="text" name="secondcodename" class="form-control" id="secondcodename">
                                            </div>
                                            <div class="mb-3">
                                                <label for="secondcodenumber" class="form-label">Second Code Number<span style="color: red">*</span></label>
                                                <input type="text" name="secondcodenumber" class="form-control" id="secondcodenumber">
                                            </div>
                                            <div class="mb-3">
                                                <label for="thirdcodename" class="form-label">Third Code Name<span style="color: red">*</span></label>
                                                <input type="text" name="thirdcodename" class="form-control" id="thirdcodename">
                                            </div>
                                            <div class="mb-3">
                                                <label for="thirdcodenumber" class="form-label">Third Code Number<span style="color: red">*</span></label>
                                                <input type="text" name="thirdcodenumber" class="form-control" id="thirdcodenumber">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                            <button type="submit" id="createBillingCodeBtn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- create transaction Modal -->
                        <div class="modal fade" id="transaction" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Create Transaction History for <span class="text-primary"><?= $first_name ?> <?= $last_name ?></span> Account</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" id="createTransactionHistoryForm" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                            <div class="mb-3">
                                                <label for="transaction_date" class="form-label">Date<span style="color: red">*</span></label>
                                                <input type="date" class="form-control" name="transaction_date" id="transaction_date">
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction_time" class="form-label">Time<span style="color: red">*</span></label>
                                                <input type="time" class="form-control" name="transaction_time" id="transaction_time">
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction_description" class="form-label">Description<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="transaction_description" id="transaction_description">
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction_status" class="form-label">Staus<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="transaction_status" id="transaction_status">
                                            </div>
                                            <div class="mb-3">
                                                <label for="transaction_amount" class="form-label">Amount<span style="color: red">*</span></label>
                                                <input type="number" class="form-control" name="transaction_amount" id="transaction_amount">
                                            </div>
                                            <div class="mb-3">
                                                <label for="bank_name" class="form-label">Bank Name<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="bank_name" id="bank_name">
                                            </div>
                                            <div class="mb-3">
                                                <label for="account_name" class="form-label">Account Name<span style="color: red">*</span></label>
                                                <input type="text" class="form-control" name="account_name" id="account_name">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                            <button type="submit" class="btn btn-primary" id="createTransactionHistoryBtn">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- create withdrawal balance Modal -->
                        <div class="modal fade" id="createwithdrawal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Update Withdrawal History for <span class="text-primary"><?= $first_name ?> <?= $last_name ?></span> Account</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="" method="post" id="create_withdraw_history_form">
                                        <div class="modal-body">
                                            <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                            <div class="mb-3">
                                                <label for="withdrawAmount" class="form-label">Amount<span style="color: red">*</span></label>
                                                <input type="number" name="withdrawAmount" placeholder="E.g 50000" class="form-control" id="withdrawAmount">
                                            </div>
                                            <div class="mb-3">
                                                <label for="accountnumber" class="form-label">Account Number<span style="color: red">*</span></label>
                                                <input type="number" name="accountnumber" placeholder="E.g 2147483647" class="form-control" id="accountnumber">
                                            </div>
                                            <div class="mb-3">
                                                <label for="recepientname" class="form-label">Recepient Name<span style="color: red">*</span></label>
                                                <input type="text" name="recepientname" placeholder="E.g Elon Musk" class="form-control" id="recepientname">
                                            </div>
                                            <div class="mb-3">
                                                <label for="bankname" class="form-label">Bank name<span style="color: red">*</span></label>
                                                <input type="text" name="bankname" placeholder="Enter bank name" class="form-control" id="bankname">
                                            </div>
                                            <div class="mb-3">
                                                <label for="accounttype" class="form-label">Account type<span style="color: red">*</span></label>
                                                <input type="text" name="accounttype" placeholder="E.g Savings, Checkings, Current" class="form-control" id="accounttype">
                                            </div>
                                            <div class="mb-3">
                                                <label for="country" class="form-label">Country<span style="color: red">*</span></label>
                                                <input type="text" name="country" placeholder="Enter country" class="form-control" id="countries">
                                            </div>
                                            <div class="mb-3">
                                                <label for="scode" class="form-label">S code<span style="color: red">*</span></label>
                                                <input type="number" name="scode" placeholder="E.g BOA455" class="form-control" id="scode">
                                            </div>
                                            <div class="mb-3">
                                                <label for="purpose" class="form-label">Purpose</label>
                                                <input type="text" name="purpose" class="form-control" id="purpose">
                                            </div>
                                            <div class="mb-3">
                                                <label for="withdrawalstatus" class="form-label">Withdrawal Status<span style="color: red">*</span></label>
                                                <input type="text" name="withdrawalstatus" placeholder="E.g pending, success, declined" class="form-control" id="withdrawalstatus">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                            <button type="submit" id="create_withdraw_history_btn" class="btn btn-primary">Submit</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- update billing code balance Modal -->
                        <div class="modal fade" id="updatebillingcode" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
                            <div class="modal-dialog min-w-1000px w-sm-100">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">List of Billing Codes</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body table-responsive">
                                        <table class="table table-hover">
                                            <tr class="thead">
                                                <th>S/N</th>
                                                <th>First Code Name</th>
                                                <th>First Code Number</th>
                                                <th>Second Code Name </th>
                                                <th>Second Code Number</th>
                                                <th>Third Code Name</th>
                                                <th>Third Code Number</th>
                                                <th>Action</th>
                                            </tr>
                                            <form action="" method="POST" id="updateTransferCodesForm">
                                                <?php
                                                $count = 0;
                                                $getTransferCodes = $conn->query("SELECT * FROM transfercodes WHERE user_id = '{$user_id}'");
                                                if ($getTransferCodes->num_rows > 0) {
                                                    while ($transferCodesRow = $getTransferCodes->fetch_assoc()) {
                                                ?>
                                                        <tr id="" ondblclick="this.style.border='2px solid lightgrey'" ;>
                                                            <th><?= ++$count ?></th>
                                                            <input type="hidden" value="<?= $transferCodesRow['user_id'] ?>" name="user_id">
                                                            <input type="hidden" value="<?= $transferCodesRow['id'] ?>" name="transferCodeId">
                                                            <td>
                                                                <input class="form-control w-fit-content" required type="text" name="firstcodename" value="<?= $transferCodesRow['first_code_name'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="number" name="firstcodenumber" value="<?= $transferCodesRow['first_code_number'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="secondcodename" value="<?= $transferCodesRow['second_code_name'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="number" name="secondcodenumber" value="<?= $transferCodesRow['second_code_number'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="thirdcodename" value="<?= $transferCodesRow['third_code_name'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="number" name="thirdcodenumber" value="<?= $transferCodesRow['third_code_number'] ?>">
                                                            </td>
                                                            <td class="d-flex gap-5px">
                                                                <button type="submit" name="add" id="updateTransferCodesBtn" class="btn btn-primary">Update</button>
                                                                <a href="#" type="submit" id="deleteTransferCodes" name="delete" class="btn btn-danger">Delete</a>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- update transaction history balance Modal -->
                        <div class="modal fade" id="updatetransactionhistory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog min-w-1000px w-sm-100">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Update Transaction History for <span class="text-primary"><?= $first_name ?> <?= $last_name ?></span> Account</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body table-responsive">
                                        <table class="table table-hover">
                                            <tr class="thead">
                                                <th>S/N</th>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Amount</th>
                                                <th>Bank Name</th>
                                                <th>Account Name</th>
                                                <th>Action</th>
                                            </tr>
                                            <form action="" method="POST" id="updateTransactionHistoryForm">
                                                <?php
                                                $countToo = 0;
                                                $getTransactionHistory = $conn->query("SELECT * FROM transaction_history WHERE user_id = '{$user_id}'");
                                                if ($getTransactionHistory->num_rows > 0) {
                                                    while ($transactionRow = $getTransactionHistory->fetch_assoc()) {
                                                        $transaction_status = $transactionRow['transaction_status'];
                                                ?>
                                                        <tr id="" ondblclick="this.style.border='2px solid lightgrey'" ;>
                                                            <th><?= ++$countToo ?></th>
                                                            <input type="hidden" value="<?= $transactionRow['user_id'] ?>" name="user_id">
                                                            <input type="hidden" value="<?= $transactionRow['id'] ?>" name="transaction_id">
                                                            <td>
                                                                <input class="form-control " required type="date" name="transaction_date" value="<?= $transactionRow['transaction_date'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" required="" type="time" name="transaction_time" value="<?= $transactionRow['transaction_time'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="transaction_description" value="<?= $transactionRow['transaction_description'] ?>">
                                                            </td>
                                                            <td>
                                                                <select name="transaction_status" id="transactionStatus" class="form-control w-fit-content">
                                                                    <option value="success">Successful</option>
                                                                    <option value="Pending">Pending</option>
                                                                    <option value="Failed">Failed</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="number" name="transaction_amount" value="<?= $transactionRow['transaction_amount'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="bank_name" value="<?= $transactionRow['bank_name'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="account_name" value="<?= $transactionRow['account_name'] ?>">
                                                            </td>
                                                            <td class="d-flex gap-5px">
                                                                <button type="submit" name="add" class="btn btn-primary updateTransactionHistoryBtn">Update</button>
                                                                <button href="" type="submit" class="btn btn-danger deleteTransactionHistory">Delete</button>
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- update withdraw history balance Modal -->
                        <div class="modal fade" id="updatewithdrawhistory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog min-w-1000px w-sm-100">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Update Withdrawal History for <span class="text-primary"><?= $first_name ?> <?= $last_name ?></span> Account</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body table-responsive">
                                        <table class="table table-hover">
                                            <tr class="thead">
                                                <th>S/N</th>
                                                <th>Amount</th>
                                                <th>Account Number</th>
                                                <th>Recepient Name</th>
                                                <th>Bank Name</th>
                                                <th>Account type</th>
                                                <th>Country</th>
                                                <th>S code</th>
                                                <th>Purpose</th>
                                                <th>Withdrawal Status</th>
                                                <th>Action</th>
                                            </tr>
                                            <form action="" method="POST" id="update_withdraw_form">
                                                <?php
                                                $countTooo = 0;
                                                $getWithdrawHistory = $conn->query("SELECT * FROM withdraw WHERE user_id = '{$user_id}'");
                                                if ($getWithdrawHistory->num_rows > 0) {
                                                    while ($withdrawRow = $getWithdrawHistory->fetch_assoc()) {
                                                ?>
                                                        <tr id="" ondblclick="this.style.border='2px solid lightgrey'" ;>
                                                            <th><?= ++$countTooo ?></th>
                                                            <input type="hidden" value="<?= $withdrawRow['user_id'] ?>" name="user_id">
                                                            <input type="hidden" value="<?= $withdrawRow['id'] ?>" name="withdrawId">
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="number" name="withdrawAmount" value="<?= $withdrawRow['withdraw_amount'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required type="number" name="accountnumber" value="<?= $withdrawRow['account_number'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="recepientname" value="<?= $withdrawRow['recepientname'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="bankname" value="<?= $withdrawRow['bankname'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="accounttype" value="<?= $withdrawRow['accounttype'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="country" value="<?= $withdrawRow['country'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="scode" value="<?= $withdrawRow['scode'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="purpose" value="<?= $withdrawRow['purpose'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" required="" type="text" name="withdrawalstatus" value="<?= $withdrawRow['withdrawalstatus'] ?>">
                                                            </td>
                                                            <td class="d-flex gap-5px">
                                                                <button type="submit" name="add" class="btn btn-primary update_withdraw_btn">Update</button>
                                                                <!-- <a href="" type="submit" name="delete" class="btn btn-danger delete_withdraw_btn">Delete</a> -->
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- update transfer history Modal -->
                        <div class="modal fade" id="ransferhistory" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog min-w-1000px w-sm-100">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title fs-5" id="exampleModalLabel">Update Transfer History for <span class="text-primary"><?= $first_name ?> <?= $last_name ?></span> Account</h3>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body table-responsive">
                                        <table class="table table-hover">
                                            <tr class="thead">
                                                <th>S/N</th>
                                                <th>Amount</th>
                                                <th>Account Number</th>
                                                <th>Recepient Name</th>
                                                <th>Bank Name</th>
                                                <th>Account type</th>
                                                <th>Country</th>
                                                <th>S code</th>
                                                <th>Purpose</th>
                                                <th>Transfer Status</th>
                                                <th>Action</th>
                                            </tr>
                                            <form action="" method="POST" id="update_transfer_form">
                                                <?php
                                                $countTooo = 0;
                                                $get_transfer_history = $conn->query("SELECT * FROM `trransfer` WHERE userid = '{$user_id}'");
                                                if($get_transfer_history->num_rows > 0) {
                                                    while($transfer_row = $get_transfer_history->fetch_assoc()) {
                                                        if($transfer_row['status'] == 1){
                                                            $statuses = ["1" => "success", "0" => "pending", "-1" => "failed"];
                                                        }else if($transfer_row['status'] == 0){
                                                            $statuses = ["0" => "pending", "1" => "success", "-1" => "failed"];
                                                        }else{
                                                            $statuses = ["-1" => "failed", "1" => "success", "0" => "pending"];
                                                        }
                                                        
                                                ?>
                                                        <tr id="" ondblclick="this.style.border='2px solid lightgrey'" ;>
                                                            <th><?= ++$countTooo ?></th>
                                                            <input type="hidden" value="<?= $transfer_row['userid'] ?>" name="user_id">
                                                            <input type="hidden" value="<?= $transfer_row['id'] ?>" name="withdrawId">
                                                            <td>
                                                                <input class="form-control w-fit-content" type="number" name="withdrawAmount" value="<?= $transfer_row['amount'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" type="number" name="accountnumber" value="<?= $transfer_row['accountnumber'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" type="text" name="recepientname" value="<?= $transfer_row['recipientname'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" type="text" name="bankname" value="<?= $transfer_row['bankname'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" type="text" name="accounttype" value="<?= $transfer_row['accountype'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" type="text" name="country" value="<?= $transfer_row['recipientcountry'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" type="text" name="scode" value="<?= $transfer_row['swiftcode'] ?>">
                                                            </td>
                                                            <td>
                                                                <input class="form-control w-fit-content" type="text" name="purpose" value="<?= $transfer_row['remarks'] ?>">
                                                            </td>
                                                            <td>
                                                                <select name="status" class="form-select w-fit-content">
                                                                    <?php
                                                                        foreach($statuses as $key => $status){
                                                                    ?>
                                                                    <option value="<?= $key ?>"><?= $status?></option>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                <!-- <input class="form-control w-fit-content" required="" type="text" name="withdrawalstatus" value="<?= $status ?>"> -->
                                                            </td>
                                                            <td class="d-flex gap-5px">
                                                                <button type="submit" name="add" class="btn btn-primary update_transfer_btn">Update</button>
                                                                <!-- <a href="" type="submit" name="delete" class="btn btn-danger delete_withdraw_btn">Delete</a> -->
                                                            </td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </form>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- account/card details -->
                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Account</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Card</button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="pills-tabContent">
                                            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0 mb-3">
                                                    <small class="text-muted">Bank Name</small>
                                                    <h6 style="font-size: .8rem;">Chase Bank </h6>
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0 mb-3">
                                                    <small class="text-muted">Account Name</small>
                                                    <h6 style="font-size: .8rem;">Mama's account </h6>
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                                    <small class="text-muted">Account Number</small>
                                                    <h6 style="font-size: .8rem;">VB2319111073383 </h6>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0 mb-3">
                                                    <small class="text-muted">Card Name</small>
                                                    <h6 style="font-size: .8rem;">1234567890123</h6>
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0 mb-3">
                                                    <small class="text-muted">Expiry Date</small>
                                                    <h6 style="font-size: .8rem;">26/12</h6>
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                                    <small class="text-muted">Cvv</small>
                                                    <h6 style="font-size: .8rem;">111 </h6>
                                                </div>
                                                <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                                    <small class="text-muted">Pin</small>
                                                    <h6 style="font-size: .8rem;">1113 </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-4 gy-4">
                    <div class="col-xl-3 col-lg-5 col-md-5">
                        <div class="row">
                            <div class="col-6 col-sm-6 col-md-12">
                                <div class="card mb-4">
                                    <div class="card-body text-center">
                                        <img class="account-holder-image img-fluid rounded border w-100" src="<?= ROOT_URL ?>backend/account/profileImages/<?= $profile_pic ?>" alt="account-holder-image">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 col-sm-6 col-md-12">
                                <div class="card basic_info">
                                    <div class="card-header">
                                        <h5 class="card-title text-center">Basic Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="list-group list-group-flush">
                                            <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                                <small class="text-muted">Username</small>
                                                <h6><?= $username ?></h6>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                                <small class="text-muted">Email</small>
                                                <h6 style="font-size: .8rem;"><?= $email ?> </h6>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                                <small class="text-muted">Phone Number</small>
                                                <h6 style="font-size: .8rem;"><?= $phone ?> </h6>
                                            </div>

                                            <div class="list-group-item d-flex justify-content-between flex-column flex-wrap border-0">
                                                <small class="text-muted">Account Number</small>
                                                <h6 style="font-size: .8rem;"><?= $account_number ?> </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-9 col-lg-7 col-md-7">
                        <div class="card">
                            <div class="card-header d-flex flex-wrap justify-content-between">
                                <h5 class="card-title mb-0">Information of <?= $first_name ?> <?= $last_name ?></h5>
                                <span>
                                    <span class="badge badge--success">Active</span>
                                </span>
                            </div>
                            <div class="card-body">
                                <form action="#" id="updateUser" method="POST" enctype="multipart/form-data">
                                    <input type="hidden" name="user_id" value="<?= $user_id ?>">
                                    <div class="row">
                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="firstname" class="required">First Name</label>
                                                <input class="form-control" type="text" name="firstname" value="<?= $first_name ?>" required="" id="firstname">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group">
                                                <label class="form-control-label required" for="lastname">Last Name</label>
                                                <input class="form-control" type="text" name="lastname" value="<?= $last_name ?>" required="" id="lastname">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group">
                                                <label for="username">Username</label>
                                                <input class="form-control" type="text" name="username" id="username" value="<?= $username ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group">
                                                <label for="email" class="required">Email </label>
                                                <input class="form-control" value="<?= $email ?>" type="email" name="email" required="" id="email">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group">
                                                <label class="required">Mobile Number </label>
                                                <div class="input-group ">
                                                    <span class="input-group-text mobile-code"><i class="fa-solid fa-phone"></i></span>
                                                    <input type="number" name="phone" value="<?= $phone ?>" id="mobile" class="form-control checkUser" required="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="dob">Date of Birth</label>
                                                <input class="form-control" type="date" value="<?= $dob ?>" name="dob" id="dob">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="country">Country</label>
                                                <select name="country" id="country" class="form-control">
                                                    <option value="">Select a country</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="occupation">Occupation</label>
                                                <input class="form-control" type="text" value="<?= $occupation ?>" name="occupation" id="occupation">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group flex-column">
                                                <label for="gender" class="d-block">Gender</label>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input genderRoles" type="radio" name="gender" id="male" value="male">
                                                    <label class="form-check-label" for="male">Male</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input genderRoles" type="radio" name="gender" id="female" value="female">
                                                    <label class="form-check-label" for="female">Female</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input genderRoles" type="radio" name="gender" id="other" value="other">
                                                    <label class="form-check-label" for="other">Other</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="marital_status">Marital Status</label>
                                                <input class="form-control" type="text" name="marital_status" id="marital_status" value="<?= $marital_status ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="account_type">Account Type</label>
                                                <input class="form-control" type="text" name="account_type" id="account_type" value="<?= $account_type ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="password">Password</label>
                                                <input class="form-control" type="password" name="password" id="password" value="<?= $password ?>">
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="currency">Currency</label>
                                                <select name="currency" class="form-control" id="currency">
                                                    <option value="$">Dollar</option>
                                                    <option value="€">Euro</option>
                                                    <option value="£">Pound</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-12 col-xl-6">
                                            <div class="form-group ">
                                                <label for="upload_pic">Upload Picture</label>
                                                <input class="form-control" type="file" name="upload_pic" value="<?= $profile_pic ?>" id="upload_pic">
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="address">Address</label>
                                                <input class="form-control" type="text" name="address" value="<?= $address ?>" id="address">
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" id="updatebtn" class="btn btn-primary w-100 h-45 mt-3">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.min.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/updateUser.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/addBalance.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/removeBalance.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/banUsers.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/addTransfercodes.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/updateTransferCode.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/create_transaction.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/updateTransaction.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/createWithdraw.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/updateWithdraw.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/updateTransfer.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/admin/addTransferPin.js"></script>
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

        function setCheckedByValue(text) {
            const radioInputs = document.querySelectorAll('input[type="radio"].genderRoles');

            radioInputs.forEach(radio => {
                if (radio.value === text) {
                    radio.checked = true;
                } else {
                    radio.checked = false; // Uncheck other radio buttons
                }
            });
        }


        setCheckedByValue("<?= $gender ?>");


        function selectOptionByText(selectElement, text) {
            const options = selectElement.options;

            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                // console.log(option);
                if (option.value.toLowerCase() === text.toLowerCase()) {
                    option.selected = true;
                    //break; // Exit the loop after finding a match
                }
            }
        }

        const selectElement = document.getElementById("currency");
        const textToMatch = "<?= $currency ?>";
        selectOptionByText(selectElement, textToMatch);

        const selectTransactionStatus = document.getElementById("transactionStatus");
        const statusToMatch = "<?= $transaction_status ?>";
        selectOptionByText(selectTransactionStatus, statusToMatch);

        const selectCountry = document.getElementById("country");
        const countryToMatch = "<?= $country ?>";
        selectOptionByText(selectCountry, countryToMatch);
    </script>
</body>

</html>