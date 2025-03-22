import {defineStore} from "pinia";
import axiosClient from "../axios.js";

const useProjectStore = defineStore('projects', {
    state: () => ({
        projects: null,
        project: null,
    }),
    actions: {
        fetchProjects() {
            return axiosClient.get('/api/project').then(({data}) => {
                this.projects = data;
            })
        },
        fetchProjectsForUser(userid) {
            return axiosClient.get('/api/projects/' + userid).then((response) => {
                this.projects = response.data;
            })
        },
    }
});

export default useProjectStore;
