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
        .unclickable {
            background-color: grey;
            cursor: not-allowed;
        }
    </style>
    <script>
        function checkForm() {
            const form = document.getElementById('transfer_form');
            const inputs = form.getElementsByTagName('input');
            let isFormFilled = true;

            for (let i = 0; i < inputs.length; i++) {
                if (inputs[i].hasAttribute('required') && inputs[i].value === '') {
                    isFormFilled = false;
                    break;
                }
            }

            const submitButton = document.getElementById('submitBtn');
            if (isFormFilled) {
                submitButton.disabled = false;
                submitButton.classList.remove('unclickable');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('unclickable');
            }
        }
    </script>
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
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <!-- <?= ROOT_URL ?>dashboard/user/transfer/security/check_1.php -->
                            <form method="POST" action="" id="transfer_form" oninput="checkForm()" enctype="multipart/form-data">
                                <input type="hidden" name="user_id" value="<?= $userid ?>">
                                <input type="hidden" name="mail" value="<?= $email ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>From</label>
                                            <select class="form-control">
                                                <option value="aluya@gmail.com"><?= $user_row['first_name'] ?> - <?= $user_row['account_number'] ?> - [<?= $user_row['currency'] ?><?= $user_row['totalbal'] ?>]</option>
                                            </select>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Amount* (required)</label>
                                            <input class="form-control" name="amount" type="number" required="">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Account Number</label>
                                            <input class="form-control" name="accountnumber" type="number" required="">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Recipient's Name</label>
                                            <input class="form-control" name="recipientname" placeholder="Enter Full Name" type="text" required="">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="input-style-1">
                                            <label>Bank</label>
                                            <input class="form-control" name="bankname" placeholder="Enter Bank Name" type="text" required="">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-sm-6">
                                        <div class="select-style-1">
                                            <label>Account Type</label>
                                            <div class="select-position">
                                                <select class="form-control light-bg" name="accountype">
                                                    <option>Checkings</option>
                                                    <option>Savings</option>
                                                    <option>Current</option>
                                                </select>
                                            </div>
                                        </div>
                                        <!-- end select -->
                                    </div>
                                    <!-- end col -->
                                    <div class="col-sm-6">
                                        <div class="input-style-1">
                                            <label>IFSC/Swift Code</label>
                                            <input class="form-control" name="swiftcode" placeholder="Enter Swift Code" type="text" required="">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-sm-12">
                                        <div class="input-style-1">
                                            <label>Recipient's Country</label>
                                            <input class="form-control" name="recipientcountry" placeholder="Enter Recipient's Country" type="text" required="">
                                        </div>
                                    </div>
                                    <!-- end col -->

                                    <div class="col-sm-12">
                                        <div class="input-style-1">
                                            <label>Remarks</label>
                                            <textarea class="form-control" name="remarks"></textarea>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="form-check checkbox-style checkbox-success mb-30">
                                            <input class="form-check-input" data-error="You must agree to the terms to proceed" type="checkbox" required=""><label>I agree to terms and conditions</label>
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button type="button" id="submitBtn" data-bs-toggle="modal" data-bs-target="#staticBackdrop" class="waves-effect main-btn primary-btn btn-hover m-2 unclickable" disabled>
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

                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <!-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> -->
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="" id="add_pin_form" method="post">
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="addAmount" class="form-label">Transfer Pin<span style="color: red">*</span></label>
                                        <input type="number" name="transfer_pin" class="form-control" id="pin">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <!-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> -->
                                    <button type="button" id="add_pin_btn" class="btn btn-primary ">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
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
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.min.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>

    <script>
        const form = document.querySelector('#transfer_form'),
            continueBtn = document.querySelector('#add_pin_btn'),
            pinId = document.querySelector('#pin');

        form.onsubmit = (e) => {
            e.preventDefault();
        }

        continueBtn.onclick = () => {
            if (<?= $user_row['status'] ?> != -1) {
                if (pinId.value == <?= $user_row['pin'] ?>) {
                    let xhr = new XMLHttpRequest();
                    xhr.open('POST', "<?= ROOT_URL ?>backend/transfer/transfer.php", true);
                    xhr.onload = () => {
                        if (xhr.readyState === XMLHttpRequest.DONE) {
                            if (xhr.status === 200) {
                                // let data = xhr.response;
                                var response = JSON.parse(xhr.responseText);
                                var status = response.status;
                                var reference = response.reference;
                                var error = response.error;
                                console.log(status);
                                if (status == 'success') {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        // text: data,
                                        text: 'Wire Transfer processing',
                                        // footer: '<a href="<?= ROOT_URL ?>vendor/bank.php">Why do I have this issue?</a>',
                                        closeOnClickOutside: false
                                    }).then((result) => {
                                        window.location.href = "<?= ROOT_URL ?>dashboard/user/transfer/receipt.php?transaction=" + reference;
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        // text: data,
                                        text: error,
                                        // footer: '<a href="<?= ROOT_URL ?>vendor/bank.php">Why do I have this issue?</a>',
                                    })
                                }
                            }
                        }
                    }
                    let formdata = new FormData(form);
                    xhr.send(formdata);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        // text: data,
                        text: "Incorrect PIN",
                    })
                }
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    // text: data,
                    text: "You can't make a transfer",
                    // footer: '<a href="<?= ROOT_URL ?>vendor/bank.php">Why do I have this issue?</a>',
                });
            }
        }
    </script>
</body>

</html>