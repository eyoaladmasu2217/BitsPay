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
document.addEventListener('DOMContentLoaded', function() {
        const depositBtn = document.getElementById('depositBtn');
        const depositInput = document.getElementById('depositInput');
        if (depositBtn && depositInput) {
            depositBtn.addEventListener('click', function() {
                if (depositInput.style.display === 'none' || depositInput.style.display === '') {
                    depositInput.style.display = 'block';
                    depositInput.focus();
                } else {
                    depositInput.style.display = 'none';
                }
            });
        }
    });
    
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.main-navbar nav a');
    const sections = document.querySelectorAll('.dashboard-section');
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            // Remove active from all links
            navLinks.forEach(l => l.classList.remove('active'));
            // Hide all sections
            sections.forEach(sec => sec.style.display = 'none');
            // Add active to clicked link
            this.classList.add('active');
            // Show the corresponding section
            const target = this.getAttribute('href').replace('#','');
            const section = document.getElementById(target);
            if(section) section.style.display = 'block';
        });
    });
    // Show only home by default
    sections.forEach(sec => sec.style.display = 'none');
    document.getElementById('home').style.display = 'block';
});
// Auto-fill logic for Make Payment section
document.addEventListener('DOMContentLoaded', function() {
    const paymentTypeSelect = document.querySelector('.payment-form select[name="paymentType"]');
    const amountInput = document.querySelector('.payment-form input[name="makePayment"]');
    if (paymentTypeSelect && amountInput) {
        paymentTypeSelect.addEventListener('change', function() {
            switch (this.value) {
                case 'TuitionFull':
                    amountInput.value = 30000;
                    break;
                case 'Tuition60':
                    amountInput.value = 17500;
                    break;
                case 'Tuition40':
                    amountInput.value = 12500;
                    break;
                default:
                    amountInput.value = '';
            }
        });
    }
});
