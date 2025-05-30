<?php
session_start();
date_default_timezone_set('Europe/Istanbul');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once __DIR__ . '/config/db.php';
require_once __DIR__ . '/vendor/autoload.php';

$success_message = '';
$error_message = '';

// Session'dan verileri al
$step = $_SESSION['reset_step'] ?? 1;
$forgot_email = $_SESSION['reset_email'] ?? '';
$reset_code = $_SESSION['reset_code'] ?? '';
$user_id = $_SESSION['reset_user_id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Adım: E-posta ile kod gönderme
    if (isset($_POST["forgot_email"])) {
        $forgot_email = trim($_POST["forgot_email"]);
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $forgot_email);
        $stmt->execute();
        $stmt->bind_result($user_id);
        $stmt->fetch();
        $stmt->close();

        if (!empty($user_id)) {
            $reset_number = strval(rand(100000, 999999));
            $expires_at = date("Y-m-d H:i:s", time() + 600); // 10 dakika

            // Eski kodları sil
            $conn->query("DELETE FROM password_resets WHERE user_id = $user_id");

            $insert = $conn->prepare("INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)");
            $insert->bind_param("iss", $user_id, $reset_number, $expires_at);
            $insert->execute();
            $insert->close();

            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ffurkan.senol@gmail.com';
                $mail->Password = 'bvww cwsf ukzw zrvr';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('ffurkan.senol@gmail.com', 'Zera');
                $mail->addAddress($forgot_email);

                $mail->isHTML(true);
                $mail->Subject = 'Password Reset Request';
                $mail->Body = "Your reset code: <b>$reset_number</b>";

                $mail->send();
                $success_message = "A password reset code has been sent to your email.";

                // Session'a kaydet
                $_SESSION['reset_step'] = 2;
                $_SESSION['reset_email'] = $forgot_email;
                $_SESSION['reset_user_id'] = $user_id;
                $step = 2;
            } catch (Exception $e) {
                $error_message = "Mail could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $error_message = "Email address not found.";
        }
    }

    // 2. Adım: Kod doğrulama
    elseif (isset($_POST["reset_code"])) {
        $input_code = trim($_POST["reset_code"]);
        $forgot_email = $_SESSION['reset_email'] ?? '';
        $user_id = $_SESSION['reset_user_id'] ?? null;

        if (!empty($user_id) && !empty($forgot_email)) {
            $now = date("Y-m-d H:i:s");
            $check = $conn->prepare("SELECT id FROM password_resets WHERE user_id = ? AND token = ? AND expires_at > ? AND used_at IS NULL");
            $check->bind_param("iss", $user_id, $input_code, $now);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $success_message = "Code verified! Please enter your new password.";

                // Session'a kaydet
                $_SESSION['reset_step'] = 3;
                $_SESSION['reset_code'] = $input_code;
                $step = 3;
                $reset_code = $input_code;
            } else {
                $error_message = "Invalid or expired code.";
                $step = 2;
            }
            $check->close();
        } else {
            $error_message = "Invalid request.";
        }
    }

    // 3. Adım: Yeni şifre belirleme
    elseif (isset($_POST["new_password"], $_POST["confirm_password"])) {
        $new_password = trim($_POST["new_password"]);
        $confirm_password = trim($_POST["confirm_password"]);

        // Session'dan verileri al
        $forgot_email = $_SESSION['reset_email'] ?? '';
        $reset_code = $_SESSION['reset_code'] ?? '';
        $user_id = $_SESSION['reset_user_id'] ?? null;

        if (empty($new_password) || empty($confirm_password)) {
            $error_message = "Please fill in both password fields.";
            $step = 3;
        } elseif ($new_password !== $confirm_password) {
            $error_message = "Passwords do not match.";
            $step = 3;
        } elseif (strlen($new_password) < 6) {
            $error_message = "Password must be at least 6 characters.";
            $step = 3;
        } elseif (empty($user_id) || empty($reset_code)) {
            $error_message = "Session expired. Please start over.";
            $step = 1;
            // Session temizle
            unset($_SESSION['reset_step'], $_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['reset_user_id']);
        } else {
            $now = date("Y-m-d H:i:s");
            $check = $conn->prepare("SELECT id FROM password_resets WHERE user_id = ? AND token = ? AND expires_at > ? AND used_at IS NULL");
            $check->bind_param("iss", $user_id, $reset_code, $now);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update = $conn->prepare("UPDATE users SET password_hash = ? WHERE id = ?");
                $update->bind_param("si", $hashed_password, $user_id);

                if ($update->execute()) {
                    // Token'ı kullanılmış olarak işaretle
                    $mark_used = $conn->prepare("UPDATE password_resets SET used_at = NOW() WHERE user_id = ? AND token = ?");
                    $mark_used->bind_param("is", $user_id, $reset_code);
                    $mark_used->execute();
                    $mark_used->close();

                    $success_message = "Your password has been successfully updated. You will be redirected to the login page in a few seconds...";
                    $step = 4;

                    // Session temizle
                    unset($_SESSION['reset_step'], $_SESSION['reset_email'], $_SESSION['reset_code'], $_SESSION['reset_user_id']);
                } else {
                    $error_message = "An error occurred while updating your password: " . $update->error;
                    $step = 3;
                }
                $update->close();
            } else {
                $error_message = "Invalid or expired code.";
                $step = 3;
            }
            $check->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Forgot Password - Zera</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body id="auth-body">
    <a href="auth.php" class="back-home">Back to Login</a>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo">
                <h1>Zera</h1>
                <p>Supplement Store Builder</p>
            </div>
            <div class="auth-header">
                <h2>Forgot Password</h2>
                <p>Reset your password in three easy steps.</p>
            </div>
            
            <?php if ($success_message): ?>
                <div class="success-message"><?= htmlspecialchars($success_message) ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>

            <?php if ($step === 1): ?>
                <!-- E-posta formu -->
                <form class="auth-form" method="post" action="forgot.php">
                    <div class="form-group">
                        <label for="forgotEmail">Email Address</label>
                        <input type="email" id="forgotEmail" name="forgot_email" placeholder="example@email.com" required>
                    </div>
                    <button type="submit" class="cta-button">Send Reset Code</button>
                </form>
                
            <?php elseif ($step === 2): ?>
                <!-- Kod doğrulama formu -->
                <form class="auth-form" method="post" action="forgot.php">
                    <div class="form-group">
                        <label for="resetCode">Enter the code sent to your email</label>
                        <input type="text" id="resetCode" name="reset_code" placeholder="6-digit code" required>
                    </div>
                    <button type="submit" class="cta-button">Verify Code</button>
                </form>
                
            <?php elseif ($step === 3): ?>
                <!-- Yeni şifre belirleme formu -->
                <form class="auth-form" method="post" action="forgot.php">
                    <div class="form-group">
                        <label for="newPassword">New Password</label>
                        <input type="password" id="newPassword" name="new_password" required minlength="6">
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword">Confirm New Password</label>
                        <input type="password" id="confirmPassword" name="confirm_password" required minlength="6">
                    </div>
                    <button type="submit" class="cta-button">Change Password</button>
                </form>
                
            <?php elseif ($step === 4): ?>
                <!-- Başarılı mesaj ve yönlendirme -->
                <div class="success-message">
                    <h3>✅ Password Changed Successfully!</h3>
                    <p>Your password has been successfully updated. You will be redirected to the login page in a few seconds...</p>
                </div>
                <script>
                    setTimeout(function(){ window.location.href = "auth.php"; }, 3000);
                </script>
                
            <?php else: ?>
                <div class="error-message">
                    An unexpected error occurred. Please <a href="forgot.php">try again</a>.
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
