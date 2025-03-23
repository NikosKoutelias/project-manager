<script setup>

import {Disclosure, Menu, MenuButton, MenuItem, MenuItems} from "@headlessui/vue";
import useUserStore from "../../store/user.js";
import {computed} from "vue";
import axiosClient from "../../axios.js";
import router from "../../router.js";

const userStore = useUserStore()
const user = computed(() => userStore.user)

const userNavigation = [
    {name: 'Your Profile', to: {name: 'Profile'}},
    {name: 'Settings', to: {name: 'Settings'}},
    {name: 'Sign out', to: {name: 'SignOut'}},
]
let navigation = [
    {name: 'Companies', to: {name: 'User Companies'}, current: false},
    {name: 'Projects', to: {name: 'User Projects'}, current: false},
    {name: 'Reports', to: {name: 'User Reports'}, current: false},
]

function logout() {
    axiosClient.post('/logout').then((response) => {
        router.push({name: 'Home'});
    })
}
</script>

<template>
    <div class="bg-white">
        <header class="absolute inset-x-0 top-0 z-50">
            <Disclosure as="nav" class="bg-stone-100 drop-shadow-xl">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 items-center justify-between">
                        <div class="flex items-center">
                            <router-link :to="{name: 'Administration'}" class="shrink-0">
                                <img class="size-8 scale-200"
                                     src="https://cdn-icons-png.flaticon.com/512/11494/11494548.png"
                                     alt="Your Company"/>
                            </router-link>
                            <div class="md:block">
                                <div class="ml-10 flex items-baseline space-x-4">
                                    <router-link v-for="item in navigation" :key="item.name" :to="item.to"
                                                 :class="[$route.name === item.to.name ? 'bg-gray-700 text-white' : 'text-gray-700 hover:bg-gray-400 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                                 :aria-current="item.current ? 'page' : undefined">{{ item.name }}
                                    </router-link>
                                    <router-link v-if="user.role === 'ADMIN'" :to="{name: 'Admin'}" class=" text-white' hover:bg-gray-400 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
                                        Admin
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <div class="md:block">
                            <div class="ml-4 flex items-center md:ml-6">
                                <!-- Profile dropdown -->
                                <Menu as="div" class="relative ml-3">
                                    <div>
                                        <MenuButton
                                            class="relative px-2 py-1 flex max-w-xs items-center rounded-full bg-indigo-400 text-sm hover:bg-indigo-500">
                                            <span class="absolute -inset-1.5"/>
                                            <img class="size-8 rounded-full"
                                                 :src="`https://randomuser.me/api/portraits/men/${Math.floor(Math.random() * 90)}.jpg`"
                                                 alt=""/>
                                            <span class="text-white ml-3">{{ user.name }}</span>
                                        </MenuButton>
                                    </div>
                                    <transition enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems
                                            class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 ring-1 shadow-lg ring-black/5 focus:outline-hidden">
                                            <MenuItem v-for="item in userNavigation" :key="item.name" v-slot="{ active }">
                                                <button
                                                    class="w-full text-sm py-2 bg-gray-300 hover:bg-gray-400 cursor-pointer"
                                                    v-if="item.name === 'Sign out'" v-on:click="logout">Sign Out
                                                </button>
                                                <router-link :to="item.to" v-else
                                                             :class="[active ? 'bg-gray-100 outline-hidden' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                                    {{
                                                        item.name
                                                    }}
                                                </router-link>
                                            </MenuItem>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </div>
                        </div>
                    </div>
                </div>
            </Disclosure>
        </header>

        <div class="relative isolate px-6 pt-14 lg:px-8">
            <div class="absolute inset-x-0 -top-40 -z-10 transform-gpu overflow-hidden blur-3xl sm:-top-80"
                 aria-hidden="true">
                <div
                    class="relative left-[calc(50%-11rem)] aspect-1155/678 w-[36.125rem] -translate-x-1/2 rotate-[30deg] bg-linear-to-tr from-[#ff80b5] to-[#9089fc] opacity-30 sm:left-[calc(50%-30rem)] sm:w-[72.1875rem]"
                    style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
            </div>
            <header class="bg-white shadow-xl shadow-pink-50 rounded-2xl  text-white">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <h1 class="text-3xl font-bold tracking-tight text-gray-900">{{ $route.name }}</h1>
                </div>
            </header>
            <main>
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <RouterView/>
                </div>
            </main>
        </div>
    </div>

</template>

<style scoped>

</style>
