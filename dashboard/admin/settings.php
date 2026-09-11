<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
include_once WEB_ROOT . "backend/config.php";

if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: index.php");
    exit();
}

$admin_id = $_SESSION['user_id'] ?? 1;
$get_admin = $conn->query("SELECT * FROM admin WHERE id = '{$admin_id}'");
$admin_row = $get_admin ? $get_admin->fetch_assoc() : null;
$admin_email = $admin_row['email'] ?? 'admin@gmail.com';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">
    <title><?= $companyName ?> || Change Admin Password</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/lineicons.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/all.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .settings-card {
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.04);
            border: 1px solid #edf2f9;
        }

        .password-toggle-btn {
            background: #f8fafc;
            border-color: #d1d5db;
            color: #6b7280;
        }

        .password-toggle-btn:hover {
            background: #e2e8f0;
            color: #1f2937;
        }

        .info-callout {
            background-color: #f0f7ff;
            border-left: 4px solid #3b82f6;
            padding: 14px 18px;
            border-radius: 6px;
        }

        .locked-field-badge {
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 4px;
            background-color: #fee2e2;
            color: #dc2626;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/admin/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "settings"; include WEB_ROOT . "dashboard/admin/_includes/sidebar.inc.php" ?>
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
                            <div class="title mb-30">
                                <h2>Security & Password</h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper mb-30">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= ROOT_URL ?>dashboard/admin/dashboard.php">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Change Password
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========== title-wrapper end ========== -->

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-xl-7">
                        <div class="settings-card p-4 p-md-5 mb-30">
                            <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                                <div class="me-3 p-3 bg-primary bg-opacity-10 text-primary rounded-circle">
                                    <i class="fa-solid fa-shield-halved fa-2x"></i>
                                </div>
                                <div>
                                    <h4 class="fw-bold mb-1">Administrator Password Settings</h4>
                                    <p class="text-muted small mb-0">Manage and update your administrator credentials</p>
                                </div>
                            </div>

                            <div class="info-callout mb-4">
                                <div class="d-flex align-items-start">
                                    <i class="fa-solid fa-circle-info text-primary mt-1 me-2"></i>
                                    <div class="small text-secondary">
                                        <strong>Email Policy Notice:</strong> For security and audit compliance, your administrator email (<strong><?= htmlspecialchars($admin_email) ?></strong>) is permanently assigned and cannot be modified. You may change your account password below.
                                    </div>
                                </div>
                            </div>

                            <form id="adminPasswordForm">
                                <!-- Read-only Email Field -->
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <label class="form-label fw-semibold mb-0">Admin Email Address</label>
                                        <span class="locked-field-badge">
                                            <i class="fa-solid fa-lock me-1"></i> Cannot be changed
                                        </span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0">
                                            <i class="fa-solid fa-envelope"></i>
                                        </span>
                                        <input type="email" class="form-control bg-light text-muted border-start-0" value="<?= htmlspecialchars($admin_email) ?>" readonly disabled aria-label="Administrator Email (read-only)">
                                        <span class="input-group-text bg-light text-danger border-start-0" title="Email is locked">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                    </div>
                                    <div class="form-text text-muted small mt-1">
                                        Admin email address is fixed and cannot be changed.
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h6 class="fw-bold mb-3">Change Administrator Password</h6>

                                <!-- Current Password -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0">
                                            <i class="fa-solid fa-key"></i>
                                        </span>
                                        <input type="password" class="form-control border-start-0" name="current_password" id="current_password" placeholder="Enter current password" required>
                                        <button class="btn password-toggle-btn border-start-0" type="button" onclick="togglePasswordVisibility('current_password', this)" title="Toggle visibility">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- New Password -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0">
                                            <i class="fa-solid fa-lock"></i>
                                        </span>
                                        <input type="password" class="form-control border-start-0" name="new_password" id="new_password" placeholder="Enter new password (min. 6 characters)" required minlength="6">
                                        <button class="btn password-toggle-btn border-start-0" type="button" onclick="togglePasswordVisibility('new_password', this)" title="Toggle visibility">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                    <div class="form-text text-muted small">Must be at least 6 characters long.</div>
                                </div>

                                <!-- Confirm New Password -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0">
                                            <i class="fa-solid fa-check-double"></i>
                                        </span>
                                        <input type="password" class="form-control border-start-0" name="confirm_password" id="confirm_password" placeholder="Re-enter new password" required minlength="6">
                                        <button class="btn password-toggle-btn border-start-0" type="button" onclick="togglePasswordVisibility('confirm_password', this)" title="Toggle visibility">
                                            <i class="fa-solid fa-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end gap-2 pt-2">
                                    <button type="submit" id="savePasswordBtn" class="main-btn primary-btn btn-hover px-4 py-2">
                                        <i class="fa-solid fa-save me-2"></i> Update Password
                                    </button>
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
        <?php include WEB_ROOT . "dashboard/admin/_includes/footer.inc.php" ?>
        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="<?= ROOT_URL ?>dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>

    <script>
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        document.getElementById('adminPasswordForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const currentPassword = document.getElementById('current_password').value.trim();
            const newPassword = document.getElementById('new_password').value.trim();
            const confirmPassword = document.getElementById('confirm_password').value.trim();
            const submitBtn = document.getElementById('savePasswordBtn');

            if (!currentPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Current Password Required',
                    text: 'Please enter your current password.',
                    confirmButtonColor: '#2f80ed'
                });
                return;
            }

            if (!newPassword || newPassword.length < 6) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid New Password',
                    text: 'New password must be at least 6 characters long.',
                    confirmButtonColor: '#2f80ed'
                });
                return;
            }

            if (newPassword !== confirmPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Passwords Do Not Match',
                    text: 'New password and confirm password do not match.',
                    confirmButtonColor: '#2f80ed'
                });
                return;
            }

            if (currentPassword === newPassword) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Same Password',
                    text: 'New password cannot be identical to your current password.',
                    confirmButtonColor: '#2f80ed'
                });
                return;
            }

            // Disable submit button during processing
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Updating...';

            const formData = new FormData();
            formData.append('current_password', currentPassword);
            formData.append('new_password', newPassword);
            formData.append('confirm_password', confirmPassword);

            fetch('<?= ROOT_URL ?>backend/account/admin_change_password.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(data => {
                const response = data.trim();
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-save me-2"></i> Update Password';

                if (response === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Updated!',
                        text: 'Your administrator password has been updated successfully.',
                        confirmButtonColor: '#2f80ed'
                    }).then(() => {
                        document.getElementById('adminPasswordForm').reset();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        text: response || 'An unexpected error occurred. Please try again.',
                        confirmButtonColor: '#2f80ed'
                    });
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fa-solid fa-save me-2"></i> Update Password';
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Network Error',
                    text: 'Unable to connect to server. Please try again later.',
                    confirmButtonColor: '#2f80ed'
                });
            });
        });
    </script>
</body>

</html>
