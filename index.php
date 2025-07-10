<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BitsPay - Sign Up</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <video autoplay loop muted playsinline class="bg-video">
        <source src="background vid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container">
        <div class="floating-navbar">
            <div class="logo">
                <div class="bits">Bits</div><div class="pay">Pay</div>
            </div>
            <nav>
                <a href="#" class="signup active" id="signupBtn">Sign up</a>
                <a href="#" class="login" id="loginBtn">Log in</a>
            </nav>
        </div>
        <main>
            <h1>Get started with BITS-PAY</h1>
            <div id="signupErrorPopup" class="popup-overlay" style="display:none;">
                <div class="popup-modal">
                    <button class="close-btn" id="closeSignupError" aria-label="Close">&times;</button>
                    <h2>Error</h2>
                    <p>User already exists.</p>
                </div>
            </div>
            <form action="backend/reg.php" method="post" class="signup-form" id="signupForm">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="auth-btn">Sign up</button>
                </div>
            </form>
            <form action="backend/login.php" method="post" class="login-form" id="loginForm" style="display:none;">
                <div class="form-group">
                    <input type="email" name="email" placeholder="login Email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="login Password" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="auth-btn">Log in</button>
                </div>
            </form>
            <p class="terms">By continuing, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
        </main>
    </div>
    <script src="navbar.js"></script>
    <script>
window.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);

    // Show error popup if needed
    if (params.get('error') === 'exists') {
        document.getElementById('signupErrorPopup').style.display = 'flex';
    }

    
    const signupBtn = document.getElementById('signupBtn');
    const loginBtn = document.getElementById('loginBtn');
    const signupForm = document.getElementById('signupForm');
    const loginForm = document.getElementById('loginForm');

    function showForm(form) {
        if (form === 'signup') {
            signupForm.style.display = 'block';
            loginForm.style.display = 'none';
            signupBtn.classList.add('active');
            loginBtn.classList.remove('active');
        } else {
            signupForm.style.display = 'none';
            loginForm.style.display = 'block';
            signupBtn.classList.remove('active');
            loginBtn.classList.add('active');
        }
    }

    
    if (params.get('showLogin') === '1') {
        showForm('login');
    } else {
        showForm('signup');
    }

    signupBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showForm('signup');
    });
    loginBtn.addEventListener('click', function(e) {
        e.preventDefault();
        showForm('login');
    });

    const closeSignupError = document.getElementById('closeSignupError');
    if (closeSignupError) {
        closeSignupError.addEventListener('click', function() {
            document.getElementById('signupErrorPopup').style.display = 'none';
            /
            const url = new URL(window.location);
            url.searchParams.delete('error');
            window.history.replaceState({}, document.title, url.pathname);
        });
    }

  
    const tuitionBtn = document.querySelector('.tuition-info');
    const popup = document.getElementById('tuitionPopup');
    const closePopup = document.getElementById('closePopup');
    tuitionBtn.addEventListener('click', function(e) {
        e.preventDefault();
        popup.style.display = 'flex';
    });
    closePopup.addEventListener('click', function() {
        popup.style.display = 'none';
    });
    window.addEventListener('click', function(e) {
        if (e.target === popup) popup.style.display = 'none';
    });
});
    </script>

