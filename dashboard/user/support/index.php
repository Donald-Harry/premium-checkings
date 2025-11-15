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
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/datatable.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "tickets";
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
                <div class="tables-wrapper">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card-style mb-30">
                                <h3 class="text-center py-5 d-none">No Data Found</h3>
                                <div class="table-responsive ">
                                    <table id="table" class="table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Ticket</th>
                                                <th>Type</th>
                                                <th class="">Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $count = "0";
                                                $getTickets = $conn->query("SELECT * FROM tickets WHERE tickets.user_id = '{$userid}'");
                                                if($getTickets->num_rows > 0) {
                                                    while($row = $getTickets->fetch_assoc()){

                                                   
                                            ?>
                                            <tr>
                                                <td class="text-center"><?= ++$count ?></td>
                                                <?php
                                                    $type = $row['ticket_type'];
                                                    switch ($type){
                                                        case "my_account":
                                                            $type = "My Account";
                                                            break;
                                                        case "transfer":
                                                            $type = "Transfer";
                                                            break;
                                                        case "security":
                                                            $type = "Security";
                                                            break;
                                                    }
                                                ?>
                                                <td class="text-primary"><?= $type ?></td>
                                                <td><?= $row['ticket_type'] ?></td>
                                                <td class="">
                                                    <?php
                                                        $status = $row['status'];
                                                        if($status == "pending"){
                                                    ?>
                                                    <span class="shadow-none badge outline-badge-secondary">Processing</span>
                                                    <?php
                                                        }else if($status == "complete"){                                                        
                                                    ?>
                                                    <span class="shadow-none badge outline-badge-info">Completed</span>
                                                    <?php
                                                        }else if($status == "closed"){                                                        
                                                    ?>
                                                    <span class="shadow-none badge outline-badge-danger">Closed</span>
                                                    <?php
                                                        }
                                                    ?>
                                                </td>
                                                <td><?= $row['date'] ?></td>
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
    <script src="<?= ROOT_URL ?>dashboard/assets/js/datatable.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>
    <script>
        const dataTable = new simpleDatatables.DataTable("#table", {
            searchable: true,
        });
    </script>
</body>

</html>