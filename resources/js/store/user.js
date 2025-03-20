import {defineStore} from "pinia";
import axiosClient from "../axios.js";

const useUserStore = defineStore('user', {
    state: () => ({
        user: null,
        users: null,
    }),
    actions: {
        fetchUser() {
            return axiosClient.get('/api/user').then(({data}) => {
                this.user = data;
            })
        },
        fetchUsers() {
            return axiosClient.get('/api/users').then(({data}) => {
                this.users = data;
            })
        }
    }
});

export default useUserStore;
