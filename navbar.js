// Toggle active class on nav buttons
const signupBtn = document.getElementById('signupBtn');
const loginBtn = document.getElementById('loginBtn');
const formButton = document.querySelector('form button');

signupBtn.addEventListener('click', function(e) {
    e.preventDefault();
    signupBtn.classList.add('active');
    loginBtn.classList.remove('active');
    if (formButton) formButton.textContent = 'Sign up';
});

loginBtn.addEventListener('click', function(e) {
    e.preventDefault();
    loginBtn.classList.add('active');
    signupBtn.classList.remove('active');
    if (formButton) formButton.textContent = 'Log in';
});
