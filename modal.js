/**
 * BitsPay Modal System
 * Provides elegant confirmation and information dialogs.
 */

window.confirmAction = (title, message, confirmText = 'Confirm', onConfirm = null) => {
    let overlay = document.getElementById('modal-overlay');
    if (!overlay) {
        overlay = document.createElement('div');
        overlay.id = 'modal-overlay';
        overlay.className = 'modal-overlay';
        overlay.innerHTML = `
            <div class="modal-card">
                <h3 id="modal-title"></h3>
                <p id="modal-message"></p>
                <div class="modal-actions">
                    <button id="modal-cancel-btn" class="modal-btn-outline">Cancel</button>
                    <button id="modal-confirm-btn" class="modal-btn-primary"></button>
                </div>
            </div>
        `;
        document.body.appendChild(overlay);
    }
    
    document.getElementById('modal-title').textContent = title;
    document.getElementById('modal-message').textContent = message;
    document.getElementById('modal-confirm-btn').textContent = confirmText;
    
    overlay.classList.add('active');
    
    const cleanup = () => {
        overlay.classList.remove('active');
        // Remove event listeners
        document.getElementById('modal-cancel-btn').replaceWith(document.getElementById('modal-cancel-btn').cloneNode(true));
        document.getElementById('modal-confirm-btn').replaceWith(document.getElementById('modal-confirm-btn').cloneNode(true));
    };
    
    document.getElementById('modal-cancel-btn').addEventListener('click', cleanup);
    document.getElementById('modal-confirm-btn').addEventListener('click', () => {
        if (onConfirm) onConfirm();
        cleanup();
    });
};
