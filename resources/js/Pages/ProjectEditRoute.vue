<script setup>
import {ChevronDownIcon} from '@heroicons/vue/16/solid'
import {RouterLink, useRoute} from 'vue-router';
import useUserStore from "../store/user.js";
import router from "../router.js";
import {reactive, ref} from "vue";
import useCompanyStore from "../store/companies.js";
import axiosClient from "../axios.js";
import useProjectStore from "../store/projects.js";

const route = useRoute();
const userStore = useUserStore()
const companyStore = useCompanyStore()
const projectStore = useProjectStore()

const user = userStore.user
const companies = companyStore.companies

let edit = true
if (user.role !== 'ADMIN') {
    edit = false
}

const projects = reactive(projectStore.projects)
const targetProject = projects.filter((project) => {

    if (project.id === route.params.id) {
        return project
    }
})

const errors = ref({
    name: [],
    description: [],
    company_id: [],
})

const data = ref({
    name: targetProject[0].name,
    description: targetProject[0].description,
    company_id: targetProject[0].company_id,
})
function submitForm() {
    const formData = new FormData();
    formData.append('name', data.value.name);
    formData.append('description', data.value.description);
    formData.append('company_id', data.value.company_id);
    formData.append('_method', 'put')
    axiosClient.post(`api/project/${route.params.id}`, formData).then((response) => {
        router.replace({name: 'Projects'})

    }).catch(error => {
        console.log(error.response);
        errors.value = error.response.data.errors;
    })
}

function deleteCompany() {
    axiosClient.delete(`api/company/${route.params.id}`).then((response) => {
        router.replace({name: 'Companies'})
    }).catch(error => {
        console.log(error.response);
    })
}

</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Project Information</h2>

                <div class="mt-10 grid grid-cols- gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
                        <div class="mt-2">
                            <div :class="edit ? 'bg-white' : 'bg-gray-100'"
                                 class="flex items-center rounded-md pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                <input v-model="data.name" :disabled="!edit" type="text" name="name" id="name" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base  text-gray-900
                                focus:outline-none sm:text-sm/6"/>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="role" class="block text-sm/6 font-medium text-gray-900">Company</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="role" name="role" v-model="data.company_id" :disabled="!edit" :class="edit ? 'bg-white' : 'bg-gray-100'"
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option v-for="company in companies" :selected="company.id === data.company_id" :value="company.id">
                                    {{ company.name }}
                                </option>
                            </select>
                            <ChevronDownIcon
                                class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                aria-hidden="true"/>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <div class="sm:col-span-3">
                            <label for="description" class="block text-sm/6 font-medium text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea type="text" rows="5" name="description" :class="edit ? 'bg-white' : 'bg-gray-100'"
                                          id="description" v-model="data.description" :readonly="!edit"
                                          class="block w-full rounded-md px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <router-link :to="{name: 'Projects'}"
                         class="text-sm font-semibold bg-gray-200 rounded-md hover:bg-gray-300 px-3 py-2 transition duration-300 ease-in-out text-gray-900">
                Back
            </router-link>
            <button type="submit" v-if="edit"
                    class="rounded-md bg-indigo-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300 ease-in-out">
                Save
            </button>
            <button type="reset" v-on:click="deleteCompany" v-if="edit"
                    class="rounded-md bg-red-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition duration-300 ease-in-out">
                Delete
            </button>
        </div>
    </form>
</template>
