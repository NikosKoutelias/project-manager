<script setup>
import {Disclosure, Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue'
import axiosClient from "../axios.js";
import router from "../router.js";
import useUserStore from "../store/user.js";
import {computed} from "vue";

const userStore = useUserStore()

const user = computed(() => userStore.user)

const userNavigation = [
    {name: 'Your Profile', to: {name: 'Profile'}},
    {name: 'Settings', to: {name: 'Settings'}},
    {name: 'Sign out', to: {name: 'SignOut'}},
]

let navigation = [
    {name: 'Dashboard', to: {name: 'Dashboard'}, current: true},
    {name: 'Companies', to: {name: 'Companies'}, current: false},
    {name: 'Projects', to: {name: 'Projects'}, current: false},
    {name: 'Reports', to: {name: 'Reports'}, current: false},
]

function logout() {
    axiosClient.post('/logout').then((response) => {
        router.push({name: 'Home'});
    })
}
</script>

<template>
    <div class="min-h-full">
        <Disclosure as="nav" class="bg-gray-800">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-16 items-center justify-between">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <img class="size-8 scale-200"
                                 src="https://cdn-icons-png.flaticon.com/512/11494/11494548.png"
                                 alt="Your Company"/>
                        </div>
                        <div class="hidden md:block">
                            <div class="ml-10 flex items-baseline space-x-4">
                                <router-link v-for="item in navigation" :key="item.name" :to="item.to"
                                             :class="[$route.name === item.to.name ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']"
                                             :aria-current="item.current ? 'page' : undefined">{{ item.name }}
                                </router-link>
                                <router-link :to="{name: 'Users'}" v-if="user.role === 'ADMIN'"  :class="[$route.name === 'Users' ? 'bg-gray-900 text-white' : 'text-gray-300 hover:bg-gray-700 hover:text-white', 'rounded-md px-3 py-2 text-sm font-medium']">Users</router-link>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Profile dropdown -->
                            <Menu as="div" class="relative ml-3">
                                <div>
                                    <MenuButton
                                        class="relative flex max-w-xs items-center rounded-full bg-gray-800 text-sm focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800 focus:outline-hidden">
                                        <span class="absolute -inset-1.5"/>
                                        <span class="sr-only">Open user menu</span>
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
                                                class="w-full text-sm py-2 bg-gray-200 hover:bg-gray-300 cursor-pointer"
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

        <header class="bg-white shadow-sm">
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
</template>
