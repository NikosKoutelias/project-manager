<script setup>

import {ref} from "vue";
import axiosClient from "../axios.js";
import router from "../router.js";

const data = ref({
    current_password: "",
    password: "",
    password_confirmation: "",
})

const errors = ref({
    current_password: [],
    password: [],
})

function submitForm() {
    const formData = new FormData();
    formData.append('password', data.value.password);
    formData.append('current_password', data.value.current_password);
    formData.append('password_confirmation', data.value.password_confirmation);
    formData.append('_method', 'put')
    axiosClient.post("/password", formData).then((response) => {
        window.location.reload();
    })
        .catch((error) => {
            errors.value = error.response.data.errors;
        })
}
</script>

<template>
    <div class="my-5"></div>
    <div
        class="flex min-h-4/5 flex-col rounded-lg justify-center px-6 py-12 lg:px-8 w-xl mx-auto border-2 border-gray-100 hover:border-gray-200 shadow-xl hover:shadow-2xl transition duration-300 max-h-10">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto scale-300" src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png"
                 alt="Your Company">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Change Password of Platform</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm drop-shadow-lg">
            <form class="space-y-6" @submit.prevent="submitForm">
                <div>
                    <div class="mt-2">
                        <label for="current_password" class="block text-sm/6 font-medium text-gray-900">Current Password</label>
                        <input type="password" name="current_password" id="current_password" v-model="data.current_password"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base mt-1 text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                    <p class="text-red-500 text-sm">
                        {{ errors.current_password ? errors.current_password[0] : '' }}
                    </p>
                </div>
                <div>
                    <div class="mt-2">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">New Password</label>
                        <input type="password" name="password" id="password" v-model="data.password"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base mt-1 text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                    <p class="text-red-500 text-sm">
                        {{ errors.password ? errors.password[0] : '' }}
                    </p>
                </div>
                <div>
                    <div class="mt-2">
                        <label for="confirm_password" class="block text-sm/6 font-medium text-gray-900">Confirm
                            Password</label>
                        <input type="password" name="confirm_password" id="confirm_password"
                               v-model="data.password_confirmation"
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base mt-1 text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-400 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300 ease-in-out ">
                        Change password
                    </button>
                </div>
                <div>
                    <router-link :to="{name: 'Dashboard'}"
                            class="flex w-full justify-center rounded-md bg-gray-400 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-gray-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-600 transition duration-300 ease-in-out ">
                        Back to Dashboard
                    </router-link>
                </div>
            </form>

        </div>
    </div>

</template>

<style scoped>

</style>
