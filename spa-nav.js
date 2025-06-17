// SPA navigation for BitsPay
// Show only the selected section, hide others

document.addEventListener('DOMContentLoaded', function () {
    // Section IDs
    const sections = {
        Home: document.querySelector('.dashboard'),
        Activity: document.getElementById('activity'),
        Send: document.getElementById('send'),
        Payments: document.getElementById('payments')
    };

    // Navbar links
    const navLinks = Array.from(document.querySelectorAll('.main-navbar nav a'));

    // Show only Home by default
    Object.values(sections).forEach((sec, i) => {
        if (i === 0) {
            sec.style.display = '';
        } else {
            sec.style.display = 'none';
        }
    });

    navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            // Remove active from all
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            // Hide all sections
            Object.values(sections).forEach(sec => sec.style.display = 'none');
            // Show the selected section
            const section = sections[this.textContent.trim()];
            if (section) section.style.display = '';
            // Optionally scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
});
