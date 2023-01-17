import axios from "axios";

const httpClient = axios.create({
    baseURL: `${window.location.protocol}//${window.location.hostname}/wp-json/payeye/v1/`,
    headers: {
        'Content-Type': 'application/json',
    },
});

export default httpClient;
