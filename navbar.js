// Toggle active class on nav buttons
const signupBtn = document.getElementById('signupBtn');
const loginBtn = document.getElementById('loginBtn');

signupBtn.addEventListener('click', function(e) {
    e.preventDefault();
    signupBtn.classList.add('active');
    loginBtn.classList.remove('active');
});

loginBtn.addEventListener('click', function(e) {
    e.preventDefault();
    loginBtn.classList.add('active');
    signupBtn.classList.remove('active');
});
