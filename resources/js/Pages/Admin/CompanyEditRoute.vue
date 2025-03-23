<script setup>
import {ChevronDownIcon} from '@heroicons/vue/16/solid'
import {RouterLink, useRoute} from 'vue-router';
import useUserStore from "../../store/user.js";
import router from "../../router.js";
import {reactive, ref} from "vue";
import useCompanyStore from "../../store/companies.js";
import axiosClient from "../../axios.js";
import useCountryStore from "../../store/countries.js";

const route = useRoute();
const userStore = useUserStore()
const companyStore = useCompanyStore()
const countryStore = useCountryStore()

const user = userStore.user
const countries = countryStore.countries

let edit = true
if (user.role !== 'ADMIN') {
    edit = false
}

const companies = reactive(companyStore.companies)
const targetCompany = companies.filter((company) => {

    if (company.id === route.params.id) {
        return company
    }
})

const errors = ref({
    name: [],
    description: [],
    country_of_operation: [],
})

const data = ref({
    name: targetCompany[0].name,
    description: targetCompany[0].description,
    country_of_operation: targetCompany[0].country_of_operation,
})
function submitForm() {
    const formData = new FormData();
    formData.append('name', data.value.name);
    formData.append('description', data.value.description);
    formData.append('country_of_operation', data.value.country_of_operation);
    formData.append('_method', 'put')
    axiosClient.post(`api/company/${route.params.id}`, formData).then((response) => {
        router.replace({name: 'Companies'})

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

function reload() {
    window.location.reload()
}

</script>

<template>
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
    <form @submit.prevent="submitForm">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Company Information</h2>

                <div class="mt-10 grid grid-cols- gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
                        <div class="mt-2">
                            <div :class="edit ? 'bg-white' : 'bg-gray-100'"
                                class="flex items-center rounded-md pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                <input v-model="data.name" :disabled="!edit"
                                       type="text" name="name" id="name" class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base  text-gray-900
                                focus:outline-none sm:text-sm/6"/>
                            </div>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="role" class="block text-sm/6 font-medium text-gray-900">Country</label>
                        <div class="mt-2 grid grid-cols-1">
                            <select id="role" name="role" v-model="data.country_of_operation" :disabled="!edit" :class="edit ? 'bg-white' : 'bg-gray-100'"
                                    class="col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                <option v-for="(key, country) in countries" :selected="country === data.country_of_operation" :value="country">
                                    {{ key }}
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
                                <textarea type="text" rows="5" name="description" id="description" v-model="data.description" :readonly="!edit" :class="edit ? 'bg-white' : 'bg-gray-100'"
                                       class="block w-full rounded-md px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <router-link :to="{name: 'Companies'}"
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
