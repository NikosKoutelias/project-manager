import {defineStore} from "pinia";
import axiosClient from "../axios.js";

const useProjectStore = defineStore('projects', {
    state: () => ({
        projects: null,
    }),
    actions: {
        fetchProjects() {
            return axiosClient.get('/api/project').then(({data}) => {
                this.projects = data;
            })
        }
    }
});

export default useProjectStore;
