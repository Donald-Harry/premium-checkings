<?php
include $_SERVER['APP'];
include_once WEB_ROOT . "_includes/companyDetails.php";
include_once WEB_ROOT . "_includes/countries.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $companyName ?> || Create Your Account</title>

    <!-- Favicon -->
    <link rel="icon" href="<?= ROOT_URL ?><?= $favicon ?>" type="image/x-icon">

    <!-- CSS Dependencies -->
    <link href="<?= ROOT_URL ?>assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= ROOT_URL ?>assets/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>assets/css/sweetalert2.min.css">
    <link href="<?= ROOT_URL ?>dashboard/assets/css/iziToast.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-navy: #0f172a;
            --primary-navy-hover: #1e293b;
            --accent-lime: #dcf28e;
            --accent-lime-light: #eef8c3;
            --accent-lime-border: #0f172a;
            --card-border: #e2e8f0;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            --bg-page: #f4f7fa;
            --input-focus-border: #3b82f6;
            --input-focus-shadow: rgba(59, 130, 246, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-page);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 40px 16px;
            margin: 0;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 660px;
            margin: 0 auto;
        }

        .brand-logo-container {
            text-align: center;
            margin-bottom: 24px;
        }

        .brand-logo-container img {
            max-height: 48px;
            width: auto;
        }

        .register-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid var(--card-border);
            box-shadow: 0 12px 40px -10px rgba(0, 0, 0, 0.08), 0 2px 6px rgba(0, 0, 0, 0.03);
            overflow: hidden;
            padding: 38px 42px;
            transition: all 0.3s ease;
        }

        @media (max-width: 576px) {
            body {
                padding: 20px 12px;
            }
            .register-card {
                padding: 24px 20px;
                border-radius: 16px;
            }
        }

        /* Card Header */
        .card-header-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }

        .card-header-bar h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--primary-navy);
            margin: 0;
            letter-spacing: -0.02em;
        }

        .step-counter {
            font-size: 0.92rem;
            font-weight: 500;
            color: var(--text-muted);
        }

        /* Progress Bar */
        .progress-track {
            height: 6px;
            background-color: #e2e8f0;
            border-radius: 999px;
            overflow: hidden;
            margin-bottom: 12px;
            position: relative;
        }

        .progress-indicator {
            height: 100%;
            background-color: var(--primary-navy);
            width: 25%;
            transition: width 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 999px;
        }

        /* Step Labels */
        .step-labels {
            display: flex;
            justify-content: space-between;
            margin-bottom: 36px;
        }

        .step-label-item {
            font-size: 0.82rem;
            font-weight: 500;
            color: var(--text-light);
            transition: color 0.3s ease;
        }

        .step-label-item.active {
            color: var(--primary-navy);
            font-weight: 700;
        }

        /* Step Hero Section */
        .step-hero-icon {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            /* background-color: var(--accent-lime); */
            background-color: rgba(13, 110, 253, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px auto;
            color: var(--primary-navy);
            font-size: 28px;
            box-shadow: 0 4px 12px rgba(13, 110, 253, 0.1);
        }

        .step-hero-title {
            font-size: 1.35rem;
            font-weight: 700;
            color: var(--primary-navy);
            text-align: center;
            margin-bottom: 6px;
        }

        .step-hero-subtitle {
            font-size: 0.92rem;
            color: var(--text-muted);
            text-align: center;
            margin-bottom: 28px;
            max-width: 480px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.45;
        }

        /* Form Inputs & Labels */
        .form-label {
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: block;
        }

        .input-icon-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon-group .input-icon-left {
            position: absolute;
            left: 16px;
            color: #94a3b8;
            font-size: 16px;
            pointer-events: none;
            z-index: 5;
        }

        .input-icon-group .input-icon-right {
            position: absolute;
            right: 16px;
            color: #94a3b8;
            font-size: 16px;
            cursor: pointer;
            z-index: 5;
            transition: color 0.2s ease;
        }

        .input-icon-group .input-icon-right:hover {
            color: var(--primary-navy);
        }

        .custom-form-control {
            height: 52px;
            border: 1.5px solid var(--card-border);
            border-radius: 10px;
            padding: 0 16px;
            font-size: 0.95rem;
            color: var(--text-dark);
            background-color: #ffffff;
            width: 100%;
            transition: all 0.2s ease;
            font-weight: 500;
        }

        .input-icon-group .custom-form-control {
            padding-left: 46px;
            padding-right: 46px;
        }

        .input-icon-group.no-right-icon .custom-form-control {
            padding-right: 16px;
        }

        .custom-form-control:focus {
            outline: none;
            border-color: var(--input-focus-border);
            box-shadow: 0 0 0 4px var(--input-focus-shadow);
            background-color: #fff;
        }

        .custom-form-control.is-invalid {
            border-color: #ef4444 !important;
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.12) !important;
        }

        .custom-form-control::placeholder {
            color: #94a3b8;
            font-weight: 400;
        }

        select.custom-form-control {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            cursor: pointer;
        }

        /* Account Type Selectable Cards */
        .account-type-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
            margin-bottom: 12px;
        }

        @media (max-width: 576px) {
            .account-type-grid {
                grid-template-columns: 1fr;
            }
        }

        .account-type-card {
            border: 1.5px solid var(--card-border);
            border-radius: 12px;
            padding: 16px;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background-color: #ffffff;
            transition: all 0.2s ease;
        }

        .account-type-card:hover {
            border-color: #94a3b8;
        }

        .account-type-card .card-icon-box {
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background-color: var(--accent-lime);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: var(--primary-navy);
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .account-type-card .card-text-box h6 {
            font-size: 0.95rem;
            font-weight: 700;
            color: var(--primary-navy);
            margin: 0 0 4px 0;
        }

        .account-type-card .card-text-box p {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.35;
        }

        .account-type-card .card-check-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            color: var(--primary-navy);
            font-size: 18px;
            display: none;
        }

        /* Selected State */
        .account-type-card.selected {
            border: 2px solid var(--accent-lime-border);
            background-color: var(--accent-lime-light);
        }

        .account-type-card.selected .card-check-badge {
            display: block;
        }

        .toggle-more-accounts {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.88rem;
            font-weight: 600;
            color: var(--primary-navy);
            cursor: pointer;
            margin-top: 4px;
            margin-bottom: 22px;
            user-select: none;
            transition: color 0.2s ease;
        }

        .toggle-more-accounts:hover {
            color: #3b82f6;
        }

        /* Divider & Action Buttons */
        .step-divider {
            border: 0;
            height: 1px;
            background-color: #f1f5f9;
            margin: 28px 0 22px 0;
        }

        .step-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .btn-prev {
            padding: 11px 22px;
            border: 1.5px solid var(--card-border);
            border-radius: 10px;
            background-color: #ffffff;
            color: var(--primary-navy);
            font-weight: 600;
            font-size: 0.92rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-prev:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
            color: var(--primary-navy);
        }

        .btn-next,
        .btn-submit {
            padding: 11px 26px;
            border: none;
            border-radius: 10px;
            background-color: #0d6efd;
            /* background-color: var(--primary-navy); */
            color: #ffffff;
            font-weight: 600;
            font-size: 0.92rem;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            margin-left: auto;
            text-decoration: none;
        }

        .btn-next:hover,
        .btn-submit:hover {
            background-color: var(--primary-navy-hover);
            color: #ffffff;
            transform: translateY(-1px);
        }

        .btn-next:disabled,
        .btn-submit:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Step Panels Animation */
        .step-panel {
            display: none;
            animation: fadeIn 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-panel.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Checkbox Custom Style */
        .terms-checkbox-wrapper {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 18px;
        }

        .terms-checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            cursor: pointer;
            accent-color: var(--primary-navy);
        }

        .terms-checkbox-wrapper label {
            font-size: 0.88rem;
            color: var(--text-muted);
            margin: 0;
            line-height: 1.4;
            cursor: pointer;
        }

        .terms-checkbox-wrapper a {
            color: var(--primary-navy);
            text-decoration: underline;
            font-weight: 600;
        }

        /* Auth Footer Links */
        .auth-footer-links {
            text-align: center;
            margin-top: 24px;
            font-size: 0.92rem;
            color: var(--text-muted);
        }

        .auth-footer-links a {
            color: var(--primary-navy);
            font-weight: 700;
            text-decoration: none;
        }

        .auth-footer-links a:hover {
            text-decoration: underline;
        }

        /* Pin Mask Dots */
        .pin-mask-font {
            letter-spacing: 0.25em;
            font-size: 1.15rem;
        }
    </style>
</head>

<body>

    <div class="auth-wrapper">
        <!-- Logo Header -->
        <!-- <div class="brand-logo-container">
            <a href="<?= ROOT_URL ?>">
                <img src="<?= ROOT_URL ?>assets/images/logo-no-background.svg" alt="<?= htmlspecialchars($companyName) ?>" onerror="this.onerror=null; this.src='<?= ROOT_URL ?>assets/images/logo/logo.png';">
            </a>
        </div> -->

        <!-- Multi-Step Card -->
        <div class="register-card">
            <!-- Header bar: Title & Step Count -->
            <div class="card-header-bar">
                <h2>Create Your Account</h2>
                <span class="step-counter" id="stepCounterText">Step 1 of 4</span>
            </div>

            <!-- Progress Bar -->
            <div class="progress-track">
                <div class="progress-indicator" id="progressBar"></div>
            </div>

            <!-- Step Labels -->
            <div class="step-labels">
                <span class="step-label-item active" id="labelStep1">Personal Info</span>
                <span class="step-label-item" id="labelStep2">Contact Details</span>
                <span class="step-label-item" id="labelStep3">Account Setup</span>
                <span class="step-label-item" id="labelStep4">Security</span>
            </div>

            <form id="multiStepForm" autocomplete="off">
                <!-- STEP 1: PERSONAL INFORMATION -->
                <div class="step-panel active" id="stepPanel1">
                    <div class="step-hero-icon">
                        <i class="fa-regular fa-user"></i>
                    </div>
                    <div class="step-hero-title">Personal Information</div>
                    <p class="step-hero-subtitle">Please provide your legal name as it appears on official documents</p>

                    <div class="row g-3">
                        <div class="col-md-6 col-12">
                            <label class="form-label" for="firstname">Legal First Name *</label>
                            <input type="text" class="custom-form-control" name="firstname" id="firstname" placeholder="Barry" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label" for="middle_name">Middle Name</label>
                            <input type="text" class="custom-form-control" name="middle_name" id="middle_name" placeholder="David">
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label" for="lastname">Legal Last Name *</label>
                            <input type="text" class="custom-form-control" name="lastname" id="lastname" placeholder="Allen" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label" for="username">Username *</label>
                            <input type="text" class="custom-form-control" name="username" id="username" placeholder="Theflash" required>
                        </div>
                    </div>

                    <hr class="step-divider">

                    <div class="step-actions">
                        <button type="button" class="btn-next" onclick="goToStep(2)">
                            Next <i class="fa-solid fa-chevron-right ms-1 small"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 2: CONTACT DETAILS -->
                <div class="step-panel" id="stepPanel2">
                    <div class="step-hero-icon">
                        <i class="fa-regular fa-envelope"></i>
                    </div>
                    <div class="step-hero-title">Contact Information</div>
                    <p class="step-hero-subtitle">We'll use these details to communicate with you about your account</p>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email Address *</label>
                        <div class="input-icon-group no-right-icon">
                            <i class="fa-regular fa-envelope input-icon-left"></i>
                            <input type="email" class="custom-form-control" name="email" id="email" placeholder="ba7864029@gmail.com" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone Number *</label>
                        <div class="input-icon-group no-right-icon">
                            <i class="fa-solid fa-phone input-icon-left"></i>
                            <input type="tel" class="custom-form-control" name="phone" id="phone" placeholder="+2349063982344" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="country">Country *</label>
                        <div class="input-icon-group no-right-icon">
                            <i class="fa-solid fa-globe input-icon-left"></i>
                            <select name="country" id="country" class="custom-form-control" required>
                                <option value="">Select your country</option>
                                <?php 
                                if (isset($countries) && is_array($countries)) {
                                    foreach ($countries as $c) {
                                        $c_name = $c['name'] ?? '';
                                        $selected = (strtolower($c_name) === 'nigeria') ? 'selected' : '';
                                        echo '<option value="' . htmlspecialchars($c_name) . '" ' . $selected . '>' . htmlspecialchars($c_name) . '</option>';
                                    }
                                } else {
                                    echo '<option value="Nigeria" selected>Nigeria</option>';
                                    echo '<option value="United States">United States</option>';
                                    echo '<option value="United Kingdom">United Kingdom</option>';
                                    echo '<option value="Canada">Canada</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <hr class="step-divider">

                    <div class="step-actions">
                        <button type="button" class="btn-prev" onclick="goToStep(1)">
                            <i class="fa-solid fa-chevron-left me-1 small"></i> Previous
                        </button>
                        <button type="button" class="btn-next" onclick="goToStep(3)">
                            Next <i class="fa-solid fa-chevron-right ms-1 small"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 3: ACCOUNT SETUP -->
                <div class="step-panel" id="stepPanel3">
                    <div class="step-hero-icon">
                        <i class="fa-solid fa-building-columns"></i>
                    </div>
                    <div class="step-hero-title">Account Setup</div>
                    <p class="step-hero-subtitle">Choose your account type and set up your transaction PIN</p>

                    <label class="form-label">Account Type *</label>
                    <input type="hidden" name="account_type" id="selectedAccountType" value="Savings Account">

                    <!-- Main Account Types -->
                    <div class="account-type-grid">
                        <!-- Checking Account -->
                        <div class="account-type-card" data-account="Checking Account" onclick="selectAccountType(this, 'Checking Account')">
                            <i class="fa-solid fa-circle-check card-check-badge"></i>
                            <div class="card-icon-box">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <div class="card-text-box">
                                <h6>Checking Account</h6>
                                <p>Perfect for daily transactions and bill payments</p>
                            </div>
                        </div>

                        <!-- Savings Account (Default Selected) -->
                        <div class="account-type-card selected" data-account="Savings Account" onclick="selectAccountType(this, 'Savings Account')">
                            <i class="fa-solid fa-circle-check card-check-badge"></i>
                            <div class="card-icon-box">
                                <i class="fa-solid fa-piggy-bank"></i>
                            </div>
                            <div class="card-text-box">
                                <h6>Savings Account</h6>
                                <p>Earn interest on your deposits</p>
                            </div>
                        </div>
                    </div>

                    <!-- Collapsible Additional Account Types -->
                    <div id="moreAccountsContainer" style="display: none;">
                        <div class="account-type-grid mt-2">
                            <!-- Fixed Deposit -->
                            <div class="account-type-card" data-account="Fixed Deposit" onclick="selectAccountType(this, 'Fixed Deposit')">
                                <i class="fa-solid fa-circle-check card-check-badge"></i>
                                <div class="card-icon-box">
                                    <i class="fa-solid fa-vault"></i>
                                </div>
                                <div class="card-text-box">
                                <h6>Fixed Deposit</h6>
                                <p>High-yield returns for locked-term deposits</p>
                                </div>
                            </div>

                            <!-- Business Account -->
                            <div class="account-type-card" data-account="Business Account" onclick="selectAccountType(this, 'Business Account')">
                                <i class="fa-solid fa-circle-check card-check-badge"></i>
                                <div class="card-icon-box">
                                    <i class="fa-solid fa-briefcase"></i>
                                </div>
                                <div class="card-text-box">
                                    <h6>Business Account</h6>
                                    <p>Corporate cashflow, payroll and business operations</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="toggle-more-accounts" onclick="toggleMoreAccounts()">
                        <span id="moreAccountsText">Show more account types</span>
                        <i class="fa-solid fa-chevron-down small" id="moreAccountsIcon"></i>
                    </div>

                    <!-- Transaction PIN -->
                    <div class="mb-3">
                        <label class="form-label" for="pin">Transaction PIN (4 digits) *</label>
                        <div class="input-icon-group">
                            <i class="fa-solid fa-key input-icon-left"></i>
                            <input type="password" class="custom-form-control pin-mask-font" name="pin" id="pin" maxlength="4" pattern="[0-9]{4}" inputmode="numeric" placeholder="••••" required>
                            <i class="fa-regular fa-eye input-icon-right" onclick="toggleFieldMask('pin', this)"></i>
                        </div>
                        <small class="text-muted d-block mt-1">Your PIN will be required to authorize transactions</small>
                    </div>

                    <hr class="step-divider">

                    <div class="step-actions">
                        <button type="button" class="btn-prev" onclick="goToStep(2)">
                            <i class="fa-solid fa-chevron-left me-1 small"></i> Previous
                        </button>
                        <button type="button" class="btn-next" onclick="goToStep(4)">
                            Next <i class="fa-solid fa-chevron-right ms-1 small"></i>
                        </button>
                    </div>
                </div>

                <!-- STEP 4: SECURITY -->
                <div class="step-panel" id="stepPanel4">
                    <div class="step-hero-icon">
                        <i class="fa-solid fa-shield-halved"></i>
                    </div>
                    <div class="step-hero-title">Secure Your Account</div>
                    <p class="step-hero-subtitle">Create a strong password to protect your account</p>

                    <div class="mb-3">
                        <label class="form-label" for="password">Password *</label>
                        <div class="input-icon-group">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" class="custom-form-control" name="password" id="password" placeholder="••••••••" required minlength="6">
                            <i class="fa-regular fa-eye input-icon-right" onclick="toggleFieldMask('password', this)"></i>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="confirm_password">Confirm Password *</label>
                        <div class="input-icon-group">
                            <i class="fa-solid fa-lock input-icon-left"></i>
                            <input type="password" class="custom-form-control" name="confirm_password" id="confirm_password" placeholder="••••••••" required minlength="6">
                            <i class="fa-regular fa-eye input-icon-right" onclick="toggleFieldMask('confirm_password', this)"></i>
                        </div>
                    </div>

                    <div class="terms-checkbox-wrapper">
                        <input type="checkbox" name="terms" id="terms" required>
                        <label for="terms">
                            I agree to the <a href="javascript:void(0)" onclick="viewTerms()">Terms of Service</a> and <a href="javascript:void(0)" onclick="viewPrivacy()">Privacy Policy</a>
                        </label>
                    </div>

                    <hr class="step-divider">

                    <div class="step-actions">
                        <button type="button" class="btn-prev" onclick="goToStep(3)">
                            <i class="fa-solid fa-chevron-left me-1 small"></i> Previous
                        </button>
                        <button type="submit" class="btn-submit" id="submitBtn">
                            <i class="fa-solid fa-check me-1"></i> Create Account
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Footer Sign-in prompt -->
        <div class="auth-footer-links">
            Already have an account? <a href="<?= ROOT_URL ?>account">Sign In</a>
        </div>
    </div>

    <!-- JavaScript Dependencies -->
    <script src="<?= ROOT_URL ?>dashboard/assets/js/bootstrap.bundle.min.js"></script>
    <script src="<?= ROOT_URL ?>dashboard/assets/js/iziToast.js"></script>
    <script src="<?= ROOT_URL ?>assets/js/sweetalert2.all.min.js"></script>

    <script>
        let currentStep = 1;
        const totalSteps = 4;

        const progressPercent = {
            1: '25%',
            2: '50%',
            3: '75%',
            4: '100%'
        };

        function updateStepUI(step) {
            // Update counter text
            document.getElementById('stepCounterText').innerText = `Step ${step} of ${totalSteps}`;

            // Update progress bar
            document.getElementById('progressBar').style.width = progressPercent[step];

            // Update step labels
            for (let i = 1; i <= totalSteps; i++) {
                const label = document.getElementById(`labelStep${i}`);
                if (i <= step) {
                    label.classList.add('active');
                } else {
                    label.classList.remove('active');
                }
            }

            // Switch active panel
            for (let i = 1; i <= totalSteps; i++) {
                const panel = document.getElementById(`stepPanel${i}`);
                if (i === step) {
                    panel.classList.add('active');
                } else {
                    panel.classList.remove('active');
                }
            }

            currentStep = step;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function validateStep(step) {
            let isValid = true;
            let errorMessage = '';

            if (step === 1) {
                const firstname = document.getElementById('firstname');
                const lastname = document.getElementById('lastname');
                const username = document.getElementById('username');

                [firstname, lastname, username].forEach(el => el.classList.remove('is-invalid'));

                if (!firstname.value.trim()) {
                    firstname.classList.add('is-invalid');
                    errorMessage = 'Please enter your legal first name.';
                    isValid = false;
                } else if (!lastname.value.trim()) {
                    lastname.classList.add('is-invalid');
                    errorMessage = 'Please enter your legal last name.';
                    isValid = false;
                } else if (!username.value.trim()) {
                    username.classList.add('is-invalid');
                    errorMessage = 'Please enter your username.';
                    isValid = false;
                } else if (username.value.trim().length < 3) {
                    username.classList.add('is-invalid');
                    errorMessage = 'Username must be at least 3 characters long.';
                    isValid = false;
                }
            } else if (step === 2) {
                const email = document.getElementById('email');
                const phone = document.getElementById('phone');
                const country = document.getElementById('country');

                [email, phone, country].forEach(el => el.classList.remove('is-invalid'));

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email.value.trim() || !emailPattern.test(email.value.trim())) {
                    email.classList.add('is-invalid');
                    errorMessage = 'Please enter a valid email address.';
                    isValid = false;
                } else if (!phone.value.trim() || phone.value.trim().length < 7) {
                    phone.classList.add('is-invalid');
                    errorMessage = 'Please enter a valid phone number.';
                    isValid = false;
                } else if (!country.value.trim()) {
                    country.classList.add('is-invalid');
                    errorMessage = 'Please select your country.';
                    isValid = false;
                }
            } else if (step === 3) {
                const accountType = document.getElementById('selectedAccountType');
                const pin = document.getElementById('pin');

                pin.classList.remove('is-invalid');

                if (!accountType.value.trim()) {
                    errorMessage = 'Please choose an account type.';
                    isValid = false;
                } else if (!pin.value.trim() || !/^[0-9]{4}$/.test(pin.value.trim())) {
                    pin.classList.add('is-invalid');
                    errorMessage = 'Transaction PIN must be exactly 4 numeric digits.';
                    isValid = false;
                }
            } else if (step === 4) {
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('confirm_password');
                const terms = document.getElementById('terms');

                [password, confirmPassword].forEach(el => el.classList.remove('is-invalid'));

                if (!password.value || password.value.length < 6) {
                    password.classList.add('is-invalid');
                    errorMessage = 'Password must be at least 6 characters long.';
                    isValid = false;
                } else if (password.value !== confirmPassword.value) {
                    confirmPassword.classList.add('is-invalid');
                    errorMessage = 'Passwords do not match.';
                    isValid = false;
                } else if (!terms.checked) {
                    errorMessage = 'You must agree to the Terms of Service and Privacy Policy.';
                    isValid = false;
                }
            }

            if (!isValid && errorMessage) {
                iziToast.show({
                    title: 'Attention',
                    message: errorMessage,
                    position: 'topRight',
                    backgroundColor: '#ef4444',
                    messageColor: '#ffffff',
                    titleColor: '#ffffff',
                    timeout: 3500
                });
            }

            return isValid;
        }

        function goToStep(step) {
            // If going forward, validate current step
            if (step > currentStep) {
                if (!validateStep(currentStep)) {
                    return;
                }
            }
            updateStepUI(step);
        }

        function selectAccountType(element, typeName) {
            document.querySelectorAll('.account-type-card').forEach(card => {
                card.classList.remove('selected');
            });
            element.classList.add('selected');
            document.getElementById('selectedAccountType').value = typeName;
        }

        function toggleMoreAccounts() {
            const container = document.getElementById('moreAccountsContainer');
            const text = document.getElementById('moreAccountsText');
            const icon = document.getElementById('moreAccountsIcon');

            if (container.style.display === 'none' || container.style.display === '') {
                container.style.display = 'block';
                text.innerText = 'Hide additional account types';
                icon.classList.remove('fa-chevron-down');
                icon.classList.add('fa-chevron-up');
            } else {
                container.style.display = 'none';
                text.innerText = 'Show more account types';
                icon.classList.remove('fa-chevron-up');
                icon.classList.add('fa-chevron-down');
            }
        }

        function toggleFieldMask(fieldId, iconElement) {
            const field = document.getElementById(fieldId);
            if (field.type === 'password') {
                field.type = 'text';
                iconElement.classList.remove('fa-eye');
                iconElement.classList.add('fa-eye-slash');
            } else {
                field.type = 'password';
                iconElement.classList.remove('fa-eye-slash');
                iconElement.classList.add('fa-eye');
            }
        }

        function viewTerms() {
            Swal.fire({
                title: 'Terms of Service',
                text: 'By opening an account with <?= htmlspecialchars($companyName) ?>, you agree to comply with all applicable banking regulations, maintain the confidentiality of your security credentials, and use our financial services in accordance with our terms.',
                confirmButtonColor: '#0f172a'
            });
        }

        function viewPrivacy() {
            Swal.fire({
                title: 'Privacy Policy',
                text: 'Your privacy is paramount. <?= htmlspecialchars($companyName) ?> employs advanced 256-bit encryption and strict confidentiality measures to safeguard all personal and financial data.',
                confirmButtonColor: '#0f172a'
            });
        }

        // Form Submission
        document.getElementById('multiStepForm').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!validateStep(4)) {
                return;
            }

            const submitBtn = document.getElementById('submitBtn');
            const originalHtml = submitBtn.innerHTML;

            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status"></span> Creating Account...';

            const formData = new FormData(this);

            fetch('<?= ROOT_URL ?>backend/account/register.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.text())
            .then(raw => {
                const response = raw.trim();
                console.log('Registration response:', response);

                if (response === 'otp_sent') {
                    iziToast.show({
                        title: 'Success',
                        message: 'Account created! An activation OTP has been sent to your email.',
                        position: 'topRight',
                        backgroundColor: '#10b981',
                        messageColor: '#ffffff',
                        titleColor: '#ffffff',
                        timeout: 3000
                    });

                    submitBtn.innerHTML = '<i class="fa-solid fa-check me-1"></i> Redirecting...';
                    setTimeout(() => {
                        window.location.href = '<?= ROOT_URL ?>account/verify_otp.php';
                    }, 1200);
                } else if (response === 'success') {
                    iziToast.show({
                        title: 'Welcome',
                        message: 'Registration successful! Redirecting to dashboard...',
                        position: 'topRight',
                        backgroundColor: '#10b981',
                        messageColor: '#ffffff',
                        titleColor: '#ffffff',
                        timeout: 2500
                    });

                    setTimeout(() => {
                        window.location.href = '<?= ROOT_URL ?>dashboard/user';
                    }, 1200);
                } else {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalHtml;

                    let displayError = response;
                    try {
                        const parsed = JSON.parse(response);
                        if (parsed.error) displayError = parsed.error;
                    } catch (err) {}

                    iziToast.show({
                        title: 'Registration Failed',
                        message: displayError || 'An unexpected error occurred. Please try again.',
                        position: 'topRight',
                        backgroundColor: '#ef4444',
                        messageColor: '#ffffff',
                        titleColor: '#ffffff',
                        timeout: 4500
                    });
                }
            })
            .catch(err => {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalHtml;
                console.error(err);

                iziToast.show({
                    title: 'Network Error',
                    message: 'Could not connect to the server. Please check your internet connection.',
                    position: 'topRight',
                    backgroundColor: '#ef4444',
                    messageColor: '#ffffff',
                    titleColor: '#ffffff',
                    timeout: 4500
                });
            });
        });
    </script>
</body>

</html>