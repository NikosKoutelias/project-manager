<script setup>
import axiosClient from "../axios.js";
import {ref} from "vue";
import router from "../router.js";


const data = ref({
    email: "",
    password: "",
})

const errorMessage = ref('')

function submitForm() {
    axiosClient.get('/sanctum/crsf-cookie').then((response) => {
        axiosClient.post("/login", data.value).then((response) => {
            router.push({name: 'Administration'});
        }).catch(error => {
            console.log(error.response);
            errorMessage.value = error.response.data.message;
        })
    })
}
</script>

<template>
    <div class="my-5"></div>
    <div
        class="flex min-h-4/5 flex-col rounded-lg justify-center px-6 py-12 lg:px-8 w-xl mx-auto border-2 border-gray-100 hover:border-gray-200 shadow-xl hover:shadow-2xl transition duration-300 max-h-10">
        <div class="sm:mx-auto sm:w-full sm:max-w-sm">
            <img class="mx-auto h-10 w-auto scale-300" src="https://cdn-icons-png.flaticon.com/512/11494/11494825.png"
                 alt="Your Company">
            <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>

            <div class="py-2 px-3 rounded text-white bg-red-400" v-if="errorMessage">{{ errorMessage }}</div>
        </div>

        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm drop-shadow-lg">
            <form class="space-y-6" @submit.prevent="submitForm">
                <div>
                    <label for="email" class="block text-sm/6 font-medium text-gray-900">Email address</label>
                    <div class="mt-2">
                        <input type="email" name="email" id="email" v-model="data.email" autocomplete="email" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                        <div class="text-sm">
                            <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                        </div>
                    </div>
                    <div class="mt-2">
                        <input type="password" name="password" v-model="data.password" id="password"
                               autocomplete="current-password" required
                               class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6 hover:drop-shadow-xl transition duration-400 ease-in-out">
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="flex w-full justify-center rounded-md bg-indigo-400 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-400 easy-in-out">
                        Sign in
                    </button>
                </div>
            </form>

            <p class="mt-10 text-center text-sm/6 text-gray-500">
                Not a member?
                <router-link :to="{name:'Register'}"
                             class="font-semibold text-indigo-400 hover:text-indigo-500 transition duration-300 ease-in-out">
                    Register HERE
                </router-link>
            </p>
        </div>
    </div>

</template>

<style scoped>

</style>
