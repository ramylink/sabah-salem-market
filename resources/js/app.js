import './bootstrap';
import Alpine from 'alpinejs';
import 'lazysizes';
import 'lazysizes/plugins/parent-fit/ls.parent-fit';

// Initialize Alpine.js
window.Alpine = Alpine;
Alpine.start();

// Register Service Worker for PWA
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('SW registered:', registration.scope);
            })
            .catch(error => {
                console.log('SW registration failed:', error);
            });
    });
}

// Global utilities
window.SSMarket = {
    // Format price in KWD
    formatPrice(price) {
        return new Intl.NumberFormat('ar-KW', {
            style: 'currency',
            currency: 'KWD',
            minimumFractionDigits: 3,
        }).format(price);
    },

    // Format number
    formatNumber(num) {
        return new Intl.NumberFormat('ar-KW').format(num);
    },

    // Debounce function
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Throttle function
    throttle(func, limit) {
        let inThrottle;
        return function(...args) {
            if (!inThrottle) {
                func.apply(this, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        };
    },

    // Copy to clipboard
    async copyToClipboard(text) {
        try {
            await navigator.clipboard.writeText(text);
            return true;
        } catch (err) {
            console.error('Failed to copy:', err);
            return false;
        }
    },

    // Share functionality
    async share(data) {
        if (navigator.share) {
            try {
                await navigator.share(data);
                return true;
            } catch (err) {
                console.log('Share cancelled');
                return false;
            }
        }
        return false;
    }
};

// Intersection Observer for animations
const observerOptions = {
    root: null,
    rootMargin: '0px',
    threshold: 0.1
};

const animationObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-fade-in');
            animationObserver.unobserve(entry.target);
        }
    });
}, observerOptions);

// Observe elements with data-animate attribute
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-animate]').forEach(el => {
        animationObserver.observe(el);
    });
});

// Handle offline/online status
window.addEventListener('online', () => {
    document.body.classList.remove('offline');
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { message: '✅ تم استعادة الاتصال بالإنترنت', type: 'success' }
    }));
});

window.addEventListener('offline', () => {
    document.body.classList.add('offline');
    window.dispatchEvent(new CustomEvent('toast', {
        detail: { message: '⚠️ أنت غير متصل بالإنترنت', type: 'warning' }
    }));
});

// Prevent double-tap zoom on mobile
document.addEventListener('touchend', (e) => {
    if (e.target.closest('button, a, [role="button"]')) {
        e.preventDefault();
        e.target.click();
    }
}, { passive: false });
