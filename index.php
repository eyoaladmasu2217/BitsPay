<?php require_once 'backend/config/security_headers.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitsPay - Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="video-overlay"></div>
    <video autoplay loop muted playsinline class="bg-video">
        <source src="background vid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container auth-container">
        <div class="floating-navbar">
            <div class="logo">
                <div class="bits">Bits</div><div class="pay">Pay</div>
            </div>
            <nav>
                <a href="#" class="signup active" id="signupBtn">Sign up</a>
                <a href="#" class="login" id="loginBtn">Log in</a>
            </nav>
        </div>
        <main class="auth-main">
            <div class="auth-card">
                <h1 id="authTitle">Create your account</h1>
                <p class="auth-subtitle" id="authSubtitle">Join BitsPay and manage your campus payments effortlessly.</p>
                <div class="auth-divider"></div>
                <div id="errorPopup" class="popup-overlay" style="display:none;">
                    <div class="popup-modal">
                        <button class="close-btn" id="closeError" aria-label="Close">&times;</button>
                        <h2>Error</h2>
                        <p id="errorMessage">An error occurred.</p>
                    </div>
                </div>
                <form action="backend/reg.php" method="post" class="signup-form" id="signupForm">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Create Password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="auth-btn">Sign up</button>
                    </div>
                </form>
                <form action="backend/login.php" method="post" class="login-form" id="loginForm" style="display:none;">
                    <div class="form-group">
                        <input type="email" name="email" placeholder="Email Address" required>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="auth-btn">Log in</button>
                    </div>
                </form>
                <p class="terms">By continuing, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
            </div>
        </main>
    </div>
    <script src="navbar.js"></script>
    <script>
window.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);

    // Show error popup if needed
    const error = params.get('error');
    if (error) {
        const errorPopup = document.getElementById('errorPopup');
        const errorMsg = document.getElementById('errorMessage');
        if (error === 'exists') {
            errorMsg.textContent = 'Account already exists. Please log in.';
        } else if (error === 'invalid') {
            errorMsg.textContent = 'Invalid email or password.';
        } else if (error === 'notfound') {
            errorMsg.textContent = 'No account found with this email.';
        } else if (error === 'password_weak') {
            errorMsg.textContent = 'Password must be at least 8 characters long and contain at least one number.';
        } else if (error === 'invalid_email') {
            errorMsg.textContent = 'Please enter a valid email address.';
        }
        errorPopup.style.display = 'flex';
    }

    // Elements
    const signupBtn = document.getElementById('signupBtn');
    const loginBtn = document.getElementById('loginBtn');
    const signupForm = document.getElementById('signupForm');
    const loginForm = document.getElementById('loginForm');

    // Helper to switch forms and button styles
    function showForm(form) {
        const authTitle = document.getElementById('authTitle');
        const authSubtitle = document.getElementById('authSubtitle');
        if (form === 'signup') {
            signupForm.style.display = 'flex';
            loginForm.style.display = 'none';
            signupBtn.classList.add('active');
            loginBtn.classList.remove('active');
            if (authTitle) authTitle.textContent = 'Create your account';
            if (authSubtitle) authSubtitle.textContent = 'Join BitsPay and manage your campus payments effortlessly.';
        } else {
            signupForm.style.display = 'none';
            loginForm.style.display = 'flex';
            signupBtn.classList.remove('active');
            loginBtn.classList.add('active');
            if (authTitle) authTitle.textContent = 'Welcome back';
            if (authSubtitle) authSubtitle.textContent = 'Sign in to your BitsPay account.';
        }
    }

    // Initial state: show login if showLogin=1, else signup
    if (params.get('showLogin') === '1') {
        showForm('login');
    } else {
        showForm('signup');
    }

    // Navbar button click handlers
    signupBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showForm('signup');
    });
    loginBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showForm('login');
    });

    // Error popup close
    const closeError = document.getElementById('closeError');
    if (closeError) {
        closeError.addEventListener('click', function() {
            document.getElementById('errorPopup').style.display = 'none';
            // Remove error from URL
            const url = new URL(window.location);
            url.searchParams.delete('error');
            window.history.replaceState({}, document.title, url.pathname);
        });
    }
});
    </script>

</body>
</html>
