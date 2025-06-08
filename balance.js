// balance.js
// Handles toggling the visibility of the account balance on the homepage

document.addEventListener('DOMContentLoaded', function() {
    const balanceAmount = document.getElementById('balanceAmount');
    const toggleBtn = document.getElementById('toggleBalanceBtn');
    const eyeIcon = document.getElementById('eyeIcon');
    let visible = false;
    let actualBalance = '12,345.67'; // Replace with dynamic value if needed

    toggleBtn.addEventListener('click', function() {
        visible = !visible;
        if (visible) {
            balanceAmount.innerHTML = 'ETB ' + actualBalance;
            eyeIcon.textContent = '🙈';
        } else {
            balanceAmount.innerHTML = 'ETB <span class="stars">****</span>';
            eyeIcon.textContent = '👁️';
        }
    });
});
