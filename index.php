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
            <form action="backend/reg.php" method="post" class="signup-form" id="signupForm" >
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign up</button>
            </form>
            <form action="backend/login.php" method="post" class="login-form" id="loginForm" style="display:none;">
                <input type="email" name="email" placeholder="login Email" required>
                <input type="password" name="password" placeholder="login Password" required>
                <button type="submit">Log in</button>
            </form>
            <p class="terms">By continuing, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
        </main>
    </div>
    <script src="navbar.js"></script>
    <script>
// Show signup error popup if error=exists in URL
window.addEventListener('DOMContentLoaded', function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('error') === 'exists') {
        document.getElementById('signupErrorPopup').style.display = 'flex';
    }
    const closeSignupError = document.getElementById('closeSignupError');
    if (closeSignupError) {
        closeSignupError.addEventListener('click', function() {
            document.getElementById('signupErrorPopup').style.display = 'none';
            // Remove error from URL
            const url = new URL(window.location);
            url.searchParams.delete('error');
            window.history.replaceState({}, document.title, url.pathname);
        });
    }
});
// Tuition Info Popup
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


const signupForm = document.getElementById('signupForm');
const loginForm = document.getElementById('loginForm');
const signupBtn = document.getElementById('signupBtn');
const loginBtn = document.getElementById('loginBtn');
signupBtn.addEventListener('click', function(e) {
    e.preventDefault();
    signupBtn.classList.add('active');
    loginBtn.classList.remove('active');
    signupForm.style.display = '';
    loginForm.style.display = 'none';
});
loginBtn.addEventListener('click', function(e) {
    e.preventDefault();
    loginBtn.classList.add('active');
    signupBtn.classList.remove('active');
    signupForm.style.display = 'none';
    loginForm.style.display = '';
});
</script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('showLogin') === '1') {
        // Simulate clicking the login button to show the login form
        const loginBtn = document.getElementById('loginBtn');
        if (loginBtn) loginBtn.click();
    }
});
</script>
</body>
</html>
