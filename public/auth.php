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
    <a href="/" class="back-home">Home</a>
    
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

                <form class="auth-form" id="loginForm">
                    <div class="form-group">
                        <label for="loginEmail">Email Address</label>
                        <input type="email" id="loginEmail" name="email" placeholder="example@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="loginPassword">Password</label>
                        <input type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                    </div>
                    
                    <div class="forgot-password">
                        <a href="#forgot">Forgot Password?</a>
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
                    Don’t have an account? <a href="#" onclick="togglePage()">Start a Free Trial</a>
                </div>
            </div>
        </div>

        <!-- Register Page -->
        <div class="page-register">
            <div class="auth-card">
                <div class="logo">
                    <h1>Zera</h1>
                    <p>Supplement Store Builder</p>
                </div>
                
                <div class="auth-header">
                    <h2>Free Trial<span class="trial-badge">14 Days</span></h2>
                    <p>Launch your supplement store in minutes</p>
                </div>

                <div class="features-preview">
                    <h4>What’s Included:</h4>
                    <ul class="features-list">
                        <li>5+ Premium Themes</li>
                        <li>20+ Custom Sections</li>
                        <li>Mobile Optimized</li>
                        <li>FDA Compliant</li>
                        <li>24/7 Support</li>
                        <li>Easy Setup</li>
                    </ul>
                </div>

                <form class="auth-form" id="registerForm">
                    <div class="form-group">
                        <label for="registerName">Full Name</label>
                        <input type="text" id="registerName" name="name" placeholder="Your Full Name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registerEmail">Email Address</label>
                        <input type="email" id="registerEmail" name="email" placeholder="example@email.com" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="registerPassword">Password</label>
                        <input type="password" id="registerPassword" name="password" placeholder="At least 6 characters" required minlength="6">
                    </div>
                    
                    <div class="form-group">
                        <label for="storeUrl">Shopify Store URL (Optional)</label>
                        <input type="url" id="storeUrl" name="storeUrl" placeholder="store-name.myshopify.com">
                    </div>

                    <button type="submit" class="cta-button">Start 14-Day Free Trial</button>
                    
                    <div class="auth-divider">
                        <span>or</span>
                    </div>
                    
                    <button type="button" class="google-btn">
                        Continue with Google
                    </button>
                </form>

                <div class="auth-switch">
                    Already have an account? <a href="#" onclick="togglePage()">Sign In</a>
                </div>
            </div>
        </div>
    </div>


       
    <script src="js/auth.js"></script>
</body>
</html>