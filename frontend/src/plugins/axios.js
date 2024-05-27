import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://localhost/zaverecnyProjektBT/backend/public/api', // Update with your backend URL
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
    },
});

instance.interceptors.request.use(config => {
    const token = localStorage.getItem('token');
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

export default instance;
