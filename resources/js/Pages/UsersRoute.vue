<script setup>

import useUserStore from "../store/user.js";

const userStore = useUserStore()
const users = userStore.users

</script>

<template>
    <div
        class="relative overflow-x-auto shadow-md sm:rounded-lg hover:drop-shadow-xl transition duration-300 ease-in-out">
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
                    Projects
                </th>
                <th scope="col" class="px-6 py-3">
                    Companies
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
                    {{ user.role !== 'ADMIN' ? JSON.parse(user.permissions).projects : 'All' }}
                </td>
                <td class="px-6 py-4">
                    {{ user.role !== 'ADMIN' ? JSON.parse(user.permissions).companies : 'All' }}
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
