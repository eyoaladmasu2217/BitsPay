const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
const currentTheme = localStorage.getItem('theme');

// Set theme based on saved preference or system preference
const setTheme = (theme) => {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
    if (theme === 'dark') {
        toggleSwitch.checked = true;
    } else {
        toggleSwitch.checked = false;
    }
};

if (currentTheme) {
    setTheme(currentTheme);
} else if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
    setTheme('dark');
}

function switchTheme(e) {
    if (e.target.checked) {
        setTheme('dark');
    } else {
        setTheme('light');
    }    
}

toggleSwitch.addEventListener('change', switchTheme, false);

