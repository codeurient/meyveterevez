/**
 * Admin Panel JS
 * Handles: delete confirmation, flash auto-dismiss
 */
(function () {
    'use strict';

    // ── Delete confirmation ─────────────────────────────────
    document.addEventListener('submit', function (e) {
        const form = e.target;
        const msg  = form.dataset.confirm;
        if (msg && !window.confirm(msg)) {
            e.preventDefault();
        }
    });

    // ── Auto-dismiss flash messages after 4s ────────────────
    const flashes = document.querySelectorAll('[data-flash]');
    flashes.forEach(function (el) {
        setTimeout(function () {
            el.style.opacity = '0';
            el.style.transition = 'opacity 0.4s';
            setTimeout(function () { el.remove(); }, 400);
        }, 4000);
    });
})();
