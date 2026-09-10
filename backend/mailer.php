<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/PHPMailer/Exception.php';
require_once __DIR__ . '/PHPMailer/PHPMailer.php';
require_once __DIR__ . '/PHPMailer/SMTP.php';

/**
 * Sends an email using PHPMailer and the SMTP config defined in config.php
 *
 * @param string $to Recipient email address
 * @param string $subject Subject of the email
 * @param string $htmlContent HTML body of the email
 * @param string $altBody Plain text alternative
 * @return bool True if email was sent successfully, false otherwise
 */
function send_email($to, $subject, $htmlContent, $altBody = '') {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = defined('SMTP_HOST') ? SMTP_HOST : 'smtp.gmail.com';
        $mail->SMTPAuth   = defined('SMTP_AUTH') ? SMTP_AUTH : true;
        if ($mail->SMTPAuth) {
            $mail->Username   = defined('SMTP_USERNAME') ? SMTP_USERNAME : '';
            $mail->Password   = defined('SMTP_PASSWORD') ? SMTP_PASSWORD : '';
            $mail->SMTPSecure = defined('SMTP_SECURE') ? SMTP_SECURE : 'tls';
            $mail->Port       = defined('SMTP_PORT') ? SMTP_PORT : 587;
        }

        // Timeout settings
        $mail->Timeout = 15;

        // Recipients
        $fromEmail = defined('SMTP_FROM_EMAIL') ? SMTP_FROM_EMAIL : 'support@premiumcheckings.com';
        $fromName  = defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'Premium Checkings';
        
        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $htmlContent;
        $mail->AltBody = !empty($altBody) ? $altBody : strip_tags(str_replace(['<br>', '<br/>', '<br />', '</p>'], "\n", $htmlContent));

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("PHPMailer Error: {$mail->ErrorInfo} | Exception: " . $e->getMessage());
        return false;
    }
}

/**
 * Sends an account activation OTP code email using PHPMailer
 *
 * @param string $toEmail Recipient email address
 * @param string $toName Recipient name
 * @param string $otpCode 6-digit OTP code
 * @return bool True if sent, false otherwise
 */
function send_otp_email($toEmail, $toName, $otpCode) {
    $companyName = defined('SMTP_FROM_NAME') ? SMTP_FROM_NAME : 'Premium Checkings';
    $year = date('Y');

    $subject = "Your {$companyName} Account Activation Code: {$otpCode}";

    $html = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Activation</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f7fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: #333333;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f4f7fa; padding: 40px 10px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" max-width="600" cellspacing="0" cellpadding="0" border="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);">
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0d6efd 0%, #0043a8 100%); padding: 36px 30px; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 26px; font-weight: 700; letter-spacing: 0.5px;">{$companyName}</h1>
                            <p style="color: #dbe7ff; margin: 6px 0 0 0; font-size: 14px;">Secure Online Banking</p>
                        </td>
                    </tr>
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 35px 30px 35px;">
                            <h2 style="color: #1a202c; font-size: 20px; font-weight: 600; margin: 0 0 16px 0;">Verify Your Email Address</h2>
                            <p style="font-size: 15px; line-height: 1.6; color: #4a5568; margin: 0 0 20px 0;">
                                Hello <strong>{$toName}</strong>,
                            </p>
                            <p style="font-size: 15px; line-height: 1.6; color: #4a5568; margin: 0 0 25px 0;">
                                Thank you for creating an account with <strong>{$companyName}</strong>. To complete your registration and activate your online banking account, please enter the one-time verification code below:
                            </p>
                            <!-- OTP Box -->
                            <div style="text-align: center; margin: 30px 0;">
                                <div style="display: inline-block; background: #f0f5ff; border: 2px dashed #0d6efd; border-radius: 10px; padding: 18px 36px; text-align: center;">
                                    <span style="font-size: 36px; font-weight: 800; color: #0d6efd; letter-spacing: 8px; font-family: 'Courier New', Courier, monospace;">{$otpCode}</span>
                                </div>
                                <p style="font-size: 13px; color: #718096; margin: 12px 0 0 0;">
                                    This code is valid for <strong>15 minutes</strong>.
                                </p>
                            </div>
                            <p style="font-size: 14px; line-height: 1.6; color: #718096; margin: 25px 0 0 0; padding-top: 20px; border-top: 1px solid #edf2f7;">
                                If you did not create an account with {$companyName}, please disregard this email or contact support if you suspect unauthorized activity.
                            </p>
                        </td>
                    </tr>
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 24px 30px; text-align: center; border-top: 1px solid #edf2f7;">
                            <p style="font-size: 12px; color: #a0aec0; margin: 0 0 6px 0;">
                                &copy; {$year} {$companyName}. All rights reserved.
                            </p>
                            <p style="font-size: 11px; color: #cbd5e0; margin: 0;">
                                This is an automated security message. Please do not reply directly to this email.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;

    $altBody = "Hello {$toName},\n\nThank you for creating an account with {$companyName}.\n\nYour account activation code is: {$otpCode}\n\nThis code will expire in 15 minutes.\n\nIf you did not initiate this request, please ignore this email.\n\n{$companyName} Team";

    return send_email($toEmail, $subject, $html, $altBody);
}
