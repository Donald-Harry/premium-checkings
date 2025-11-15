<?php
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
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
                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="card-style special-box">
                            <div class="heading-area">
                                <h4 class="title">
                                    KYC Information
                                </h4>
                            </div>
                            <div class="table-responsive-sm">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th width="45%">full_name</th>
                                            <td width="10%">:</td>
                                            <td width="45%">Joshua segu</td>
                                        </tr>
                                        <tr>
                                            <th width="45%">nid</th>
                                            <td width="10%">:</td>
                                            <td width="45%">
                                                <a href="" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                                    <img src="<?= ROOT_URL ?>en/images/modal-img.png" class="img-thumbnail">
                                                </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <img src="<?= ROOT_URL ?>en/images/modal-img.png" class="img-thumbnail">
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th width="45%">present_address</th>
                                            <td width="10%">:</td>
                                            <td width="45%">Foster home</td>
                                        </tr>
                                        <tr>
                                            <th width="45%">parmanent_address</th>
                                            <td width="10%">:</td>
                                            <td width="45%">ghana</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="footer-area gap-20">
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#approveModal" data-href="https://product.geniusocean.com/genius-bank/admin/users/kyc/539/1" class="btn btn-primary"><i class="far fa-check-circle"></i> Approve</a>
                                <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#rejectModal" data-href="https://product.geniusocean.com/genius-bank/admin/users/kyc/539/2" class="btn btn-danger ml-3"><i class="fas fa-minus-circle"></i> Reject</a>
                            </div>
                            <div class="statusmodal">
                                <!-- Modal -->
                                <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p class="text-center">You are about to change the status.</p>
                                                <p class="text-center">Do you want to proceed?</p>
                                            </div>

                                            <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                                                <a href="#" class="btn btn-success btn-ok">Update</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Update Status</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>

                                            <div class="modal-body">
                                                <p class="text-center">You are about to change the status.</p>
                                                <p class="text-center">Do you want to proceed?</p>
                                            </div>

                                            <div class="modal-footer">
                                                <a href="javascript:;" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</a>
                                                <a href="#" class="btn btn-success btn-ok">Update</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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