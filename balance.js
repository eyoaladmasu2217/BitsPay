// balance.js
// Handles toggling the visibility of the account balance on the homepage

document.addEventListener('DOMContentLoaded', function() {
    const balanceAmount = document.getElementById('balanceAmount');
    const toggleBtn = document.getElementById('toggleBalanceBtn');
    const eyeIcon = document.getElementById('eyeIcon');
    let visible = false;
    const balanceValueSpan =balanceAmount.querySelector('.stars');
    const actualBalance = balanceValueSpan.textContent; // Replace with dynamic value if needed

    toggleBtn.addEventListener('click', function() {
        visible = !visible;
        if (visible) {
            balanceAmount.innerHTML = 'ETB ' + actualBalance;
            eyeIcon.textContent = '🙈';
        } else {
            balanceAmount.innerHTML = 'ETB ****';
            eyeIcon.textContent = '👁️';
        }
    });

    // Activity Tabs Filtering
    const allTab = document.querySelector('.activity-tabs .tab:nth-child(1)');
    const sentTab = document.querySelector('.activity-tabs .tab:nth-child(2)');
    const receivedTab = document.querySelector('.activity-tabs .tab:nth-child(3)');
    const activityItems = document.querySelectorAll('.activity-item');

    function setActiveTab(tab) {
        document.querySelectorAll('.activity-tabs .tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
    }

    allTab.addEventListener('click', () => {
        setActiveTab(allTab);
        activityItems.forEach(item => item.style.display = 'flex');
    });

    sentTab.addEventListener('click', () => {
        setActiveTab(sentTab);
        activityItems.forEach(item => {
            // Sent: description contains 'Payment to'
            const desc = item.querySelector('.desc').textContent;
            item.style.display = desc.includes('Payment to') ? 'flex' : 'none';
        });
    });

    receivedTab.addEventListener('click', () => {
        setActiveTab(receivedTab);
        activityItems.forEach(item => {
            // Received: description contains 'Payment from'
            const desc = item.querySelector('.desc').textContent;
            item.style.display = desc.includes('Payment from') ? 'flex' : 'none';
        });
    });
});
