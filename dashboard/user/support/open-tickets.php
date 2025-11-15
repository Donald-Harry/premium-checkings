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
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "openTickets";
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
                                <h2>Tickets</h2>
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

                <!-- ========== ticket start ========== -->
                <div class="form-layout-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <form action="<?= ROOT_URL ?>backend/tickets/open_tickets.php" method="post">
                                    <input type="hidden" name="user_id" value="<?= $userid ?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="select-style-1">
                                                <label>Ticket Type</label>
                                                <div class="select-position">
                                                    <select class="light-bg" name="ticket_type">
                                                        <option value="not_selected">Select Ticket Type</option>
                                                        <option value="my_account">My Account</option>
                                                        <option value="transfer">Transfer</option>
                                                        <option value="security">Security</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- end select -->
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="input-style-1">
                                                <label>More Information</label>
                                                <textarea placeholder="Well detailed" name="message" rows="5" class="bg-transparent"></textarea>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                        <div class="col-12">
                                            <div class="button-group d-flex justify-content-center flex-wrap">
                                                <button class="main-btn primary-btn btn-hover m-2">
                                                    Open Tickets
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
                    <!-- end row -->
                </div>
                <!-- ========== tticket end ========== -->
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
    <?php
    if (isset($_SESSION['message']) && $_SESSION['message'] == "success") {
        // echo "<h5 id='session_message'>".$_SESSION['message']."</h5>";
        echo "<script>
                Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  // text: data,
                  text: 'You have successfully open a ticket',
                  // footer: '<a href='vendor/bank.php'>Why do I have this issue?</a>',
                    closeOnClickOutside: false
                })
              </script>";
        unset($_SESSION['message']);
    } else if (isset($_SESSION['message']) && $_SESSION['message'] != "failed") {
        $data = $_SESSION['message'];
        echo "<script>
              Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '$data',
                // text: 'Logged in not successfull',
                // footer: '<a href='vendor/bank.php'>Why do I have this issue?</a>',
              })
            </script>";
        unset($_SESSION['message']);
    }
    ?>
</body>

</html>