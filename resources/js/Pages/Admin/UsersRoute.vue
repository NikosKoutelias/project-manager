<script setup>

import useUserStore from "../../store/user.js";
import CreateModal from "../../Widgets/CreateModal.vue";
import {ref} from "vue";
import useCompanyStore from "../../store/companies.js";
import useProjectStore from "../../store/projects.js";

const userStore = useUserStore()
const companyStore = useCompanyStore()
const projectStore = useProjectStore()

const companies = companyStore.companies
const projects = projectStore.projects
const users = userStore.users


const roles = ref([
        {name: 'ADMIN', value: 'ADMIN'},
        {name: 'USER', value: 'USER'},
    ]
)

function reload() {
    window.location.reload()
}

const isModalOpen = ref(false)

function toggle() {
    isModalOpen.value = !isModalOpen.value;
}

function mapIDs(ids,elements) {
    let nameS = []
    ids.filter(id => {
        const found = elements.find(i => i.id === id)?.name
        if(found){
            nameS.push(found)
        }
    })

    return nameS
}

</script>

<template>
    <div class="container h-10 mb-2">
        <button @click="toggle"
                class="rounded-md float-end px-3 py-2 text-sm font-semibold text-white shadow-xs bg-indigo-400 hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300 ease-in-out">
            Create User
        </button>
        <button type="reset" class="float-end mt-1" v-on:click="reload">
            <svg fill="#2c778f" height="30px" width="50px" version="1.1" id="Capa_1"
                 xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                 viewBox="0 0 489.698 489.698" xml:space="preserve">
                        <g>
                            <g>
                                <path d="M468.999,227.774c-11.4,0-20.8,8.3-20.8,19.8c-1,74.9-44.2,142.6-110.3,178.9c-99.6,54.7-216,5.6-260.6-61l62.9,13.1
                                    c10.4,2.1,21.8-4.2,23.9-15.6c2.1-10.4-4.2-21.8-15.6-23.9l-123.7-26c-7.2-1.7-26.1,3.5-23.9,22.9l15.6,124.8
                                    c1,10.4,9.4,17.7,19.8,17.7c15.5,0,21.8-11.4,20.8-22.9l-7.3-60.9c101.1,121.3,229.4,104.4,306.8,69.3
                                    c80.1-42.7,131.1-124.8,132.1-215.4C488.799,237.174,480.399,227.774,468.999,227.774z"/>
                                <path d="M20.599,261.874c11.4,0,20.8-8.3,20.8-19.8c1-74.9,44.2-142.6,110.3-178.9c99.6-54.7,216-5.6,260.6,61l-62.9-13.1
                                    c-10.4-2.1-21.8,4.2-23.9,15.6c-2.1,10.4,4.2,21.8,15.6,23.9l123.8,26c7.2,1.7,26.1-3.5,23.9-22.9l-15.6-124.8
                                    c-1-10.4-9.4-17.7-19.8-17.7c-15.5,0-21.8,11.4-20.8,22.9l7.2,60.9c-101.1-121.2-229.4-104.4-306.8-69.2
                                    c-80.1,42.6-131.1,124.8-132.2,215.3C0.799,252.574,9.199,261.874,20.599,261.874z"/>
                            </g>
                        </g>
                    </svg>
        </button>
    </div>
    <CreateModal v-if="isModalOpen" :label="'User'" :roles="roles" :email="true"
                 :destination="$route.name"></CreateModal>
    <div
        class="relative overflow-x-auto w-full shadow-md sm:rounded-lg hover:drop-shadow-xl transition duration-300 ease-in-out">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Name
                </th>
                <th scope="col" class="px-6 py-3">
                    Email
                </th>
                <th scope="col" class="px-6 py-3">
                    Role
                </th>
                <th scope="col" class="px-6 py-3">
                    Companies
                </th>
                <th scope="col" class="px-6 py-3">
                    Projects
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="user in users"
                class="odd:bg-white even:bg-gray-100 border-b  border-gray-200 hover:bg-gray-200 transition duration-300 ease-in-out">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                    {{ user.name }}
                </th>
                <td class="px-6 py-4">
                    {{ user.email }}
                </td>
                <td class="px-6 py-4">
                    {{ user.role }}
                </td>
                <td class="px-6 py-4">
                    {{ user.role !== 'ADMIN' ? mapIDs(JSON.parse(user.permissions).companies,companies) : 'All' }}
                </td>
                <td class="px-6 py-4">
                    {{ user.role !== 'ADMIN' ?  mapIDs(JSON.parse(user.permissions).projects,projects) : 'All' }}
                </td>

                <td class="px-6 py-4">
                    <router-link :to="`/admin/user/${user.id}`"
                                 class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit
                    </router-link>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<style scoped>

</style>
