<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "_includes/companyDetails.php";
include_once WEB_ROOT . "_includes/countries.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../account");
    exit();
}

$userid = $_SESSION['user_id'];
$get_user_details = $conn->query("SELECT * FROM users WHERE users.id = '{$userid}'");
$user_row = $get_user_details->fetch_assoc();

$profile_pic = (!empty($user_row['profile_pic']) && file_exists(WEB_ROOT . "backend/account/profileImages/" . $user_row['profile_pic'])) 
    ? $user_row['profile_pic'] 
    : 'default.png';
$profile_pic_path = ROOT_URL . "backend/account/profileImages/" . $profile_pic;
$k_status = !empty($user_row['kyc_status']) ? $user_row['kyc_status'] : 'unverified';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">
    <title><?= $companyName ?> || My Profile</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/lineicons.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .profile-nav-tabs .nav-link {
            font-weight: 600;
            color: #5d657b;
            padding: 12px 24px;
            border: none;
            border-bottom: 3px solid transparent;
            border-radius: 0;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: transparent;
            font-size: 0.95rem;
        }

        .profile-nav-tabs .nav-link:hover {
            color: #2f80ed;
        }

        .profile-nav-tabs .nav-link.active {
            color: #2f80ed;
            border-bottom-color: #2f80ed;
            background: transparent;
        }

        .profile-avatar-wrapper {
            position: relative;
            display: inline-block;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.12);
        }

        .profile-avatar-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-edit-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 38px;
            background: rgba(0, 0, 0, 0.6);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s;
            font-size: 14px;
        }

        .avatar-edit-overlay:hover {
            background: rgba(47, 128, 237, 0.9);
        }

        .form-label {
            font-weight: 600;
            color: #262d3f;
            margin-bottom: 6px;
            font-size: 0.9rem;
        }

        .password-toggle-btn {
            cursor: pointer;
            background: #f8f9fa;
            border-left: none;
        }

        .profile-field-card {
            background: #fbfcfe;
            border: 1px solid #edf2f7;
            border-radius: 10px;
            padding: 16px;
        }

        .profile-field-label {
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #8898aa;
            margin-bottom: 4px;
            font-weight: 600;
        }

        .profile-field-val {
            font-size: 1rem;
            color: #1e293b;
            font-weight: 500;
            margin-bottom: 0;
        }
    </style>
</head>

<body>
    <!-- ======== Preloader =========== -->
    <div id="preloader">
        <div class="spinner"></div>
    </div>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "profile";
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
                                <h2>My Profile & Settings</h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= ROOT_URL ?>dashboard/user">Overview</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            Profile
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========== title-wrapper end ========== -->

                <!-- User Top Profile Header Card -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card-style p-4">
                            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                                <div class="profile-avatar-wrapper">
                                    <img src="<?= $profile_pic_path ?>" alt="Profile Picture" id="headerAvatarImg" onerror="this.onerror=null; this.src='<?= ROOT_URL ?>backend/account/profileImages/default.png';">
                                    <label for="profilePicInput" class="avatar-edit-overlay" title="Click to change photo">
                                        <i class="fa-solid fa-camera"></i>
                                    </label>
                                </div>
                                <div class="flex-grow-1 text-center text-md-start">
                                    <h3 class="fw-bold mb-1"><?= htmlspecialchars($user_row['first_name'] . ' ' . $user_row['last_name']) ?></h3>
                                    <p class="text-muted mb-2">@<?= htmlspecialchars($user_row['username']) ?> &bull; <?= htmlspecialchars($user_row['email']) ?></p>
                                    <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2 align-items-center">
                                        <span class="badge bg-light text-dark border px-3 py-2">
                                            <i class="fa-solid fa-building-columns text-primary me-1"></i> <?= htmlspecialchars($user_row['account_number'] ?? 'N/A') ?>
                                        </span>
                                        <span class="badge bg-light text-dark border px-3 py-2">
                                            <?= htmlspecialchars($user_row['account_type'] ?? 'Checking') ?> Account
                                        </span>
                                        <?php if ($k_status === 'approved'): ?>
                                            <span class="badge bg-success-subtle text-success border border-success px-3 py-2">
                                                <i class="fa-solid fa-circle-check me-1"></i> KYC Verified
                                            </span>
                                        <?php elseif ($k_status === 'pending'): ?>
                                            <span class="badge bg-info-subtle text-info border border-info px-3 py-2">
                                                <i class="fa-solid fa-clock me-1"></i> KYC Under Review
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-2">
                                                <i class="fa-solid fa-triangle-exclamation me-1"></i> KYC Unverified
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabs Container -->
                <div class="row">
                    <div class="col-12">
                        <div class="card-style mb-30 p-0 overflow-hidden">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs profile-nav-tabs border-bottom px-4 pt-2" id="profileTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview" type="button" role="tab" aria-controls="overview" aria-selected="true">
                                        <i class="fa-solid fa-id-card"></i> Overview
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab" aria-controls="edit" aria-selected="false">
                                        <i class="fa-solid fa-user-pen"></i> Edit Profile
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab" aria-controls="password" aria-selected="false">
                                        <i class="fa-solid fa-shield-halved"></i> Security & Password
                                    </button>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content p-4" id="profileTabContent">
                                <!-- TAB 1: OVERVIEW -->
                                <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h5 class="mb-0 fw-bold">Personal Information</h5>
                                        <button class="btn btn-outline-primary btn-sm" onclick="switchToEditTab()">
                                            <i class="fa-solid fa-pen-to-square me-1"></i> Edit Profile
                                        </button>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-6 col-12">
                                            <div class="profile-field-card">
                                                <div class="profile-field-label">Full Name</div>
                                                <p class="profile-field-val"><?= htmlspecialchars($user_row['first_name'] . ' ' . $user_row['last_name']) ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="profile-field-card">
                                                <div class="profile-field-label">Email Address</div>
                                                <p class="profile-field-val"><?= htmlspecialchars($user_row['email']) ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="profile-field-card">
                                                <div class="profile-field-label">Phone Number</div>
                                                <p class="profile-field-val"><?= htmlspecialchars($user_row['phone'] ?? 'Not set') ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="profile-field-card">
                                                <div class="profile-field-label">Date of Birth</div>
                                                <p class="profile-field-val"><?= htmlspecialchars($user_row['dob'] ?? 'Not set') ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="profile-field-card">
                                                <div class="profile-field-label">Country</div>
                                                <p class="profile-field-val"><?= htmlspecialchars($user_row['country'] ?? 'Not set') ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="profile-field-card">
                                                <div class="profile-field-label">Occupation</div>
                                                <p class="profile-field-val"><?= htmlspecialchars($user_row['occupation'] ?? 'Not set') ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="profile-field-card">
                                                <div class="profile-field-label">Residential Address</div>
                                                <p class="profile-field-val"><?= htmlspecialchars($user_row['address'] ?? 'Not set') ?></p>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-12">
                                            <div class="profile-field-card">
                                                <div class="profile-field-label">KYC Status</div>
                                                <p class="profile-field-val">
                                                    <?php if ($k_status === 'approved'): ?>
                                                        <span class="text-success"><i class="fa-solid fa-circle-check"></i> Approved</span>
                                                    <?php elseif ($k_status === 'pending'): ?>
                                                        <span class="text-info"><i class="fa-solid fa-clock"></i> Documents Under Review</span>
                                                        <a href="<?= ROOT_URL ?>dashboard/user/kyc" class="small ms-2">View</a>
                                                    <?php elseif ($k_status === 'rejected'): ?>
                                                        <span class="text-danger"><i class="fa-solid fa-circle-xmark"></i> Rejected</span>
                                                        <a href="<?= ROOT_URL ?>dashboard/user/kyc" class="small ms-2 fw-bold text-danger">Re-submit</a>
                                                    <?php else: ?>
                                                        <span class="text-warning"><i class="fa-solid fa-triangle-exclamation"></i> Unverified</span>
                                                        <a href="<?= ROOT_URL ?>dashboard/user/kyc" class="small ms-2 fw-bold text-primary">Verify Now</a>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- TAB 2: EDIT PROFILE -->
                                <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                                    <form id="editProfileForm" enctype="multipart/form-data">
                                        <div class="d-flex align-items-center gap-4 mb-4 p-3 bg-light rounded-3">
                                            <div style="position: relative; width: 80px; height: 80px; border-radius: 50%; overflow: hidden;">
                                                <img src="<?= $profile_pic_path ?>" id="previewAvatarImg" style="width: 100%; height: 100%; object-fit: cover;" alt="Avatar Preview" onerror="this.onerror=null; this.src='<?= ROOT_URL ?>backend/account/profileImages/default.png';">
                                            </div>
                                            <div>
                                                <label class="btn btn-sm btn-outline-primary mb-1">
                                                    <i class="fa-solid fa-camera me-1"></i> Upload New Photo
                                                    <input type="file" name="profile_pic" id="profilePicInput" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                                                </label>
                                                <p class="text-muted small mb-0">Accepted: JPG, PNG, WEBP (Max 3MB)</p>
                                            </div>
                                        </div>

                                        <div class="row g-3">
                                            <div class="col-md-6 col-12">
                                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($user_row['first_name']) ?>" required>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($user_row['last_name']) ?>" required>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Email Address</label>
                                                <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($user_row['email']) ?>" readonly title="Email cannot be changed directly">
                                                <small class="text-muted">Registered account email</small>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user_row['username']) ?>" readonly>
                                                <small class="text-muted">Unique account username</small>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Phone Number</label>
                                                <input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($user_row['phone'] ?? '') ?>" placeholder="e.g. +1 234 567 8900">
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Date of Birth</label>
                                                <input type="date" class="form-control" name="dob" value="<?= htmlspecialchars($user_row['dob'] ?? '') ?>">
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Country</label>
                                                <select class="form-select" name="country" id="countrySelect">
                                                    <option value="">Select Country</option>
                                                    <?php 
                                                        $current_country = strtolower($user_row['country'] ?? '');
                                                        if (isset($countries) && is_array($countries)) {
                                                            foreach ($countries as $c) {
                                                                $c_name = $c['name'] ?? '';
                                                                $c_code = $c['code'] ?? '';
                                                                $selected = (strtolower($c_name) === $current_country || strtolower($c_code) === $current_country) ? 'selected' : '';
                                                                echo '<option value="' . htmlspecialchars($c_name) . '" ' . $selected . '>' . htmlspecialchars($c_name) . '</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            <div class="col-md-6 col-12">
                                                <label class="form-label">Occupation</label>
                                                <input type="text" class="form-control" name="occupation" value="<?= htmlspecialchars($user_row['occupation'] ?? '') ?>" placeholder="e.g. Software Engineer">
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Residential Address</label>
                                                <textarea class="form-control" name="address" rows="3" placeholder="Enter your full street address"><?= htmlspecialchars($user_row['address'] ?? '') ?></textarea>
                                            </div>
                                        </div>

                                        <div class="mt-4 pt-2">
                                            <button type="submit" id="saveProfileBtn" class="btn btn-primary px-4 py-2 fw-bold">
                                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Changes
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- TAB 3: CHANGE PASSWORD -->
                                <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                                    <div class="row">
                                        <div class="col-lg-7 col-12">
                                            <h5 class="mb-3 fw-bold">Change Your Account Password</h5>
                                            <p class="text-muted mb-4 small">
                                                Ensure your account is using a strong password. You will need to enter your current password for security verification.
                                            </p>

                                            <form id="changePasswordForm">
                                                <div class="mb-3">
                                                    <label class="form-label">Current Password <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="current_password" id="current_password" placeholder="Enter your current password" required>
                                                        <button class="btn btn-outline-secondary password-toggle-btn" type="button" onclick="togglePassVisibility('current_password', this)">
                                                            <i class="fa-solid fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">New Password <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="Enter new password (min. 6 chars)" required minlength="6">
                                                        <button class="btn btn-outline-secondary password-toggle-btn" type="button" onclick="togglePassVisibility('new_password', this)">
                                                            <i class="fa-solid fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                    <div class="form-text">Must be at least 6 characters long.</div>
                                                </div>

                                                <div class="mb-4">
                                                    <label class="form-label">Confirm New Password <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm your new password" required minlength="6">
                                                        <button class="btn btn-outline-secondary password-toggle-btn" type="button" onclick="togglePassVisibility('confirm_password', this)">
                                                            <i class="fa-solid fa-eye-slash"></i>
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="bg-light p-3 rounded-3 mb-4">
                                                    <h6 class="fw-bold small mb-2 text-secondary">
                                                        <i class="fa-solid fa-shield-halved text-primary me-1"></i> Security Tips:
                                                    </h6>
                                                    <ul class="small text-muted mb-0 ps-3">
                                                        <li>Use a mix of uppercase and lowercase letters, numbers, and symbols.</li>
                                                        <li>Do not reuse passwords from other services.</li>
                                                        <li>Never share your banking password with anyone.</li>
                                                    </ul>
                                                </div>

                                                <button type="submit" id="updatePasswordBtn" class="btn btn-primary px-4 py-2 fw-bold">
                                                    <i class="fa-solid fa-key me-1"></i> Update Password
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
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
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>

    <script>
        // Dismiss preloader immediately once DOM is ready
        (function() {
            function hidePreloader() {
                const preloader = document.getElementById('preloader');
                if (preloader) {
                    preloader.style.display = 'none';
                }
            }
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', hidePreloader);
            } else {
                hidePreloader();
            }
            window.addEventListener('load', hidePreloader);
        })();

        // Check hash to switch tabs directly (e.g. #password or #edit)
        document.addEventListener("DOMContentLoaded", function() {
            const hash = window.location.hash;
            if (hash === '#password') {
                const passTab = new bootstrap.Tab(document.getElementById('password-tab'));
                passTab.show();
            } else if (hash === '#edit') {
                const editTab = new bootstrap.Tab(document.getElementById('edit-tab'));
                editTab.show();
            }
        });

        function switchToEditTab() {
            const editTab = new bootstrap.Tab(document.getElementById('edit-tab'));
            editTab.show();
        }

        // Preview avatar on select
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('previewAvatarImg').src = e.target.result;
                    document.getElementById('headerAvatarImg').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        // Toggle password visibility
        function togglePassVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        }

        // Edit Profile Form AJAX
        const editProfileForm = document.getElementById('editProfileForm');
        if (editProfileForm) {
            editProfileForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const btn = document.getElementById('saveProfileBtn');
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Saving...';

                const formData = new FormData(editProfileForm);

                fetch('<?= ROOT_URL ?>backend/account/user_update_profile.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Save Changes';

                    if (data.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Profile Updated!',
                            text: 'Your profile changes have been saved successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: data || 'An error occurred while updating profile.'
                        });
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-floppy-disk me-1"></i> Save Changes';
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Unable to communicate with the server. Please check your connection.'
                    });
                });
            });
        }

        // Change Password Form AJAX
        const changePasswordForm = document.getElementById('changePasswordForm');
        if (changePasswordForm) {
            changePasswordForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const newPass = document.getElementById('new_password').value;
                const confirmPass = document.getElementById('confirm_password').value;

                if (newPass.length < 6) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Password Too Short',
                        text: 'Your new password must be at least 6 characters long.'
                    });
                    return;
                }

                if (newPass !== confirmPass) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Passwords Do Not Match',
                        text: 'Your new password and confirmation password do not match.'
                    });
                    return;
                }

                const btn = document.getElementById('updatePasswordBtn');
                btn.disabled = true;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Updating Password...';

                const formData = new FormData(changePasswordForm);

                fetch('<?= ROOT_URL ?>backend/account/user_change_password.php', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.text())
                .then(data => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-key me-1"></i> Update Password';

                    if (data.trim() === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Password Updated!',
                            text: 'Your password has been changed successfully.',
                            confirmButtonColor: '#0d6efd'
                        }).then(() => {
                            changePasswordForm.reset();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Update Failed',
                            text: data || 'An error occurred while updating password.'
                        });
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    btn.innerHTML = '<i class="fa-solid fa-key me-1"></i> Update Password';
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Unable to communicate with the server. Please check your connection.'
                    });
                });
            });
        }
    </script>
</body>

</html>