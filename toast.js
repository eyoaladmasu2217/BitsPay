/**
 * BitsPay Toast Notification System
 * Handles elegant visual feedback for user actions.
 */

const createToastContainer = () => {
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        document.body.appendChild(container);
    }
    return container;
};

window.showToast = (title, message, type = 'success') => {
    const container = createToastContainer();
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    
    // Choose icon based on type
    const icons = {
        success: '✅',
        error: '⚠️',
        info: 'ℹ️',
        warning: '🔔'
    };
    
    toast.innerHTML = `
        <div class="toast-icon">${icons[type] || '✨'}</div>
        <div class="toast-content">
            <strong>${title}</strong>
            <p>${message}</p>
        </div>
        <button class="toast-close" aria-label="Dismiss">&times;</button>
    `;

    container.appendChild(toast);
    
    // Animate in
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });

    // Setup dismissal
    const dismiss = () => {
        toast.classList.remove('show');
        toast.addEventListener('transitionend', () => toast.remove(), { once: true });
    };

    toast.querySelector('.toast-close').addEventListener('click', dismiss);

    // Auto dismiss after 5s
    setTimeout(dismiss, 5000);
};
