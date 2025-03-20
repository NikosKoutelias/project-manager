<script setup>
import {UserCircleIcon} from '@heroicons/vue/24/solid'
import {ChevronDownIcon} from '@heroicons/vue/16/solid'
import useCountryStore from "../store/countries.js";

const countryStore = useCountryStore()
const countries = countryStore.countries

</script>

<template>
    <form>
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base/7 font-semibold text-gray-900">Personal Information</h2>
                <p class="mt-1 text-sm/6 text-gray-600">Your personal information and preference.</p>

                <div class="mt-10 grid grid-cols- gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                        <div class="mt-2">
                            <div
                                class="flex items-center rounded-md bg-gray-100 pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2 focus-within:outline-indigo-600">
                                <div class="shrink-0 text-base  text-gray-500 select-none sm:text-sm/6"></div>
                                <input type="email" disabled name="email" id="email"
                                       class="block min-w-0 grow py-1.5 pr-3 pl-1 text-base  text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                       placeholder="janesmith@xx.xx"/>
                            </div>
                        </div>
                        <div class="sm:col-span-3">
                            <label for="role" class="block text-sm/6 font-medium text-gray-900">Role</label>
                            <div class="mt-2 grid grid-cols-1">
                                <select id="role" name="role" disabled
                                        class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-gray-100 py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                                    <option>Admin</option>
                                    <option>User</option>
                                </select>
                                <ChevronDownIcon
                                    class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                                    aria-hidden="true"/>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-full">
                        <label for="about" class="block text-sm/6 font-medium text-gray-900">About</label>
                        <div class="mt-2">
                            <textarea name="about" id="about" rows="3"
                                      class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                        </div>
                        <p class="mt-3 text-sm/6 text-gray-600">Write a few sentences about your preferred data
                            view.</p>
                    </div>

                    <div class="col-span-full">
                        <label for="photo" class="block text-sm/6 font-medium text-gray-900">Photo</label>
                        <div class="mt-2 flex items-center gap-x-3">
                            <UserCircleIcon class="size-12 text-gray-300" aria-hidden="true"/>
                            <label for="file-upload"
                                   class="relative cursor-pointer rounded-md text-sm bg-gray-100 hover:bg-gray-300 transition duration-500 p-2 font-semibold">
                                <span>Change</span>
                                <input id="file-upload" name="file-upload" type="file" class="sr-only"/>
                            </label>
                            <p class="text-xs/5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-b border-gray-900/10 pb-12">
                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="full-name" class="block text-sm/6 font-medium text-gray-900">Full Name</label>
                        <div class="mt-2">
                            <input type="text" name="full-name" id="full-name" autocomplete="given-name"
                                   class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6"/>
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2 sm:col-start-1"
                     v-if="countries">
                    <label for="city"
                           class="block text-sm/6 font-medium text-gray-900">Country
                        of operation</label>
                    <div class="mt-2 grid grid-cols-1">
                        <select id="country_of_operation"
                                name="country_of_operation"

                                class="col-start-1 row-start-1 w-full appearance-none rounded-md py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            <option disabled value="">Select a country</option>
                            <option v-for="(key, country) in countries"
                                    :value="country">
                                {{ key }}
                            </option>
                        </select>
                        <ChevronDownIcon
                            class="pointer-events-none col-start-1 row-start-1 mr-2 size-5 self-center justify-self-end text-gray-500 sm:size-4"
                            aria-hidden="true"/>
                        <p class="text-red-500 text-sm">
<!--                            {{ errors.country_of_operation ? errors.country_of_operation[0] : '' }}-->
                        </p>
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
        </div>
    </form>
</template>
