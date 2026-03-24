<?php require_once 'backend/config/security_headers.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="BitsPay - The ultimate platform for secure and effortless campus payments. Join our community today.">
    <meta name="keywords" content="BitsPay, Campus Payments, Secure Transactions, Student Finance">
    <title>BitsPay - Sign Up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="theme.js" defer></script>
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
            <div class="theme-switch-wrapper">
                <label class="theme-switch" for="checkbox">
                    <input type="checkbox" id="checkbox" />
                    <div class="slider round">
                        <span class="icon dark-icon">🌙</span>
                        <span class="icon light-icon">☀️</span>
                    </div>
                </label>
            </div>
        </div>
        <main class="auth-main">
            <div class="auth-card">
                <span class="auth-hero-badge"><span class="badge-dot"></span>Secure Campus Payments</span>
                <h1 id="authTitle">Create your account</h1>
                <p class="auth-subtitle" id="authSubtitle">Join BitsPay and manage your campus payments effortlessly.</p>
                <div class="auth-divider"></div>
                <div id="forgotPwPopup" class="popup-overlay" style="display:none;">
                    <div class="popup-modal">
                        <button class="close-btn" id="closeForgot" aria-label="Close">&times;</button>
                        <span class="popup-icon">🔑</span>
                        <h2>Reset Password</h2>
                        <p>Enter your email to receive a reset link.</p>
                        <div class="form-group floating-label-group" style="margin-top: 20px;">
                            <input type="email" id="resetEmail" placeholder=" ">
                            <label class="fl-label" for="resetEmail">Email Address</label>
                        </div>
                        <button class="auth-btn" style="margin-top: 10px;" onclick="showToast('Success!', 'Reset link sent!', 'info')">Send Reset Link</button>
                    </div>
                </div>

                <div id="errorPopup" class="popup-overlay" style="display:none;">
                    <div class="popup-modal">
                        <button class="close-btn" id="closeError" aria-label="Close">&times;</button>
                        <span class="popup-icon">⚠️</span>
                        <h2>Oops!</h2>
                        <p id="errorMessage">An error occurred.</p>
                    </div>
                </div>


                <form action="backend/reg.php" method="post" class="signup-form" id="signupForm">
                    <div class="form-group floating-label-group">
                        <input type="email" name="email" id="signupEmail" placeholder=" " required>
                        <label class="fl-label" for="signupEmail">Email Address</label>
                    </div>
                    <div class="form-group">
                        <div class="pw-toggle-wrap">
                            <input type="password" name="password" id="signupPw" placeholder=" " required oninput="checkStrength(this.value)">
                            <label class="fl-label" for="signupPw">Password</label>
                            <button type="button" class="pw-toggle-btn" aria-label="Show password" onclick="togglePw('signupPw', this)">👁️</button>
                        </div>
                        <div class="strength-meter-wrap">
                            <div class="strength-meter"><div class="strength-bar" id="strengthBar"></div></div>
                            <span class="strength-text" id="strengthText">Weak</span>
                        </div>
                    </div>
                    <div class="form-group floating-label-group">
                        <div class="pw-toggle-wrap">
                            <input type="password" name="confirm_password" id="signupPwConfirm" placeholder=" " required>
                            <label class="fl-label" for="signupPwConfirm">Confirm Password</label>
                            <button type="button" class="pw-toggle-btn" aria-label="Show password" onclick="togglePw('signupPwConfirm', this)">👁️</button>
                        </div>
                        <span class="error-text" id="matchText" style="display:none; color: #d32f2f; font-size: 0.75rem; margin-top: 4px;">Passwords do not match</span>
                    </div>

                    <div class="form-group">
                        <button type="submit" class="auth-btn" onclick="showLoading(this)">Sign up</button>
                    </div>
                </form>
                <form action="backend/login.php" method="post" class="login-form" id="loginForm" style="display:none;">
                    <div class="form-group floating-label-group">
                        <input type="email" name="email" id="loginEmail" placeholder=" " required>
                        <label class="fl-label" for="loginEmail">Email Address</label>
                    </div>
                    <div class="form-group">
                        <div class="pw-toggle-wrap">
                            <input type="password" name="password" id="loginPw" placeholder=" " required>
                            <button type="button" class="pw-toggle-btn" aria-label="Show password" onclick="togglePw('loginPw', this)">👁️</button>
                        </div>
                    </div>
                    <div class="form-options">
                        <label class="remember-me"><input type="checkbox" name="remember"> Remember me</label>
                        <a href="#" class="forgot-pw">Forgot password?</a>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="auth-btn" onclick="showLoading(this)">Log in</button>
                    </div>
                </form>
                <div class="social-auth">
                    <div class="social-divider"><span>Or continue with</span></div>
                    <div class="social-icons">
                        <button class="social-btn" aria-label="Google"><img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google"></button>
                        <button class="social-btn" aria-label="Apple"><img src="https://www.svgrepo.com/show/511330/apple-173.svg" alt="Apple"></button>
                        <button class="social-btn" aria-label="GitHub"><img src="https://www.svgrepo.com/show/512317/github-142.svg" alt="GitHub"></button>
                    </div>
                </div>
                <p class="terms">By continuing, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>

            </div>
        </main>
    </div>
    <div id="toast-container"></div>

    <div id="cookieBanner" class="cookie-banner" style="display:none;">
        <div class="cookie-content">
            <span class="cookie-icon">🍪</span>
            <p>We use cookies to ensure you get the best experience on BitsPay. <a href="#">Learn more</a></p>
            <button id="acceptCookies" class="cookie-btn">Accept</button>
        </div>
    </div>

    <button id="backToTop" class="back-to-top" aria-label="Back to Top">↑</button>

    <script src="navbar.js"></script>


    <script>
    function togglePw(inputId, btn) {
        const inp = document.getElementById(inputId);
        if (inp.type === 'password') {
            inp.type = 'text';
            btn.textContent = '🙈';
        } else {
            inp.type = 'password';
            btn.textContent = '👁️';
        }
    }

    // Real-time password match check
    document.addEventListener('DOMContentLoaded', () => {
        const pw = document.getElementById('signupPw');
        const confirm = document.getElementById('signupPwConfirm');
        const matchTxt = document.getElementById('matchText');

        if(pw && confirm) {
            confirm.addEventListener('input', () => {
                if(confirm.value === '') {
                    matchTxt.style.display = 'none';
                } else if(pw.value === confirm.value) {
                    matchTxt.style.display = 'none';
                    confirm.style.borderColor = '#4CAF50';
                } else {
                    matchTxt.style.display = 'block';
                    confirm.style.borderColor = '#d32f2f';
                }
            });
        }

        // Real-time email validation
        const signupEmail = document.getElementById('signupEmail');
        const loginEmail = document.getElementById('loginEmail');
        const validateEmail = (input) => {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if(input.value === '') {
                input.style.borderColor = '';
            } else if(re.test(input.value)) {
                input.style.borderColor = '#4CAF50';
            } else {
                input.style.borderColor = '#d32f2f';
            }
        };
        if(signupEmail) signupEmail.addEventListener('input', () => validateEmail(signupEmail));
        if(loginEmail) loginEmail.addEventListener('input', () => validateEmail(loginEmail));
    });


    function checkStrength(val) {

        const bar = document.getElementById('strengthBar');
        const text = document.getElementById('strengthText');
        let strength = 0;
        if(val.length > 5) strength += 33;
        if(val.match(/[A-Z]/) && val.match(/[0-9]/)) strength += 33;
        if(val.length > 8 && val.match(/[^a-zA-Z0-9]/)) strength += 34;
        bar.style.width = strength + '%';
        const colors = strength < 34 ? '#d32f2f' : (strength < 67 ? '#ffa000' : '#4CAF50');
        const labels = strength < 34 ? 'Weak' : (strength < 67 ? 'Medium' : 'Strong');
        bar.style.background = colors;
        text.textContent = labels;
        text.style.color = colors;
    }

    function showLoading(btn) {
        if(btn.form.checkValidity()) {
            btn.classList.add('loading');
            btn.innerHTML = '<span class="spinner"></span> Processing...';
            // Mock success for UI demo if not actual submit
            // showToast('Success!', 'Processing your request...');
        }
    }

    function showToast(title, message, type = 'success') {
        const toastContainer = document.getElementById('toast-container');
        const toast = document.createElement('div');
        toast.className = `toast toast-${type}`;
        toast.innerHTML = `
            <div class="toast-icon">${type === 'success' ? '✅' : 'ℹ️'}</div>
            <div class="toast-content">
                <strong>${title}</strong>
                <p>${message}</p>
            </div>
            <button class="toast-close" onclick="this.parentElement.remove()">&times;</button>
        `;
        toastContainer.appendChild(toast);
        setTimeout(() => {
            toast.classList.add('show');
        }, 10);
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => toast.remove(), 300);
        }, 5000);
    }
    </script>

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

    // Cookie Banner Logic
    const cookieBanner = document.getElementById('cookieBanner');
    const acceptCookies = document.getElementById('acceptCookies');
    if (cookieBanner && !localStorage.getItem('cookiesAccepted')) {
        setTimeout(() => {
            cookieBanner.style.display = 'block';
        }, 2000);
    }
    if (acceptCookies) {
        acceptCookies.addEventListener('click', () => {
            localStorage.setItem('cookiesAccepted', 'true');
            cookieBanner.style.animation = 'slideDownCookie 0.5s ease-in forwards';
            setTimeout(() => {
                cookieBanner.style.display = 'none';
            }, 500);
        });
    }

    // Back to Top Logic
    const backToTop = document.getElementById('backToTop');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            backToTop.classList.add('show');
        } else {
            backToTop.classList.remove('show');
        }
    });
    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
});


    </script>

</body>
</html>
