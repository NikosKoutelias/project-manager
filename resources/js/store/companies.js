import {defineStore} from "pinia";
import axiosClient from "../axios.js";

const useCompanyStore = defineStore('companies', {
    state: () => ({
        companies: null,
    }),
    actions: {
        fetchCompanies() {
            return axiosClient.get('/api/company').then((response) => {
                this.companies = response.data;
            })
        }
    }
});

export default useCompanyStore;
