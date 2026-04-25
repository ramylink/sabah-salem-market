import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers.common['Accept'] = 'application/json';

// Add CSRF token to all requests
const token = document.head.querySelector('meta[name="csrf-token"]');
if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

// Request interceptor for loading states
window.axios.interceptors.request.use(
    config => {
        document.body.classList.add('loading');
        return config;
    },
    error => {
        document.body.classList.remove('loading');
        return Promise.reject(error);
    }
);

// Response interceptor
window.axios.interceptors.response.use(
    response => {
        document.body.classList.remove('loading');
        return response;
    },
    error => {
        document.body.classList.remove('loading');

        if (error.response?.status === 419) {
            window.location.reload();
        }

        if (error.response?.status === 401) {
            window.dispatchEvent(new CustomEvent('auth-required'));
        }

        return Promise.reject(error);
    }
);
