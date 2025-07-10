const signupBtn = document.getElementById('signupBtn');
const loginBtn = document.getElementById('loginBtn');
const signupForm = document.getElementById('signupForm');
const loginForm = document.getElementById('loginForm');
const signupButton = signupForm.querySelector('button[type="submit"]');
const loginButton = loginForm.querySelector('button[type="submit"]');

signupBtn.addEventListener('click', function(e) {
    e.preventDefault();
    signupBtn.classList.add('active');
    loginBtn.classList.remove('active');
    signupForm.style.display = '';
    loginForm.style.display = 'none';
    signupButton.textContent = 'Sign up';
    signupButton.classList.add('auth-btn');
    loginButton.classList.add('auth-btn');
    signupButton.removeAttribute('style');
    loginButton.removeAttribute('style');
});

loginBtn.addEventListener('click', function(e) {
    e.preventDefault();
    loginBtn.classList.add('active');
    signupBtn.classList.remove('active');
    signupForm.style.display = 'none';
    loginForm.style.display = '';
    loginButton.textContent = 'Log in';
    loginButton.classList.add('auth-btn');
    signupButton.classList.add('auth-btn');
    loginButton.removeAttribute('style');
    signupButton.removeAttribute('style');
});
