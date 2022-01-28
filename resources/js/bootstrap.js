window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response.status === 401) {
            window.location.assign('/login');
        } else if (error.response.status === 403) {
            window.location.assign('/email/verify');
        }
        return Promise.reject(error);
    }
);
