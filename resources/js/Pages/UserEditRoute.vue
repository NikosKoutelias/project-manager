<script setup>
import {ChevronDownIcon} from '@heroicons/vue/16/solid'
import {RouterLink, useRoute} from 'vue-router';
import useUserStore from "../store/user.js";
import router from "../router.js";
import {reactive, ref} from "vue";
import useCompanyStore from "../store/companies.js";
import useProjectStore from "../store/projects.js";
import axiosClient from "../axios.js";

const route = useRoute();
const userStore = useUserStore()
const companyStore = useCompanyStore()
const projectStore = useProjectStore()
const user = userStore.user

if (user.role !== 'ADMIN') {
    router.replace({name: 'Admin'})
}

const companies = companyStore.companies
const projects = projectStore.projects

const users = reactive(userStore.users)
const targetUser = users.filter((user) => {
    if (user.id === route.params.id) {
        return user
    }
})

const options = ref([
    {name: 'ADMIN', value: 'ADMIN'},
    {name: 'USER', value: 'USER'},
    ]
)
const errors = ref({
    email: [],
    name: [],
    role: [],
    description: [],
    companies: [],
    projects: [],
})
const data = ref({
    email: targetUser[0].email,
    name: targetUser[0].name,
    role: targetUser[0].role,
    description: JSON.parse(targetUser[0].permissions)?.description ?? '',
    companies: [],
    projects: [],

})

function submitForm() {
    const permissions = {}
    permissions['companies'] = data.value.companies
    permissions['projects'] = data.value.projects
    permissions['description'] = data.value.description

    const formData = new FormData();
    formData.append('name', data.value.name);
    formData.append('permissions', JSON.stringify(permissions));
    formData.append('email', data.value.email);
    formData.append('role', data.value.role);
    formData.append('_method', 'put')
    axiosClient.post(`api/user/${route.params.id}`, formData).then((response) => {
        router.replace({name: 'Users'})

    }).catch(error => {
        console.log(error.response);
        errors.value = error.response.data.errors;
    })
}

function deleteUser() {
    axiosClient.delete(`api/user/${route.params.id}`).then((response) => {
        router.replace({name: 'Users'})
    }).catch(error => {
        console.log(error.response);
    })
}

</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">User Information</h2>

                <div class="mt-10 grid grid-cols- gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                        <div class="mt-2">
                            <div
                                class="flex items-center rounded-md pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                <div class="shrink-0 text-base  text-gray-500 select-none sm:text-sm/6"></div>
                                <input v-model="data.email" type="email" name="email" id="email" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base  text-gray-900
                                focus:outline-none sm:text-sm/6"/>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="role" class="block text-sm/6 font-medium text-gray-900">Role</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="role" name="role" v-model="data.role"
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option v-for="option in options" :selected="option.name === data.role" :value="option.value">
                                    {{ option.name }}
                                </option>
                            </select>
                            <ChevronDownIcon
                                class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                aria-hidden="true"/>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <div class="sm:col-span-3">
                            <label for="full-name" class="block text-sm/6 font-medium text-gray-900">Full name</label>
                            <div class="mt-2">
                                <input type="text" name="full-name" id="full-name" v-model="data.name"
                                       class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-4">
                        <label for="about" class="block text-sm/6 font-medium text-gray-900">About</label>
                        <div class="mt-2">
                            <textarea name="about" id="about" rows="3" v-model="data.description"
                                      class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                        </div>
                        <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences about your preferred data
                            view.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="border-b border-gray-900/10 pb-12">
            <h2 class="text-base/7 font-semibold text-gray-900 mt-5">Permissions</h2>
            <p class="mt-1 text-sm/6 text-gray-600">Which Companies or Projects is eligible to.</p>
            <div class="mt-10 grid gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-3">
                    <label class="text-sm/6 font-semibold text-gray-900">By Project</label>
                    <div class="mt-2 col-span-3 w-full">
                        <select id="projects" multiple style="height: 200px" v-model="data.projects"
                                name="projects"
                                class="appearance-none rounded-md py-1.5 w-5/6 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 sm:text-sm/6">
                            <option disabled value="" class="mb-1.5 border-b-1">Select Projects</option>
                            <option v-for="project in projects"
                                    :value="project.name">
                                {{ project.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="sm:col-span-3">
                    <label class="text-sm/6 font-semibold text-gray-900">By Company</label>
                    <div class="mt-2 col-span-3 w-full">
                        <select id="country_of_operation" multiple style="height: 200px" v-model="data.companies"
                                name="country_of_operation"
                                class="appearance-none w-5/6 rounded-md py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 sm:text-sm/6">
                            <option disabled value="" class="mb-1.5 border-b-1">Select Companies</option>
                            <option v-for="company in companies"
                                    :value="company.name">
                                {{ company.name }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <router-link :to="{name: 'Dashboard'}"
                         class="text-sm font-semibold bg-gray-200 rounded-md hover:bg-gray-300 px-3 py-2 transition duration-300 ease-in-out text-gray-900">
                Back
            </router-link>
            <button type="submit"
                    class="rounded-md bg-indigo-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300 ease-in-out">
                Save
            </button>
            <button type="reset" v-on:click="deleteUser"
                    class="rounded-md bg-red-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-red-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600 transition duration-300 ease-in-out">
                Delete
            </button>
        </div>
    </form>
</template>
