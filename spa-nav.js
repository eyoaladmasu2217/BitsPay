document.addEventListener('DOMContentLoaded', function () {
    
    const sections = {
        Home: document.querySelector('.dashboard'),
        Activity: document.getElementById('activity'),
        Send: document.getElementById('send'),
        Payments: document.getElementById('payments')
    };

    const navLinks = Array.from(document.querySelectorAll('.main-navbar nav a'));

    
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
            
            navLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
           
            Object.values(sections).forEach(sec => sec.style.display = 'none');
            
            const section = sections[this.textContent.trim()];
            if (section) section.style.display = '';
            
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    });
});
