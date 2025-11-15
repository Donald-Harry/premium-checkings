<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT."backend/config.php";
include_once WEB_ROOT . "_includes/companyDetails.php";

if(!isset($_SESSION['user_id'])){
    header("Location: ../../../../account");
    exit();
}

$userid = $_SESSION['user_id'];


$user_id = $amount = $accountnumber = $recipientname = $recipientcountry = $bankname = $accountype = $swiftcode = $remarks = ""; 

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $user_id = $_POST['user_id'];
    $amount = mysqli_real_escape_string($conn, $_POST["amount"]);
    $accountnumber = mysqli_real_escape_string($conn, $_POST["accountnumber"]);
    $recipientname = mysqli_real_escape_string($conn, $_POST["recipientname"]);
    $bankname = mysqli_real_escape_string($conn, $_POST["bankname"]);
    $accountype = mysqli_real_escape_string($conn, $_POST["accountype"]);
    $recipientcountry = mysqli_real_escape_string($conn, $_POST["recipientcountry"]);
    $swiftcode = mysqli_real_escape_string($conn, $_POST["swiftcode"]);
    $remarks = mysqli_real_escape_string($conn, $_POST["remarks"]);
    $code_2 = mysqli_real_escape_string($conn, $_POST["code_2"]);

}

if (empty($user_id) && empty($amount)){
    header("Location: ../index.php");
}

$get_code = $conn->query("SELECT * FROM transfercodes WHERE user_id = '{$user_id}'");
if ($get_code->num_rows > 0) {
    while ($row = $get_code->fetch_assoc()){
        $code_name = $row['third_code_name'];
        $code_number = $row['second_code_number'];
        $code_3 = $row['third_code_number'];
    }
}

if($code_2 != $code_number){
    echo "<script>alert('You have entered the wrong code');window.history.back();</script>";
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
                                            <input class="form-control" name="code_2" id="codeId" placeholder="*****" type="text" required="">
                                        </div>
                                    </div>
                                    <!-- end col -->
                                    <div class="col-12">
                                        <div class="button-group d-flex justify-content-center flex-wrap">
                                            <button type="submit" class="main-btn waves-effect primary-btn btn-hover m-2">
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
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.min.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>

    <script>
        const form = document.querySelector('#transfer_form'),
        continueBtn = form.querySelector('.waves-effect'),
        codeId = form.querySelector('#codeId');

        form.onsubmit = (e) =>{
            e.preventDefault();
        }

        continueBtn.onclick = () =>{
            if(codeId.value == <?= $code_3 ?>){
                let xhr = new XMLHttpRequest();
                xhr.open('POST', "<?= ROOT_URL ?>backend/transfer/transfer.php", true);
                xhr.onload = () =>{
                    if(xhr.readyState === XMLHttpRequest.DONE){
                        if(xhr.status === 200){
                            // let data = xhr.response;
                            var response = JSON.parse(xhr.responseText);
                            var status = response.status;
                            var reference = response.reference;
                            var error = response.error;
                            console.log(status); 
                            if(status == 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pending',
                                    // text: data,
                                    text: 'Wire Transfer processing',
                                    // footer: '<a href="<?= ROOT_URL ?>vendor/bank.php">Why do I have this issue?</a>',
                                    closeOnClickOutside: false
                                }).then((result) => {
                                    window.location.href = "<?= ROOT_URL ?>dashboard/user/transfer/receipt.php?transaction=" + reference;
                                });
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    // text: data,
                                    text: data,
                                    // footer: '<a href="<?= ROOT_URL ?>vendor/bank.php">Why do I have this issue?</a>',
                                })
                            }
                        }
                    }
                }
                let formdata = new FormData(form);
                xhr.send(formdata);
            }else{
                iziToast.show({
                    title: 'Hey',
                    message: 'You entered the wrong code',
                    position: "topRight",
                    backgroundColor: '#FF474C'
                });
            }
        }
    </script>
</body>

</html>