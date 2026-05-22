import axios from 'axios';

const api = axios.create({
  baseURL: 'http://127.0.0.1:8000', // или твой домен Laravel
  withCredentials: true, // важно для Sanctum
});

export default api;

