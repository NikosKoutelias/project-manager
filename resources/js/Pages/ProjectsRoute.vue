<script setup>

import {ref} from "vue";
import CreateModal from "../Widgets/CreateModal.vue";
import useProjectStore from "../store/projects.js";
import useCompanyStore from "../store/companies.js";

const projectStore = useProjectStore()
const companyStore = useCompanyStore()

const projects = projectStore.projects
const companies = companyStore.companies

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
    <button @click="toggle"
            class="rounded-md float-end px-3 py-2 text-sm font-semibold text-white shadow-xs bg-indigo-400 hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300 ease-in-out">
        Create Project
    </button>
    <button type="text" class=" mt-1 float-end" v-on:click="reload">
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

    <CreateModal v-if="isModalOpen" :label="'Project'" :companies="companies" :destination="$route.name"></CreateModal>
    <section>
        <div class="grid">
            <div class="card bg-gray-50" v-for="project in projects">
                <span class="icon">
                  <svg
                      viewBox="0 0 100 120"
                      fill="none"
                      stroke="currentColor"
                      stroke-width="1.5"
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      xmlns="http://www.w3.org/2000/svg"
                  >
                    <path
                        d="M67.02,12.99c-0.3,0-0.59-0.05-0.86-0.15c-1.42,0-2.58-1.16-2.58-2.58v-5.1h-25.1v5.1c0,1.34-1.02,2.44-2.33,2.57 c-0.28,0.1-0.58,0.16-0.89,0.16h-9.44v10.53h49.56V12.99H67.02L67.02,12.99z M70.57,122.2c-0.46,0.42-1.07,0.68-1.74,0.68 c-0.14,0-0.27-0.01-0.4-0.03l-62.69,0v0.01c-1.56,0-3-0.65-4.05-1.69h0l0-0.01l-0.01,0l-0.01-0.01C0.64,120.11,0,118.68,0,117.12 V20.24c0-1.58,0.65-3.02,1.69-4.06c1.04-1.04,2.48-1.69,4.06-1.69h14.92v-2.82c0-1.05,0.43-2.01,1.13-2.71l0,0l0.01-0.01l0.01-0.01 c0.7-0.69,1.66-1.12,2.71-1.12h8.81V4.27c0-1.17,0.48-2.23,1.25-3.01l0.01-0.01h0C35.36,0.48,36.42,0,37.59,0h26.89 c1.17,0,2.23,0.48,3.01,1.26l0.01-0.01c0.77,0.77,1.25,1.84,1.25,3.02v3.56h7.94c1.05,0,2.01,0.43,2.71,1.13l0.01,0.01l0.01,0.01 l0.01,0.01c0.69,0.7,1.12,1.66,1.12,2.71v2.82h14.92c1.57,0,3.01,0.65,4.05,1.69l0.01-0.01c1.04,1.04,1.69,2.48,1.69,4.06v69.18 c0.05,0.21,0.08,0.42,0.08,0.64c0,0.78-0.34,1.47-0.89,1.95l-29.62,30C70.72,122.08,70.64,122.14,70.57,122.2L70.57,122.2z M66.25,117.71V95.27c0-2.14,0.88-4.09,2.29-5.5c1.41-1.41,3.36-2.29,5.5-2.29h22.01V20.24c0-0.16-0.07-0.3-0.17-0.41l0.01-0.01 l-0.01,0c-0.1-0.1-0.25-0.16-0.41-0.16H80.55v5.17c0,1.05-0.43,2.01-1.13,2.71l-0.01,0l-0.01,0.01l-0.01,0.01 c-0.7,0.69-1.66,1.12-2.71,1.12H24.52c-1.06,0-2.03-0.43-2.72-1.13c-0.08-0.08-0.16-0.17-0.22-0.26c-0.56-0.67-0.91-1.54-0.91-2.47 v-5.17H5.74c-0.16,0-0.3,0.07-0.41,0.17c-0.11,0.11-0.17,0.25-0.17,0.41v96.87c0,0.16,0.06,0.31,0.17,0.41h0l0.01,0.01 c0.1,0.1,0.25,0.17,0.41,0.17v0.01L66.25,117.71L66.25,117.71z M71.41,95.27v18.78l21.14-21.41H74.03c-0.72,0-1.38,0.3-1.85,0.77 C71.7,93.89,71.41,94.55,71.41,95.27L71.41,95.27z M21.27,84.65c-1.43,0-2.58-1.16-2.58-2.58c0-1.43,1.16-2.58,2.58-2.58h45.4 c1.42,0,2.58,1.16,2.58,2.58c0,1.42-1.16,2.58-2.58,2.58H21.27L21.27,84.65z M21.27,50.08c-1.43,0-2.58-1.16-2.58-2.58 c0-1.42,1.16-2.58,2.58-2.58h58.67c1.43,0,2.58,1.16,2.58,2.58c0,1.42-1.16,2.58-2.58,2.58H21.27L21.27,50.08z M21.27,67.36 c-1.43,0-2.58-1.16-2.58-2.58c0-1.42,1.16-2.58,2.58-2.58h58.67c1.43,0,2.58,1.16,2.58,2.58c0,1.43-1.16,2.58-2.58,2.58H21.27 L21.27,67.36z"
                    />
                  </svg>
                </span>
                <h4>{{ project.name }}</h4>
                <p>
                    {{ project.description }}
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
            </div>
        </div>
    </section>
</template>


<style scoped>
@import "../../css/data_display.css";
</style>
