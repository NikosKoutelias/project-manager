<script setup>
import useUserStore from "../../store/user.js";
import useCompanyStore from "../../store/companies.js";
import useProjectStore from "../../store/projects.js";

const userStore = useUserStore()
const companyStore = useCompanyStore()
const projectStore = useProjectStore()

const companies = companyStore.companies
const projects = projectStore.projects
const users = userStore.users


</script>

<template>
    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
        <div class="grid grid-cols-2 row-gap-8 md:grid-cols-4">
            <div class="text-center md:border-r">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">{{projects.length}}</h6>
                <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                    Projects
                </p>
            </div>
            <div class="text-center md:border-r">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">{{companies.length}}</h6>
                <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                    Companies
                </p>
            </div>
            <div class="text-center md:border-r">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">{{users.length}}</h6>
                <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                    Users
                </p>
            </div>
            <div class="text-center">
                <h6 class="text-4xl font-bold lg:text-5xl xl:text-6xl">-</h6>
                <p class="text-sm font-medium tracking-widest text-gray-800 uppercase lg:text-base">
                    Reports
                </p>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
