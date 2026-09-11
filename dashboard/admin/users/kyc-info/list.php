<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
include_once WEB_ROOT . "backend/config.php";

if (!isset($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true) {
    header("Location: ../../index.php");
    exit();
}

$kyc_query = $conn->query("SELECT * FROM users ORDER BY (CASE WHEN kyc_status = 'pending' THEN 1 WHEN kyc_status = 'rejected' THEN 2 WHEN kyc_status = 'approved' THEN 3 ELSE 4 END), kyc_submitted_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">
    <title><?= $companyName ?> || KYC Management</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/lineicons.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/datatable.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .doc-thumb {
            width: 70px;
            height: 48px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #dee2e6;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .doc-thumb:hover {
            transform: scale(1.1);
        }

        .badge-kyc-pending {
            background-color: #cff4fc;
            color: #055160;
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: 600;
        }

        .badge-kyc-approved {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: 600;
        }

        .badge-kyc-rejected {
            background-color: #f8d7da;
            color: #842029;
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: 600;
        }

        .badge-kyc-unverified {
            background-color: #fff3cd;
            color: #664d03;
            padding: 5px 12px;
            border-radius: 15px;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <!-- ======== Preloader =========== -->
    <?php include WEB_ROOT . "dashboard/admin/_includes/preloader.inc.php" ?>
    <!-- ======== Preloader =========== -->

    <!-- ======== sidebar-nav start =========== -->
    <?php $location = "kyc";
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
                                <h2>KYC Verification Management</h2>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="breadcrumb-wrapper">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="<?= ROOT_URL ?>dashboard/admin/dashboard.php">Dashboard</a>
                                        </li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            KYC Users
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========== title-wrapper end ========== -->

                <div class="row mb-3">
                    <div class="col-lg-12">
                        <div class="card-style mb-30">
                            <div class="title d-flex justify-content-between align-items-center mb-3">
                                <h6>Users ID Verification Submissions</h6>
                            </div>

                            <div class="table-responsive">
                                <table class="table" id="kycTable">
                                    <thead>
                                        <tr>
                                            <th><h6>User</h6></th>
                                            <th><h6>Account #</h6></th>
                                            <th><h6>ID Type & Number</h6></th>
                                            <th><h6>ID Front</h6></th>
                                            <th><h6>ID Back</h6></th>
                                            <th><h6>Status</h6></th>
                                            <th><h6>Submitted</h6></th>
                                            <th><h6>Actions</h6></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if ($kyc_query && $kyc_query->num_rows > 0): ?>
                                            <?php while ($row = $kyc_query->fetch_assoc()): ?>
                                                <?php 
                                                    $k_status = !empty($row['kyc_status']) ? $row['kyc_status'] : 'unverified';
                                                    $has_front = !empty($row['id_front']);
                                                    $has_back = !empty($row['id_back']);
                                                    $front_url = $has_front ? ROOT_URL . "backend/account/kycDocuments/" . $row['id_front'] : '';
                                                    $back_url = $has_back ? ROOT_URL . "backend/account/kycDocuments/" . $row['id_back'] : '';
                                                ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= htmlspecialchars($row['first_name'] . ' ' . $row['last_name']) ?></strong>
                                                        <br>
                                                        <small class="text-muted"><?= htmlspecialchars($row['email']) ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-light text-dark border"><?= htmlspecialchars($row['account_number'] ?? 'N/A') ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="fw-bold"><?= htmlspecialchars($row['id_type'] ?? 'Not Specified') ?></span>
                                                        <?php if (!empty($row['id_number'])): ?>
                                                            <br><small class="text-muted"># <?= htmlspecialchars($row['id_number']) ?></small>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($has_front): ?>
                                                            <img src="<?= $front_url ?>" class="doc-thumb" alt="Front ID" onclick="showImageModal('<?= $front_url ?>', 'Front of ID Card - <?= addslashes($row['first_name'] . ' ' . $row['last_name']) ?>')">
                                                        <?php else: ?>
                                                            <span class="text-muted small"><i class="fa-solid fa-minus"></i> None</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($has_back): ?>
                                                            <img src="<?= $back_url ?>" class="doc-thumb" alt="Back ID" onclick="showImageModal('<?= $back_url ?>', 'Back of ID Card - <?= addslashes($row['first_name'] . ' ' . $row['last_name']) ?>')">
                                                        <?php else: ?>
                                                            <span class="text-muted small"><i class="fa-solid fa-minus"></i> None</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <?php if ($k_status === 'approved'): ?>
                                                            <span class="badge-kyc-approved"><i class="fa-solid fa-check me-1"></i> Approved</span>
                                                        <?php elseif ($k_status === 'pending'): ?>
                                                            <span class="badge-kyc-pending"><i class="fa-solid fa-clock me-1"></i> Pending Review</span>
                                                        <?php elseif ($k_status === 'rejected'): ?>
                                                            <span class="badge-kyc-rejected" title="<?= htmlspecialchars($row['kyc_reason'] ?? '') ?>"><i class="fa-solid fa-xmark me-1"></i> Rejected</span>
                                                        <?php else: ?>
                                                            <span class="badge-kyc-unverified"><i class="fa-solid fa-exclamation me-1"></i> Unverified</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">
                                                            <?= !empty($row['kyc_submitted_at']) ? date('M d, Y H:i', strtotime($row['kyc_submitted_at'])) : '—' ?>
                                                        </small>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex gap-1">
                                                            <?php if ($has_front || $has_back): ?>
                                                                <button class="btn btn-sm btn-success" title="Approve KYC" onclick="updateKycStatus('<?= $row['id'] ?>', 'approve')">
                                                                    <i class="fa-solid fa-check"></i>
                                                                </button>
                                                                <button class="btn btn-sm btn-danger" title="Reject KYC" onclick="promptRejectKyc('<?= $row['id'] ?>')">
                                                                    <i class="fa-solid fa-xmark"></i>
                                                                </button>
                                                            <?php endif; ?>
                                                            <a href="<?= ROOT_URL ?>dashboard/admin/users/details.php?user=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary" title="View Full Details">
                                                                <i class="fa-solid fa-user"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">No users found.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- ========== section end ========== -->

        <!-- Image Preview Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalTitle">ID Document</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-2">
                        <img src="" id="modalImg" class="img-fluid rounded" alt="Document Preview">
                    </div>
                </div>
            </div>
        </div>

        <!-- ========== footer start =========== -->
        <?php include WEB_ROOT . "dashboard/admin/_includes/footer.inc.php" ?>
        <!-- ========== footer end =========== -->
    </main>
    <!-- ======== main-wrapper end =========== -->

    <!-- ========= All Javascript files linkup ======== -->
    <script src="<?= ROOT_URL ?>dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/datatable.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/main.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>

    <script>
        const dataTable = new simpleDatatables.DataTable("#kycTable", {
            searchable: true,
        });

        function showImageModal(src, title) {
            document.getElementById('modalImg').src = src;
            document.getElementById('imageModalTitle').innerText = title;
            new bootstrap.Modal(document.getElementById('imageModal')).show();
        }

        function updateKycStatus(userId, action, reason = '') {
            const actionText = action === 'approve' ? 'Approve' : 'Reject';
            const confirmButtonColor = action === 'approve' ? '#198754' : '#dc3545';

            Swal.fire({
                title: `${actionText} KYC Verification?`,
                text: `Are you sure you want to ${action} this user's identity verification?`,
                icon: action === 'approve' ? 'question' : 'warning',
                showCancelButton: true,
                confirmButtonColor: confirmButtonColor,
                cancelButtonColor: '#6c757d',
                confirmButtonText: `Yes, ${actionText}`
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('user_id', userId);
                    formData.append('action', action);
                    if (reason) {
                        formData.append('reason', reason);
                    }

                    fetch('<?= ROOT_URL ?>backend/account/admin_kyc.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.text())
                    .then(data => {
                        if (data.trim() === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: `KYC has been ${action}d successfully.`,
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: data
                            });
                        }
                    })
                    .catch(err => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to communicate with server.'
                        });
                    });
                }
            });
        }

        function promptRejectKyc(userId) {
            Swal.fire({
                title: 'Reject KYC Verification',
                text: 'Please provide a reason for rejecting this verification:',
                input: 'textarea',
                inputPlaceholder: 'e.g. ID card photo is blurry, back of ID is missing, or document has expired.',
                inputAttributes: {
                    'aria-label': 'Rejection reason'
                },
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                confirmButtonText: 'Reject Verification',
                preConfirm: (reason) => {
                    if (!reason) {
                        Swal.showValidationMessage('Please enter a rejection reason for the user.');
                    }
                    return reason;
                }
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    updateKycStatus(userId, 'reject', result.value);
                }
            });
        }
    </script>
</body>

</html>