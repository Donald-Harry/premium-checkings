<?php
session_start();
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";

// If user is already logged in and active, redirect to dashboard
if (isset($_SESSION['userlogin']) && $_SESSION['userlogin'] === true) {
    header("Location: " . ROOT_URL . "dashboard/user/");
    exit();
}

$pending_email = isset($_SESSION['pending_activation_email']) ? $_SESSION['pending_activation_email'] : '';
if (empty($pending_email) && isset($_GET['email'])) {
    $pending_email = filter_var($_GET['email'], FILTER_VALIDATE_EMAIL) ? $_GET['email'] : '';
}

// Function to mask email for privacy
function maskEmail($email) {
    if (empty($email)) return "your registered email address";
    $parts = explode("@", $email);
    if (count($parts) != 2) return $email;
    $name = $parts[0];
    $domain = $parts[1];
    $len = strlen($name);
    if ($len <= 2) {
        $maskedName = substr($name, 0, 1) . '*';
    } else {
        $maskedName = substr($name, 0, 2) . str_repeat('*', max(3, $len - 3)) . substr($name, -1);
    }
    return $maskedName . '@' . $domain;
}

$maskedEmail = maskEmail($pending_email);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- All Meta -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Page Title -->
    <title><?= $companyName ?> || Activate Your Account</title>

    <!-- FAVICON -->
    <link rel="icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">

    <link href="<?= ROOT_URL ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>assets/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/sweetalert2.min.css">
    <link href="<?= ROOT_URL ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>assets/css/custom.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>dashboard/assets/css/iziToast.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>account/account.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            width: 100%;
            background-color: #f4f7fb;
        }
        .account-login {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 30px 15px;
        }
        .otp-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: #ffffff;
            overflow: hidden;
        }
        .otp-card .card-body {
            padding: 40px 35px;
        }
        .otp-icon-wrapper {
            width: 72px;
            height: 72px;
            background: rgba(13, 110, 253, 0.1);
            color: #0d6efd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin: 0 auto 20px auto;
        }
        .otp-input-field {
            letter-spacing: 12px;
            font-size: 30px;
            font-weight: 700;
            text-align: center;
            height: 64px;
            border: 2px solid #dde3ea;
            border-radius: 10px;
            transition: all 0.2s ease-in-out;
            font-family: 'Courier New', Courier, monospace;
        }
        .otp-input-field:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.15);
            outline: none;
        }
        .btn-activate {
            background-color: #0d6efd;
            color: #ffffff;
            font-weight: 600;
            font-size: 16px;
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            width: 100%;
            transition: all 0.2s;
        }
        .btn-activate:hover {
            background-color: #0b5ed7;
            color: #ffffff;
        }
        .btn-activate:disabled {
            background-color: #6c757d;
            opacity: 0.75;
        }
        .resend-box {
            margin-top: 20px;
            font-size: 14px;
            color: #6c757d;
        }
        .resend-link {
            color: #0d6efd;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }
        .resend-link:hover {
            text-decoration: underline;
        }
        .resend-link.disabled {
            color: #adb5bd;
            pointer-events: none;
            cursor: not-allowed;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="account-login">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8 col-12">
                    <div class="card otp-card">
                        <div class="card-body text-center">
                            <div class="otp-icon-wrapper">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <h3 class="fw-bold mb-2">Account Activation</h3>
                            <p class="text-muted mb-4">
                                We've sent a 6-digit verification code to<br>
                                <strong class="text-dark"><?= htmlspecialchars($maskedEmail) ?></strong>
                            </p>

                            <form id="otpForm" autocomplete="off">
                                <input type="hidden" name="email" value="<?= htmlspecialchars($pending_email) ?>">
                                
                                <div class="form-group mb-4">
                                    <input 
                                        type="text" 
                                        class="form-control otp-input-field" 
                                        name="otp" 
                                        id="otpInput" 
                                        maxlength="6" 
                                        placeholder="------" 
                                        inputmode="numeric" 
                                        pattern="[0-9]*" 
                                        required 
                                        autofocus
                                    >
                                    <small class="text-muted mt-2 d-block">Enter the 6-digit code from your email</small>
                                </div>

                                <div class="mb-3">
                                    <button type="submit" class="btn btn-activate" id="verifyBtn">
                                        <i class="fa-solid fa-circle-check me-2"></i> Verify &amp; Activate
                                    </button>
                                </div>
                            </form>

                            <div class="resend-box">
                                Didn't receive the email? 
                                <span id="resendCountdown" class="d-none text-muted fw-bold"></span>
                                <a id="resendLink" class="resend-link">Resend Code</a>
                            </div>

                            <hr class="my-4">

                            <div class="text-center">
                                <a href="<?= ROOT_URL ?>account/" class="text-decoration-none text-muted small">
                                    <i class="fa-solid fa-arrow-left me-1"></i> Return to Sign In
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/iziToast.js"></script>
    <script>
        const otpForm = document.querySelector("#otpForm");
        const otpInput = document.querySelector("#otpInput");
        const verifyBtn = document.querySelector("#verifyBtn");
        const resendLink = document.querySelector("#resendLink");
        const resendCountdown = document.querySelector("#resendCountdown");

        // Format OTP input to only allow numbers
        otpInput.addEventListener("input", function(e) {
            this.value = this.value.replace(/[^0-9]/g, '').slice(0, 6);
            if (this.value.length === 6) {
                // Auto-trigger submit when 6 digits are typed
                verifyBtn.focus();
            }
        });

        // Submit OTP for verification
        otpForm.onsubmit = function(e) {
            e.preventDefault();
            const otpVal = otpInput.value.trim();

            if (otpVal.length !== 6) {
                iziToast.warning({
                    title: 'Incomplete Code',
                    message: 'Please enter all 6 digits of your OTP code.',
                    position: 'topRight'
                });
                otpInput.focus();
                return;
            }

            verifyBtn.disabled = true;
            verifyBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Activating...';

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= ROOT_URL ?>backend/account/verify_otp.php", true);
            xhr.onload = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    verifyBtn.disabled = false;
                    verifyBtn.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Verify &amp; Activate';

                    if (xhr.status === 200) {
                        const res = xhr.response ? xhr.response.trim() : '';
                        console.log("Verify response:", res);

                        if (res === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Account Activated!',
                                text: 'Your account has been successfully verified and activated. Redirecting to your dashboard...',
                                showConfirmButton: false,
                                timer: 2000
                            }).then(() => {
                                window.location.href = "<?= ROOT_URL ?>dashboard/user/";
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Activation Failed',
                                text: res || 'Invalid verification code. Please try again.'
                            });
                            otpInput.value = '';
                            otpInput.focus();
                        }
                    } else {
                        iziToast.error({
                            title: 'Error',
                            message: 'Server error (' + xhr.status + '). Please try again.',
                            position: 'topRight'
                        });
                    }
                }
            };

            xhr.onerror = function() {
                verifyBtn.disabled = false;
                verifyBtn.innerHTML = '<i class="fa-solid fa-circle-check me-2"></i> Verify &amp; Activate';
                iziToast.error({
                    title: 'Network Error',
                    message: 'Could not connect to server. Please check your connection.',
                    position: 'topRight'
                });
            };

            const formData = new FormData(otpForm);
            xhr.send(formData);
        };

        // Resend OTP Countdown logic
        let countdownTimer = null;
        function startCooldown(seconds) {
            resendLink.classList.add('disabled');
            resendLink.classList.add('d-none');
            resendCountdown.classList.remove('d-none');
            
            let timeLeft = seconds;
            resendCountdown.innerText = `Resend in ${timeLeft}s`;

            if (countdownTimer) clearInterval(countdownTimer);
            countdownTimer = setInterval(() => {
                timeLeft--;
                if (timeLeft <= 0) {
                    clearInterval(countdownTimer);
                    resendCountdown.classList.add('d-none');
                    resendLink.classList.remove('d-none');
                    resendLink.classList.remove('disabled');
                    resendLink.innerText = 'Resend Code';
                } else {
                    resendCountdown.innerText = `Resend in ${timeLeft}s`;
                }
            }, 1000);
        }

        // Handle Resend Click
        resendLink.onclick = function() {
            if (resendLink.classList.contains('disabled')) return;

            resendLink.classList.add('disabled');
            resendLink.innerText = 'Sending new code...';

            const xhr = new XMLHttpRequest();
            xhr.open("POST", "<?= ROOT_URL ?>backend/account/resend_otp.php", true);
            xhr.onload = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        const res = xhr.response ? xhr.response.trim() : '';
                        if (res === 'success') {
                            iziToast.success({
                                title: 'Code Sent!',
                                message: 'A fresh 6-digit activation code has been sent to your email.',
                                position: 'topRight'
                            });
                            startCooldown(45);
                        } else {
                            resendLink.classList.remove('disabled');
                            resendLink.innerText = 'Resend Code';
                            iziToast.warning({
                                title: 'Notice',
                                message: res,
                                position: 'topRight'
                            });
                        }
                    } else {
                        resendLink.classList.remove('disabled');
                        resendLink.innerText = 'Resend Code';
                        iziToast.error({
                            title: 'Error',
                            message: 'Failed to resend code. Please try again.',
                            position: 'topRight'
                        });
                    }
                }
            };
            xhr.onerror = function() {
                resendLink.classList.remove('disabled');
                resendLink.innerText = 'Resend Code';
                iziToast.error({
                    title: 'Network Error',
                    message: 'Network issue. Please try again.',
                    position: 'topRight'
                });
            };

            const formData = new FormData(otpForm);
            xhr.send(formData);
        };
    </script>
</body>
</html>
