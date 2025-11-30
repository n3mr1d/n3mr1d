class ToastManager {
    constructor() {
        this.toastContainer = null;
        this.activeToasts = new Set();
        this.maxToasts = 5;
        this.defaultDelay = 4000;
        this.init();
    }

    init() {
        this.createContainer();
        this.injectAnimations();
    }

    createContainer() {
        if (!this.toastContainer) {
            this.toastContainer = document.createElement('div');
            this.toastContainer.id = 'toast-container';
            this.toastContainer.className = 'position-fixed top-0 end-0 p-3';
            this.toastContainer.style.zIndex = '9999';
            this.toastContainer.style.maxHeight = '80vh';
            this.toastContainer.style.overflowY = 'auto';
            document.body.appendChild(this.toastContainer);
        }
    }

    injectAnimations() {
        if (!document.getElementById('toast-animations')) {
            const style = document.createElement('style');
            style.id = 'toast-animations';
            style.textContent = `
                @keyframes slideInRight {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
                @keyframes slideOutRight {
                    from { transform: translateX(0); opacity: 1; }
                    to { transform: translateX(100%); opacity: 0; }
                }
            `;
            document.head.appendChild(style);
        }
    }

    getConfig(type) {
        const configs = {
            success: { bg: 'bg-success', icon: 'check-circle', text: 'text-white' },
            error: { bg: 'bg-danger', icon: 'exclamation-circle', text: 'text-white' },
            warning: { bg: 'bg-warning', icon: 'exclamation-triangle', text: 'text-dark' },
            info: { bg: 'bg-info', icon: 'info-circle', text: 'text-white' }
        };
        return configs[type] || configs.info;
    }

    show(message, type = 'info', options = {}) {
        if (this.activeToasts.size >= this.maxToasts) {
            const oldest = this.activeToasts.values().next().value;
            this.removeToast(oldest);
        }

        const id = `toast-${Date.now()}-${Math.random().toString(36).substr(2, 9)}`;
        const { bg, icon, text } = this.getConfig(type);
        const delay = options.delay || this.defaultDelay;
        const autohide = options.autohide !== false;

        const html = `
            <div id="${id}" class="toast ${bg} ${text} mb-2" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body d-flex align-items-center">
                    <i class="fas fa-${icon} me-2"></i>
                    <span class="flex-grow-1">${message}</span>
                    <button type="button" class="btn-close btn-close-white ms-2" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;

        this.toastContainer.insertAdjacentHTML('beforeend', html);
        const element = document.getElementById(id);
        this.activeToasts.add(id);

        if (typeof bootstrap !== 'undefined' && bootstrap.Toast) {
            const toast = new bootstrap.Toast(element, { delay, autohide });
            element.addEventListener('hidden.bs.toast', () => this.removeToast(id));
            toast.show();
        } else {
            // Fallback without Bootstrap
            element.style.animation = 'slideInRight 0.3s ease-out';
            element.addEventListener('click', () => this.fadeOut(id));
            setTimeout(() => this.fadeOut(id), delay);
        }
    }

    fadeOut(id) {
        const element = document.getElementById(id);
        if (element) {
            element.style.animation = 'slideOutRight 0.3s ease-in';
            setTimeout(() => this.removeToast(id), 300);
        }
    }

    removeToast(id) {
        const element = document.getElementById(id);
        if (element) element.remove();
        this.activeToasts.delete(id);
    }

    clearAll() {
        this.activeToasts.forEach(id => this.removeToast(id));
    }

    // Shortcut methods
    success(msg, opts) { this.show(msg, 'success', opts); }
    error(msg, opts) { this.show(msg, 'error', opts); }
    warning(msg, opts) { this.show(msg, 'warning', opts); }
    info(msg, opts) { this.show(msg, 'info', opts); }
}

// === ApiClient Class ===
class ApiClient {
    constructor() {
        this.defaultTimeout = 10000;
        this.retries = 3;
        this.retryDelay = 1000;
    }

    async fetchWithRetry(url, options = {}, retries = this.retries) {
        try {
            const controller = new AbortController();
            const timeout = setTimeout(() => controller.abort(), this.defaultTimeout);

            const response = await fetch(url, { ...options, signal: controller.signal });
            clearTimeout(timeout);

            if (!response.ok) throw new Error(`HTTP ${response.status}`);
            return response;
        } catch (err) {
            if (retries > 0 && err.name !== 'AbortError') {
                console.warn(`Retrying... (${this.retries - retries + 1})`);
                await new Promise(res => setTimeout(res, this.retryDelay));
                return this.fetchWithRetry(url, options, retries - 1);
            }
            throw err;
        }
    }

    async fetchToast(endpoint = '/api/key') {
        try {
            const response = await this.fetchWithRetry(endpoint, {
                method: 'GET',
                headers: { 'Content-Type': 'application/json' }
            });
            return await response.json();
        } catch (err) {
            console.error('API error:', err);
            return null;
        }
    }
}

const toastManager = new ToastManager();
const apiClient = new ApiClient();

async function fetchAndShowToast() {
    const data = await apiClient.fetchToast();
    if (data && data.data && data.data.type && data.data.message) {
        toastManager.show(data.data.message, data.data.type);
    }
}

function setupToastAutoFetch() {
    fetchAndShowToast();
    let interval;

    document.addEventListener('visibilitychange', () => {
        if (!document.hidden) {
            fetchAndShowToast();
            if (!interval) interval = setInterval(fetchAndShowToast, 30000);
        } else if (interval) {
            clearInterval(interval);
            interval = null;
        }
    });

    window.addEventListener('beforeunload', () => {
        if (interval) clearInterval(interval);
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', setupToastAutoFetch);
} else {
    setupToastAutoFetch();
}

// === Export Global API ===
window.toast = {
    show: (msg, type, opts) => toastManager.show(msg, type, opts),
    success: (msg, opts) => toastManager.success(msg, opts),
    error: (msg, opts) => toastManager.error(msg, opts),
    warning: (msg, opts) => toastManager.warning(msg, opts),
    info: (msg, opts) => toastManager.info(msg, opts),
    clear: () => toastManager.clearAll(),
    fetchAndShow: fetchAndShowToast
};

window.toastManager = toastManager;
window.apiClient = apiClient;

