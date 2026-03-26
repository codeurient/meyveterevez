import './bootstrap';

// ==================== MOBILE MENU ====================
const mobileMenuBtn   = document.getElementById('mobileMenuBtn');
const closeMobileMenu = document.getElementById('closeMobileMenu');
const mobileMenu      = document.getElementById('mobileMenu');
const mobileMenuPanel = document.getElementById('mobileMenuPanel');
const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

function openMobileMenu() {
    mobileMenu.classList.remove('hidden');
    setTimeout(() => mobileMenuPanel.style.transform = 'translateX(0)', 10);
    document.body.style.overflow = 'hidden';
}
function closeMobileMenuFn() {
    mobileMenuPanel.style.transform = 'translateX(100%)';
    setTimeout(() => {
        mobileMenu.classList.add('hidden');
        document.body.style.overflow = '';
    }, 300);
}
mobileMenuBtn?.addEventListener('click', openMobileMenu);
closeMobileMenu?.addEventListener('click', closeMobileMenuFn);
mobileMenuOverlay?.addEventListener('click', closeMobileMenuFn);

// ==================== CART SIDEBAR ====================
const cartSidebar     = document.getElementById('cartSidebar');
const cartOverlay     = document.getElementById('cartOverlay');
const closeCartBtn    = document.getElementById('closeCart');
const continueShopBtn = document.getElementById('continueShopping');

window.openCart = function () {
    cartSidebar?.classList.add('open');
    cartOverlay?.classList.add('open');
    document.body.style.overflow = 'hidden';
};
function closeCart() {
    cartSidebar?.classList.remove('open');
    cartOverlay?.classList.remove('open');
    document.body.style.overflow = '';
}
closeCartBtn?.addEventListener('click', closeCart);
continueShopBtn?.addEventListener('click', closeCart);
cartOverlay?.addEventListener('click', closeCart);

// ==================== TOAST ====================
window.showToast = function (message, type = 'success', duration = 3000) {
    const toast     = document.getElementById('toast');
    const toastTitle = document.getElementById('toast-title');
    const toastMsg   = document.getElementById('toast-message');
    const icon       = toast?.querySelector('i');
    if (!toast) return;

    const config = {
        success: { title: 'Success',  color: 'bg-green-100', iconColor: 'text-green-500', iconClass: 'fa-check-circle' },
        error:   { title: 'Error',    color: 'bg-red-100',   iconColor: 'text-red-500',   iconClass: 'fa-times-circle' },
        info:    { title: 'Info',     color: 'bg-blue-100',  iconColor: 'text-blue-500',  iconClass: 'fa-info-circle' },
        warning: { title: 'Warning',  color: 'bg-yellow-100',iconColor: 'text-yellow-500',iconClass: 'fa-exclamation-circle' },
    };
    const cfg = config[type] || config.success;

    if (toastTitle) toastTitle.textContent = cfg.title;
    if (toastMsg)   toastMsg.textContent   = message;
    if (icon) {
        icon.className = `fas ${cfg.iconClass} text-lg ${cfg.iconColor}`;
        icon.closest('div').className = `w-10 h-10 rounded-full ${cfg.color} flex items-center justify-center`;
    }

    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), duration);
};

// ==================== SEARCH FILTER BUTTON ====================
// Handled by the layout's inline script via window.openSearchFilter()

// ==================== CART COUNT HELPERS ====================
window.updateCartCount = function (count) {
    const els = [
        document.getElementById('cartCount'),
        document.getElementById('floatingCartCount'),
    ];
    els.forEach(el => {
        if (!el) return;
        el.textContent = count;
        el.classList.toggle('hidden', count === 0);
        el.classList.toggle('flex', count > 0);
    });
};

// ==================== ACTIVE NAV LINK ====================
// Highlight current nav link based on URL path
(function () {
    const path = window.location.pathname;
    document.querySelectorAll('nav a[href]').forEach(link => {
        try {
            const linkPath = new URL(link.href).pathname;
            if (linkPath !== '/' && path.startsWith(linkPath)) {
                link.classList.add('text-green-600');
                link.classList.remove('text-gray-700');
            }
        } catch (_) {}
    });
})();
