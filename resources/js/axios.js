import  axios from "axios"
import router from "./router.js";

const axiosClient = axios.create({
    baseURL:'/',
    withCredentials:true,
    withXSRFToken:true,
})

axiosClient.interceptors.response.use((response) => {
    return response;
}, (err) => {
    if (err.response && err.response.status === 401) {
        router.push({name: 'Login'});
    }
    throw err;
})

export default axiosClient
