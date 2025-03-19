import {defineStore} from "pinia";
import axiosClient from "../axios.js";

const useCountryStore = defineStore('countries', {
    state: () => ({
        countries: null,
    }),
    actions: {
        fetchCountries() {
            return axiosClient.get('/api/countries').then(({data}) => {
                this.countries = data;
            })
        }
    }
});

export default useCountryStore;
