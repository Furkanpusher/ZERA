<?php
require_once __DIR__ . '/config/db.php';
date_default_timezone_set('Europe/Istanbul'); // veya sunucuna uygun bir timezone
$register_success = false;
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"])) {
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];
    $password_confirm = $_POST["password_confirm"];
    $store_url = isset($_POST["storeUrl"]) ? trim($_POST["storeUrl"]) : null;

    // Şifreler aynı mı kontrol et
    if ($password !== $password_confirm) {
        $error_message = "Passwords do not match!";
    } elseif (strlen($password) < 6) {
        $error_message = "Password must be at least 6 characters.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users(name, email, password_hash, shopify_store_url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $hashed_password, $store_url);

        if ($stmt->execute()) {
            $register_success = true;
        } else {
            $error_message = "Registration failed. Email may already be in use.";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - Zera</title>
    <link rel="stylesheet" href="css/auth.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="logo">
                <h1>Zera</h1>
                <p>Supplement Store Builder</p>
            </div>
            <div class="auth-header">
                <h2>Sign Up</h2>
                <p>Start your free trial</p>
            </div>

            <?php if ($register_success): ?>
                <div class="success-message" id = "successMsg">
                    🎉 Registration successful! You can now <a href="index.php">sign in</a>.
                </div>
            <?php elseif ($error_message): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <form class="auth-form" method="post" action="register.php">
                <div class="form-group">
                    <label for="registerName">Full Name</label>
                    <input type="text" id="registerName" name="name" required>
                </div>
                <div class="form-group">
                    <label for="registerEmail">Email Address</label>
                    <input type="email" id="registerEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="registerPassword">Password</label>
                    <input type="password" id="registerPassword" name="password" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="registerPasswordConfirm">Confirm Password</label>
                    <input type="password" id="registerPasswordConfirm" name="password_confirm" required minlength="6">
                </div>
                <div class="form-group">
                    <label for="storeUrl">Shopify Store URL (Optional)</label>
                    <input type="url" id="storeUrl" name="storeUrl" placeholder="store-name.myshopify.com">
                </div>
                <button type="submit" class="cta-button">Register</button>
            </form>
            <div class="auth-switch">
                Already have an account? <a href="auth.php">Sign In</a>
            </div>
        </div>
    </div>
    <script src="js/auth.js"></script>
</body>

</html>