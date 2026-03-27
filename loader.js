/**
 * BitsPay Loading System
 * Provides visual feedback for long-running operations.
 */

window.showLoader = (message = 'Processing...') => {
    let loader = document.getElementById('global-loader');
    if (!loader) {
        loader = document.createElement('div');
        loader.id = 'global-loader';
        loader.className = 'loader-overlay';
        loader.innerHTML = `
            <div class="loader-content">
                <div class="loader-spinner"></div>
                <p id="loader-message">${message}</p>
            </div>
        `;
        document.body.appendChild(loader);
    } else {
        document.getElementById('loader-message').textContent = message;
    }
    
    loader.classList.add('active');
};

window.hideLoader = () => {
    const loader = document.getElementById('global-loader');
    if (loader) {
        loader.classList.remove('active');
    }
};

// Auto-attach to forms with data-loader attribute
document.addEventListener('submit', (e) => {
    const form = e.target;
    if (form.dataset.loader !== undefined) {
        window.showLoader(form.dataset.loader || 'Processing...');
    }
});
