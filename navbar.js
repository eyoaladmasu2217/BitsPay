const signupBtn = document.getElementById('signupBtn');
const loginBtn = document.getElementById('loginBtn');
const formButton = document.querySelector('form button');

signupBtn.addEventListener('click', function(e) {
    e.preventDefault();
    signupBtn.classList.add('active');
    loginBtn.classList.remove('active');
    document.getElementById('loginForm').style.display = 'none';
    document.getElementById('signupForm').style.display = 'block';
    if (formButton) formButton.textContent = 'Sign up';
});

loginBtn.addEventListener('click', function(e) {
    e.preventDefault();
    loginBtn.classList.add('active');
    signupBtn.classList.remove('active');
    document.getElementById('signupForm').style.display = 'none';
    document.getElementById('loginForm').style.display = 'block';
    if (formButton) formButton.textContent = 'Log in';
});
