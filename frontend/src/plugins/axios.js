import axios from 'axios';

const instance = axios.create({
    baseURL: 'http://localhost:8888/zaverecnyProjektBT/backend/public/api',
    headers: {
        'Content-Type': 'application/json',
    },
});

export default instance;
