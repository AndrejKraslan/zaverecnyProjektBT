import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://localhost:8888/zaverecnyProjektBT/backend/public/api',
    headers: {
        'Content-Type': 'application/json',
    },
});

instance.interceptors.request.use(config => {
    const token = localStorage.getItem('token'); // Alebo použite iný spôsob ukladania tokenov
    if (token) {
        config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
}, error => {
    return Promise.reject(error);
});

export default instance;
