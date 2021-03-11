import axios from 'axios';

const applicationJson = 'application/json';

const apiClient = axios.create({
  baseURL: 'http://localhost:8080', // Backend
  withCredentials: false,
  headers: {
    Accept: applicationJson,
    'Content-type': applicationJson,
  }
});

export default apiClient;
