<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
date_default_timezone_set('Europe/Istanbul'); // veya sunucuna uygun bir timezone
error_reporting(E_ALL);
require_once __DIR__ . '/config/db.php';
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["email"])) {
    // form gönderildi ve email alanı doluysa devam et
    $login_email= trim($_POST["email"]);
    $login_password = $_POST["password"];
    $sql = "SELECT password_hash FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $login_email);   
    $stmt->execute();
    $stmt->bind_result($password_hash);
    $stmt->fetch();
    $stmt->close();
    
    if ($password_hash && password_verify($login_password, $password_hash)) {
        // Eğer öyle bir şifre varsa ve şifre doğrulaması başarılıysa
        // Giriş başarılı, kullanıcıyı yönlendircem
        session_start();
        $_SESSION['email'] = $login_email;  // oturumda email saklanıyor
        header("Location: index.php");  // giriş başarılıysa anasayfaya yönlendir
        exit();
    } else {
        // Giriş başarısız, hata mesajı göster
        $error_message = "Invalid email or password.";
    }
}
    
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Zera</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/auth.css">
</head>

<body id="auth-body">
    <a href="index.php" class="back-home">Home</a>
    
    <div class="auth-container">
        <!-- Login Page -->
        <div class="page-login">
            <div class="auth-card">
                <div class="logo">
                    <h1>Zera</h1>
                    <p>Supplement Store Builder</p>
                </div>
                
                <div class="auth-header">
                    <h2>Welcome Back!</h2>
                    <p>Sign in to your account and continue managing your store</p>
                </div>
                <?php if (!empty($error_message)): ?>
                    <div class="error-message">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>

                <form class="auth-form" id="loginForm" method = "POST" action = "auth.php">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" id="loginEmail" name="email" placeholder="example@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                    </div>
                    
                    <div class="forgot-password">
                        <a href="forgot.php">Forgot Password?</a>
                    </div>

                    <button type="submit" class="cta-button">Sign In</button>
                    
                    <div class="auth-divider">
                        <span>or</span>
                    </div>
                    
                    <button type="button" class="google-btn">
                        Continue with Google
                    </button>
                </form>

                <div class="auth-switch">
                    Don't have an account? <a href="register.php" onclick="togglePage()">Sign Up</a>
                </div>
            </div>
        </div>
    </div>


       
    <script src="js/auth.js"></script>
</body>
</html>