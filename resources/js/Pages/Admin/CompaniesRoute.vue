<script setup>

import {ref} from "vue";
import CreateModal from "../../Widgets/CreateModal.vue";
import useCountryStore from "../../store/countries.js";
import useCompanyStore from "../../store/companies.js";
import useUserStore from "../../store/user.js";

const countryStore = useCountryStore()
const companyStore = useCompanyStore()
const userStore = useUserStore()

const countries = countryStore.countries
const companies = companyStore.companies
const user = userStore.user

const isModalOpen = ref(false)
function toggle() {
    isModalOpen.value = !isModalOpen.value;
}

function reload() {
    window.location.reload()
}
</script>

<template>
    <div class="container h-10 mb-2">
    <button @click="toggle" v-if="user.role === 'ADMIN'"
            class="rounded-md float-end bg-indigo-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300 ease-in-out">
        Create Company
    </button>
    <button type="text" class="float-end mt-1" v-on:click="reload">
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
    <CreateModal v-if="isModalOpen" :label="'Company'" :countries="countries" :destination="$route.name"></CreateModal>
    <section>
        <div class="grid">
            <router-link  :to="`/admin/company/${company.id}`" class="card bg-gray-50 lg:col-span-1 md:col-span-3" v-for="company in companies">
                <span class="icon">
                  <svg
                      viewBox="0 0 50 50"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="1.2"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                        d="M8 2L8 6L4 6L4 48L46 48L46 14L30 14L30 6L26 6L26 2 Z M 10 4L24 4L24 8L28 8L28 46L19 46L19 39L15 39L15 46L6 46L6 8L10 8 Z M 10 10L10 12L12 12L12 10 Z M 14 10L14 12L16 12L16 10 Z M 18 10L18 12L20 12L20 10 Z M 22 10L22 12L24 12L24 10 Z M 10 15L10 19L12 19L12 15 Z M 14 15L14 19L16 19L16 15 Z M 18 15L18 19L20 19L20 15 Z M 22 15L22 19L24 19L24 15 Z M 30 16L44 16L44 46L30 46 Z M 32 18L32 20L34 20L34 18 Z M 36 18L36 20L38 20L38 18 Z M 40 18L40 20L42 20L42 18 Z M 10 21L10 25L12 25L12 21 Z M 14 21L14 25L16 25L16 21 Z M 18 21L18 25L20 25L20 21 Z M 22 21L22 25L24 25L24 21 Z M 32 22L32 24L34 24L34 22 Z M 36 22L36 24L38 24L38 22 Z M 40 22L40 24L42 24L42 22 Z M 32 26L32 28L34 28L34 26 Z M 36 26L36 28L38 28L38 26 Z M 40 26L40 28L42 28L42 26 Z M 10 27L10 31L12 31L12 27 Z M 14 27L14 31L16 31L16 27 Z M 18 27L18 31L20 31L20 27 Z M 22 27L22 31L24 31L24 27 Z M 32 30L32 32L34 32L34 30 Z M 36 30L36 32L38 32L38 30 Z M 40 30L40 32L42 32L42 30 Z M 10 33L10 37L12 37L12 33 Z M 14 33L14 37L16 37L16 33 Z M 18 33L18 37L20 37L20 33 Z M 22 33L22 37L24 37L24 33 Z M 32 34L32 36L34 36L34 34 Z M 36 34L36 36L38 36L38 34 Z M 40 34L40 36L42 36L42 34 Z M 32 38L32 40L34 40L34 38 Z M 36 38L36 40L38 40L38 38 Z M 40 38L40 40L42 40L42 38 Z M 10 39L10 44L12 44L12 39 Z M 22 39L22 44L24 44L24 39 Z M 32 42L32 44L34 44L34 42 Z M 36 42L36 44L38 44L38 42 Z M 40 42L40 44L42 44L42 42Z"
                    />
                  </svg>
                </span>
                <h4>{{ company.name }}</h4>
                <p>
                    {{ company.description }}
                </p>
                <div class="shine"></div>
                <div class="background">
                    <div class="tiles">
                        <div class="tile tile-1"></div>
                        <div class="tile tile-2"></div>
                        <div class="tile tile-3"></div>
                        <div class="tile tile-4"></div>

                        <div class="tile tile-5"></div>
                        <div class="tile tile-6"></div>
                        <div class="tile tile-7"></div>
                        <div class="tile tile-8"></div>

                        <div class="tile tile-9"></div>
                        <div class="tile tile-10"></div>
                    </div>

                    <div class="line line-1"></div>
                    <div class="line line-2"></div>
                    <div class="line line-3"></div>
                </div>
            </router-link>
        </div>
    </section>
</template>


<style scoped>
@import "../../../css/data_display.css";
</style>
