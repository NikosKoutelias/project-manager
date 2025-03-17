<script>

import {ref} from "vue"
import axiosClient from "../axios.js";

const data = ref({
    email: "",
    password: "",
    passwordConfirmation: "",
    firstName: "",
    lastName: "",
})

function submit() {
    axiosClient.post("/register", data)
}
</script>

<template>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto scale-300" src="https://cdn-icons-png.flaticon.com/512/2921/2921222.png" alt="Your Company">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Register to Platform</h2>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm drop-shadow-lg">
            <form class="space-y-6" @submit.prevent="submit">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" v-model="data.email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                </div>

                <div>
                    <label for="first_name" class="block text-sm/6 font-medium text-gray-900">First Name</label>
                    <div class="mt-2">
                        <input type="text" v-model="data.firstName" name="first_name" id="first_name" autocomplete="first_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                </div>

                <div>
                    <label for="last_name" class="block text-sm/6 font-medium text-gray-900">Last Name</label>
                    <div class="mt-2">
                        <input type="text" v-model="data.lastName" name="last_name" id="last_name" autocomplete="last_name" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                </div>
                <div>
                    <div class="mt-2">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                        <input type="password" name="password" id="password" v-model="data.password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base mt-1 text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                </div>
                <div>
                    <div class="mt-2">
                        <label for="confirm_password" class="block text-sm/6 font-medium text-gray-900">Confirm Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" v-model="data.passwordConfirmation" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base mt-1 text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-400 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300 ease-in-out ">Sign in</button>
                </div>
            </form>

        </div>
    </div>

</template>

<style scoped>

</style>
