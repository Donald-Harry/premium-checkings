<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "backend/config.php";
include_once WEB_ROOT . "_includes/companyDetails.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../../account");
    exit();
}

$userid = $_SESSION['user_id'];
$get_user_details = $conn->query("SELECT * FROM users WHERE users.id = '{$userid}'");
$user_row = $get_user_details->fetch_assoc();

$kyc_status = !empty($user_row['kyc_status']) ? $user_row['kyc_status'] : 'unverified';
$has_kyc_docs = !empty($user_row['id_front']) && !empty($user_row['id_back']);
if (!$has_kyc_docs && $kyc_status !== 'rejected') {
    $kyc_status = 'unverified';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">
    <title><?= $companyName ?> || KYC Verification</title>

    <!-- ========== All CSS files linkup ========= -->
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/lineicons.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/main.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>dashboard/assets/css/custom.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .kyc-upload-box {
            border: 2px dashed #cfd7df;
            border-radius: 12px;
            padding: 25px 15px;
            text-align: center;
            background: #fbfcfe;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            min-height: 210px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .kyc-upload-box:hover, .kyc-upload-box.dragover {
            border-color: #2f80ed;
            background: #f0f6ff;
        }

        .kyc-upload-box input[type="file"] {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 10;
        }

        .kyc-icon-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: #eaf2fd;
            color: #2f80ed;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 12px;
        }

        .preview-container {
            max-width: 100%;
            max-height: 160px;
            display: none;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .preview-container img {
            width: 100%;
            height: 160px;
            object-fit: cover;
        }

        .doc-thumbnail {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #e1e7ec;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .doc-thumbnail:hover {
            transform: scale(1.02);
        }

        .status-badge {
            font-size: 0.85rem;
            padding: 6px 14px;
            border-radius: 20px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .status-badge.unverified {
            background-color: #fff3cd;
            color: #856404;
            border: 1px solid #ffeeba;
        }

        .status-badge.pending {
            background-color: #cff4fc;
            color: #055160;
            border: 1px solid #b6effb;
        }

        .status-badge.approved {
            background-color: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .status-badge.rejected {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
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
    <?php $location = "kyc";
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
                                <h2>Identity Verification (KYC)</h2>
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
                                            KYC Verification
                                        </li>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========== title-wrapper end ========== -->

                <!-- Status Banner Card -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card-style p-4">
                            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                <div>
                                    <h4 class="mb-1 d-flex align-items-center gap-2">
                                        Account Verification Status: 
                                        <?php if ($kyc_status === 'approved'): ?>
                                            <span class="status-badge approved"><i class="fa-solid fa-circle-check"></i> Verified</span>
                                        <?php elseif ($kyc_status === 'pending'): ?>
                                            <span class="status-badge pending"><i class="fa-solid fa-clock"></i> Under Review</span>
                                        <?php elseif ($kyc_status === 'rejected'): ?>
                                            <span class="status-badge rejected"><i class="fa-solid fa-circle-xmark"></i> Rejected</span>
                                        <?php else: ?>
                                            <span class="status-badge unverified"><i class="fa-solid fa-triangle-exclamation"></i> Unverified</span>
                                        <?php endif; ?>
                                    </h4>
                                    <p class="text-muted mb-0">
                                        <?php if ($kyc_status === 'approved'): ?>
                                            Your identity documents have been approved. Your account has full access to all banking features.
                                        <?php elseif ($kyc_status === 'pending'): ?>
                                            Your ID card (Front and Back) is currently being reviewed by our verification team. This typically takes 24-48 hours.
                                        <?php elseif ($kyc_status === 'rejected'): ?>
                                            Your previous submission was not approved. Please see the details below and upload clear photos of your ID card.
                                        <?php else: ?>
                                            Government regulations require identity verification. Please upload clear photos of the <strong>front</strong> and <strong>back</strong> of your government-issued ID card.
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <?php if ($kyc_status === 'approved'): ?>
                                    <div class="text-success text-center px-3 py-2 bg-light rounded-3">
                                        <i class="fa-solid fa-shield-halved fa-2x"></i>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($kyc_status === 'rejected' && !empty($user_row['kyc_reason'])): ?>
                                <div class="alert alert-danger mt-3 mb-0" role="alert">
                                    <h6 class="alert-heading fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Rejection Reason:</h6>
                                    <p class="mb-0"><?= htmlspecialchars($user_row['kyc_reason']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- KYC Upload Form & Document Preview -->
                <div class="row">
                    <!-- Upload Form Column -->
                    <div class="<?= $has_kyc_docs ? 'col-lg-7' : 'col-lg-8 offset-lg-2' ?> col-12">
                        <div class="card-style mb-30">
                            <h5 class="mb-20">
                                <i class="fa-solid fa-id-card text-primary me-2"></i> 
                                <?= ($kyc_status === 'approved') ? 'Verified ID Document' : (($kyc_status === 'pending') ? 'Update / Re-submit ID Documents' : 'Upload ID Card Documents') ?>
                            </h5>

                            <?php if ($kyc_status === 'approved'): ?>
                                <div class="alert alert-success d-flex align-items-center" role="alert">
                                    <i class="fa-solid fa-check-circle fa-2x me-3"></i>
                                    <div>
                                        <h6 class="alert-heading mb-1">Identity Verified</h6>
                                        <p class="mb-0">Your account is fully verified with your <?= htmlspecialchars($user_row['id_type'] ?? 'ID Card') ?>. No further action is required.</p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <form id="kycForm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label fw-bold">ID Document Type <span class="text-danger">*</span></label>
                                        <select class="form-select" name="id_type" id="id_type" required <?= ($kyc_status === 'approved') ? 'disabled' : '' ?>>
                                            <option value="">Select Document Type</option>
                                            <option value="National Identity Card (NID)" <?= ($user_row['id_type'] ?? '') === 'National Identity Card (NID)' ? 'selected' : '' ?>>National Identity Card (NID)</option>
                                            <option value="Driver's License" <?= ($user_row['id_type'] ?? '') === "Driver's License" ? 'selected' : '' ?>>Driver's License</option>
                                            <option value="International Passport" <?= ($user_row['id_type'] ?? '') === 'International Passport' ? 'selected' : '' ?>>International Passport</option>
                                            <option value="Voter's Card" <?= ($user_row['id_type'] ?? '') === "Voter's Card" ? 'selected' : '' ?>>Voter's Card</option>
                                            <option value="Permanent Resident Card" <?= ($user_row['id_type'] ?? '') === 'Permanent Resident Card' ? 'selected' : '' ?>>Permanent Resident Card</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6 col-12 mb-3">
                                        <label class="form-label fw-bold">Document / ID Number</label>
                                        <input type="text" class="form-control" name="id_number" id="id_number" placeholder="e.g. A12345678" value="<?= htmlspecialchars($user_row['id_number'] ?? '') ?>" <?= ($kyc_status === 'approved') ? 'disabled' : '' ?>>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <!-- FRONT ID UPLOAD -->
                                    <div class="col-md-6 col-12 mb-4">
                                        <label class="form-label fw-bold d-block">
                                            <i class="fa-solid fa-image text-primary me-1"></i> Front of ID Card <span class="text-danger">*</span>
                                        </label>
                                        <div class="kyc-upload-box" id="box_front">
                                            <input type="file" name="id_front" id="id_front" accept="image/*,.pdf" <?= ($kyc_status === 'approved') ? 'disabled' : 'required' ?> onchange="previewFile('id_front', 'preview_front', 'box_front')">
                                            <div class="kyc-upload-content text-center" id="content_front">
                                                <div class="kyc-icon-circle mx-auto">
                                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                                </div>
                                                <h6 class="mb-1">Upload ID Front</h6>
                                                <p class="text-muted small mb-0">Drag & drop or <span class="text-primary fw-bold">browse</span></p>
                                                <span class="badge bg-light text-secondary mt-2">JPG, PNG, WEBP, PDF</span>
                                            </div>
                                            <div class="preview-container" id="preview_front">
                                                <img src="" alt="Front ID Preview" id="img_front">
                                                <small class="d-block text-muted mt-1" id="name_front"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- BACK ID UPLOAD -->
                                    <div class="col-md-6 col-12 mb-4">
                                        <label class="form-label fw-bold d-block">
                                            <i class="fa-solid fa-image text-primary me-1"></i> Back of ID Card <span class="text-danger">*</span>
                                        </label>
                                        <div class="kyc-upload-box" id="box_back">
                                            <input type="file" name="id_back" id="id_back" accept="image/*,.pdf" <?= ($kyc_status === 'approved') ? 'disabled' : 'required' ?> onchange="previewFile('id_back', 'preview_back', 'box_back')">
                                            <div class="kyc-upload-content text-center" id="content_back">
                                                <div class="kyc-icon-circle mx-auto">
                                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                                </div>
                                                <h6 class="mb-1">Upload ID Back</h6>
                                                <p class="text-muted small mb-0">Drag & drop or <span class="text-primary fw-bold">browse</span></p>
                                                <span class="badge bg-light text-secondary mt-2">JPG, PNG, WEBP, PDF</span>
                                            </div>
                                            <div class="preview-container" id="preview_back">
                                                <img src="" alt="Back ID Preview" id="img_back">
                                                <small class="d-block text-muted mt-1" id="name_back"></small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Verification Guidelines -->
                                <div class="bg-light p-3 rounded-3 mb-4">
                                    <h6 class="fw-bold mb-2 small text-uppercase text-secondary">
                                        <i class="fa-solid fa-circle-info text-primary me-1"></i> Guidelines for fast verification:
                                    </h6>
                                    <ul class="mb-0 small text-muted ps-3">
                                        <li>Ensure all 4 corners of your ID card are clearly visible without cutting off edges.</li>
                                        <li>Photos must be sharp, in focus, with no flash glare or shadows over text.</li>
                                        <li>Your ID card must be valid and not expired.</li>
                                        <li>Maximum file size is 5MB per document.</li>
                                    </ul>
                                </div>

                                <?php if ($kyc_status !== 'approved'): ?>
                                    <div class="d-grid">
                                        <button type="submit" id="submitKycBtn" class="btn btn-primary btn-lg fw-bold py-2">
                                            <i class="fa-solid fa-paper-plane me-2"></i> Submit ID Documents
                                        </button>
                                    </div>
                                <?php else: ?>
                                    <div class="text-center">
                                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="enableReupload()">
                                            <i class="fa-solid fa-rotate me-1"></i> Need to update your ID? Click here
                                        </button>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>

                    <!-- Submitted Documents Preview Column (if already uploaded) -->
                    <?php if ($has_kyc_docs): ?>
                        <div class="col-lg-5 col-12">
                            <div class="card-style mb-30">
                                <h5 class="mb-20 d-flex justify-content-between align-items-center">
                                    <span><i class="fa-solid fa-folder-open text-info me-2"></i> Current Documents</span>
                                    <?php if (!empty($user_row['kyc_submitted_at'])): ?>
                                        <span class="badge bg-light text-muted small" style="font-weight: normal;">
                                            <?= date('M d, Y', strtotime($user_row['kyc_submitted_at'])) ?>
                                        </span>
                                    <?php endif; ?>
                                </h5>

                                <div class="mb-4">
                                    <label class="fw-bold small text-muted mb-2 d-block">FRONT OF ID CARD</label>
                                    <?php 
                                        $frontPath = ROOT_URL . "backend/account/kycDocuments/" . $user_row['id_front'];
                                        $frontExt = strtolower(pathinfo($user_row['id_front'], PATHINFO_EXTENSION));
                                    ?>
                                    <?php if ($frontExt === 'pdf'): ?>
                                        <div class="p-4 text-center bg-light rounded-3 border">
                                            <i class="fa-solid fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <p class="mb-2 small text-truncate"><?= htmlspecialchars($user_row['id_front']) ?></p>
                                            <a href="<?= $frontPath ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Open PDF
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?= $frontPath ?>" target="_blank" data-bs-toggle="modal" data-bs-target="#frontModal">
                                            <img src="<?= $frontPath ?>" alt="Front ID" class="doc-thumbnail">
                                        </a>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label class="fw-bold small text-muted mb-2 d-block">BACK OF ID CARD</label>
                                    <?php 
                                        $backPath = ROOT_URL . "backend/account/kycDocuments/" . $user_row['id_back'];
                                        $backExt = strtolower(pathinfo($user_row['id_back'], PATHINFO_EXTENSION));
                                    ?>
                                    <?php if ($backExt === 'pdf'): ?>
                                        <div class="p-4 text-center bg-light rounded-3 border">
                                            <i class="fa-solid fa-file-pdf fa-3x text-danger mb-2"></i>
                                            <p class="mb-2 small text-truncate"><?= htmlspecialchars($user_row['id_back']) ?></p>
                                            <a href="<?= $backPath ?>" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fa-solid fa-arrow-up-right-from-square"></i> Open PDF
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <a href="<?= $backPath ?>" target="_blank" data-bs-toggle="modal" data-bs-target="#backModal">
                                            <img src="<?= $backPath ?>" alt="Back ID" class="doc-thumbnail">
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Front Zoom -->
                        <div class="modal fade" id="frontModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Front of ID Card</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center p-2">
                                        <img src="<?= $frontPath ?>" class="img-fluid rounded" alt="Front ID Full">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal for Back Zoom -->
                        <div class="modal fade" id="backModal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Back of ID Card</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body text-center p-2">
                                        <img src="<?= $backPath ?>" class="img-fluid rounded" alt="Back ID Full">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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
        // Live image preview
        function previewFile(inputId, previewId, boxId) {
            const input = document.getElementById(inputId);
            const previewContainer = document.getElementById(previewId);
            const img = previewContainer.querySelector('img');
            const nameLabel = previewContainer.querySelector('small');
            const content = document.getElementById(boxId).querySelector('.kyc-upload-content');

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileType = file.type;

                nameLabel.textContent = file.name + " (" + (file.size / (1024 * 1024)).toFixed(2) + " MB)";

                if (fileType.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                        img.style.display = 'block';
                        previewContainer.style.display = 'block';
                        content.style.display = 'none';
                    };
                    reader.readAsDataURL(file);
                } else {
                    // PDF or other
                    img.style.display = 'none';
                    previewContainer.style.display = 'block';
                    content.style.display = 'none';
                }
            }
        }

        // Enable re-upload for approved users if clicked
        function enableReupload() {
            document.querySelectorAll('#kycForm input, #kycForm select').forEach(el => el.removeAttribute('disabled'));
            const btnContainer = document.querySelector('#kycForm .text-center');
            btnContainer.innerHTML = '<div class="d-grid"><button type="submit" id="submitKycBtn" class="btn btn-primary btn-lg fw-bold py-2"><i class="fa-solid fa-paper-plane me-2"></i> Submit Updated Documents</button></div>';
        }

        // Handle AJAX submission
        const kycForm = document.getElementById('kycForm');
        if (kycForm) {
            kycForm.addEventListener('submit', function(e) {
                e.preventDefault();

                const submitBtn = document.getElementById('submitKycBtn');
                if (!submitBtn) return;

                const frontInput = document.getElementById('id_front');
                const backInput = document.getElementById('id_back');

                if (frontInput.hasAttribute('required') && (!frontInput.files || frontInput.files.length === 0)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Front of ID',
                        text: 'Please upload the front photo of your ID card.'
                    });
                    return;
                }

                if (backInput.hasAttribute('required') && (!backInput.files || backInput.files.length === 0)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Missing Back of ID',
                        text: 'Please upload the back photo of your ID card.'
                    });
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Uploading documents...';

                const formData = new FormData(kycForm);

                fetch('<?= ROOT_URL ?>backend/account/kyc_submit.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    data = data.trim();
                    if (data === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Submitted Successfully!',
                            text: 'Your ID card (front and back) has been submitted for verification. Our compliance team will review it shortly.',
                            confirmButtonColor: '#0d6efd'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i> Submit ID Documents';
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Failed',
                            text: data || 'An unexpected error occurred while uploading. Please try again.'
                        });
                    }
                })
                .catch(err => {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane me-2"></i> Submit ID Documents';
                    Swal.fire({
                        icon: 'error',
                        title: 'Network Error',
                        text: 'Could not connect to the server. Please check your connection and try again.'
                    });
                });
            });
        }
    </script>
</body>

</html>
