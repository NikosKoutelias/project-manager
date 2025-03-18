<script setup>

import {onMounted, ref, watch} from "vue";
import axiosClient from "../axios.js";
import CreateModal from "../Widgets/CreateModal.vue";

const companies = ([])

onMounted(() => {
    axiosClient.get('/api/company').then((response) => {
        console.log(response.data)
        companies.value = response.data;
    })

})
const isModalOpen = ref(false)
function toggle() {
    isModalOpen.value = !isModalOpen.value;
}

</script>

<template>
    <button @click="toggle"
            class="rounded-md float-end bg-indigo-400 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition duration-300 ease-in-out">
        Create Company
    </button>
    <CreateModal v-if="isModalOpen" v-bind:label="'Company'"></CreateModal>
    <section>
        <div class="grid">
            <div class="card bg-gray-50" v-for="company in companies">
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
            </div>
        </div>
    </section>
</template>


<style scoped>
section {
    --text-color: #A1A1AA;
    --card-background-color: rgba(255, 255, 255, .015);
    --card-border-color: rgba(255, 255, 255, 0.1);
    --card-box-shadow-1: rgba(0, 0, 0, 0.05);
    --card-box-shadow-1-y: 3px;
    --card-box-shadow-1-blur: 6px;
    --card-box-shadow-2: rgba(0, 0, 0, 0.1);
    --card-box-shadow-2-y: 8px;
    --card-box-shadow-2-blur: 15px;
    --card-label-color: #FFFFFF;
    --card-icon-color: #D4D4D8;
    --card-icon-background-color: rgba(255, 255, 255, 0.08);
    --card-icon-border-color: rgba(255, 255, 255, 0.12);
    --card-shine-opacity: .1;
    --card-shine-gradient: conic-gradient(from 205deg at 50% 50%, rgba(16, 185, 129, 0) 0deg, #10B981 25deg, rgba(52, 211, 153, 0.18) 295deg, rgba(16, 185, 129, 0) 360deg);
    --card-line-color: #2A2B2C;
    --card-tile-color: rgba(16, 185, 129, 0.05);
    --card-hover-border-color: rgba(255, 255, 255, 0.2);
    --card-hover-box-shadow-1: rgba(0, 0, 0, 0.04);
    --card-hover-box-shadow-1-y: 5px;
    --card-hover-box-shadow-1-blur: 10px;
    --card-hover-box-shadow-2: rgba(0, 0, 0, 0.3);
    --card-hover-box-shadow-2-y: 15px;
    --card-hover-box-shadow-2-blur: 25px;
    --card-hover-icon-color: #34D399;
    --card-hover-icon-background-color: rgba(52, 211, 153, 0.1);
    --card-hover-icon-border-color: rgba(52, 211, 153, 0.2);
    --blur-opacity: .01;
}

section.toggle .grid * {
    transition-duration: 0s !important;
}

.grid {
    display: grid;
    grid-template-columns: repeat(3, 300px);
    grid-gap: 32px;
    position: relative;
    z-index: 1;
}

.card {
    box-shadow: 0px var(--card-box-shadow-1-y) var(--card-box-shadow-1-blur) var(--card-box-shadow-1), 0px var(--card-box-shadow-2-y) var(--card-box-shadow-2-blur) var(--card-box-shadow-2), 0 0 0 1px var(--card-border-color);
    padding: 56px 16px 16px 16px;
    border-radius: 15px;
    cursor: pointer;
    position: relative;
    transition: box-shadow 0.25s;
}

.card::before {
    content: "";
    position: absolute;
    inset: 0;
    border-radius: 15px;
    background-color: var(--card-background-color);
}

.card .icon {
    z-index: 2;
    position: relative;
    display: table;
    padding: 8px;
}

.card .icon::after {
    content: "";
    position: absolute;
    inset: 4.5px;
    border-radius: 50%;
    background-color: var(--card-icon-background-color);
    border: 1px solid var(--card-icon-border-color);
    -webkit-backdrop-filter: blur(2px);
    backdrop-filter: blur(2px);
    transition: background-color 0.25s, border-color 0.25s;
}

.card .icon svg {
    position: relative;
    z-index: 1;
    display: block;
    width: 24px;
    height: 24px;
    transform: translateZ(0);
    color: var(--card-icon-color);
    transition: color 0.25s;
}

.card h4 {
    z-index: 2;
    position: relative;
    margin: 12px 0 4px 0;
    font-family: inherit;
    font-weight: 600;
    font-size: 14px;
    line-height: 2;
}

.card p {
    z-index: 2;
    position: relative;
    margin: 0;
    font-size: 14px;
    line-height: 1.7;
    color: var(--text-color);
}

.card .shine {
    border-radius: inherit;
    position: absolute;
    inset: 0;
    z-index: 1;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.5s;
}

.card .shine:before {
    content: "";
    width: 150%;
    padding-bottom: 150%;
    border-radius: 50%;
    position: absolute;
    left: 50%;
    bottom: 55%;
    filter: blur(35px);
    opacity: var(--card-shine-opacity);
    transform: translateX(-50%);
    background-image: var(--card-shine-gradient);
}

.card .background {
    border-radius: inherit;
    position: absolute;
    inset: 0;
    overflow: hidden;
    mask-image: radial-gradient(circle at 60% 5%, black 0%, black 15%, transparent 60%);
}

.card .background .tiles {
    opacity: 0;
    transition: opacity 0.25s;
}

.card .background .tiles .tile {
    position: absolute;
    background-color: var(--card-tile-color);
    -webkit-animation-duration: 8s;
    animation-duration: 8s;
    -webkit-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    opacity: 0;
}

.card .background .tiles .tile.tile-4, .card .background .tiles .tile.tile-6, .card .background .tiles .tile.tile-10 {
    -webkit-animation-delay: -2s;
    animation-delay: -2s;
}

.card .background .tiles .tile.tile-3, .card .background .tiles .tile.tile-5, .card .background .tiles .tile.tile-8 {
    -webkit-animation-delay: -4s;
    animation-delay: -4s;
}

.card .background .tiles .tile.tile-2, .card .background .tiles .tile.tile-9 {
    -webkit-animation-delay: -6s;
    animation-delay: -6s;
}

.card .background .tiles .tile.tile-1 {
    top: 0;
    left: 0;
    height: 10%;
    width: 22.5%;
}

.card .background .tiles .tile.tile-2 {
    top: 0;
    left: 22.5%;
    height: 10%;
    width: 27.5%;
}

.card .background .tiles .tile.tile-3 {
    top: 0;
    left: 50%;
    height: 10%;
    width: 27.5%;
}

.card .background .tiles .tile.tile-4 {
    top: 0;
    left: 77.5%;
    height: 10%;
    width: 22.5%;
}

.card .background .tiles .tile.tile-5 {
    top: 10%;
    left: 0;
    height: 22.5%;
    width: 22.5%;
}

.card .background .tiles .tile.tile-6 {
    top: 10%;
    left: 22.5%;
    height: 22.5%;
    width: 27.5%;
}

.card .background .tiles .tile.tile-7 {
    top: 10%;
    left: 50%;
    height: 22.5%;
    width: 27.5%;
}

.card .background .tiles .tile.tile-8 {
    top: 10%;
    left: 77.5%;
    height: 22.5%;
    width: 22.5%;
}

.card .background .tiles .tile.tile-9 {
    top: 32.5%;
    left: 50%;
    height: 22.5%;
    width: 27.5%;
}

.card .background .tiles .tile.tile-10 {
    top: 32.5%;
    left: 77.5%;
    height: 22.5%;
    width: 22.5%;
}

@-webkit-keyframes tile {
    0%, 12.5%, 100% {
        opacity: 1;
    }
    25%, 82.5% {
        opacity: 0;
    }
}

@keyframes tile {
    0%, 12.5%, 100% {
        opacity: 1;
    }
    25%, 82.5% {
        opacity: 0;
    }
}

.card .background .line {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 0.35s;
}

.card .background .line:before, .card .background .line:after {
    content: "";
    position: absolute;
    background-color: var(--card-line-color);
    transition: transform 0.35s;
}

.card .background .line:before {
    left: 0;
    right: 0;
    height: 1px;
    transform-origin: 0 50%;
    transform: scaleX(0);
}

.card .background .line:after {
    top: 0;
    bottom: 0;
    width: 1px;
    transform-origin: 50% 0;
    transform: scaleY(0);
}

.card .background .line.line-1:before {
    top: 10%;
}

.card .background .line.line-1:after {
    left: 22.5%;
}

.card .background .line.line-1:before, .card .background .line.line-1:after {
    transition-delay: 0.3s;
}

.card .background .line.line-2:before {
    top: 32.5%;
}

.card .background .line.line-2:after {
    left: 50%;
}

.card .background .line.line-2:before, .card .background .line.line-2:after {
    transition-delay: 0.15s;
}

.card .background .line.line-3:before {
    top: 55%;
}

.card .background .line.line-3:after {
    right: 22.5%;
}

.card:hover {
    box-shadow: 0px 3px 6px var(--card-hover-box-shadow-1), 0px var(--card-hover-box-shadow-2-y) var(--card-hover-box-shadow-2-blur) var(--card-hover-box-shadow-2), 0 0 0 1px var(--card-hover-border-color);
}

.card:hover .icon::after {
    background-color: var(--card-hover-icon-background-color);
    border-color: var(--card-hover-icon-border-color);
}

.card:hover .icon svg {
    color: var(--card-hover-icon-color);
}

.card:hover .shine {
    opacity: 1;
    transition-duration: 0.5s;
    transition-delay: 0s;
}

.card:hover .background .tiles {
    opacity: 1;
    transition-delay: 0.25s;
}

.card:hover .background .tiles .tile {
    -webkit-animation-name: tile;
    animation-name: tile;
}

.card:hover .background .line {
    opacity: 1;
    transition-duration: 0.15s;
}

.card:hover .background .line:before {
    transform: scaleX(1);
}

.card:hover .background .line:after {
    transform: scaleY(1);
}

.card:hover .background .line.line-1:before, .card:hover .background .line.line-1:after {
    transition-delay: 0s;
}

.card:hover .background .line.line-2:before, .card:hover .background .line.line-2:after {
    transition-delay: 0.15s;
}

.card:hover .background .line.line-3:before, .card:hover .background .line.line-3:after {
    transition-delay: 0.3s;
}

.day-night input {
    display: none;
}

.day-night input + div {
    border-radius: 50%;
    width: 20px;
    height: 20px;
    position: relative;
    box-shadow: inset 8px -8px 0 0 var(--text-color);
    transform: scale(1) rotate(-2deg);
    transition: box-shadow 0.5s ease 0s, transform 0.4s ease 0.1s;
}

.day-night input + div:before {
    content: "";
    width: inherit;
    height: inherit;
    border-radius: inherit;
    position: absolute;
    left: 0;
    top: 0;
    transition: background-color 0.3s ease;
}

.day-night input + div:after {
    content: "";
    width: 6px;
    height: 6px;
    border-radius: 50%;
    margin: -3px 0 0 -3px;
    position: absolute;
    top: 50%;
    left: 50%;
    box-shadow: 0 -23px 0 var(--text-color), 0 23px 0 var(--text-color), 23px 0 0 var(--text-color), -23px 0 0 var(--text-color), 15px 15px 0 var(--text-color), -15px 15px 0 var(--text-color), 15px -15px 0 var(--text-color), -15px -15px 0 var(--text-color);
    transform: scale(0);
    transition: all 0.3s ease;
}

.day-night input:checked + div {
    box-shadow: inset 20px -20px 0 0 var(--text-color);
    transform: scale(0.5) rotate(0deg);
    transition: transform 0.3s ease 0.1s, box-shadow 0.2s ease 0s;
}

.day-night input:checked + div:before {
    background: var(--text-color);
    transition: background-color 0.3s ease 0.1s;
}

.day-night input:checked + div:after {
    transform: scale(1);
    transition: transform 0.5s ease 0.15s;
}

html {
    box-sizing: border-box;
    -webkit-font-smoothing: antialiased;
}

* {
    box-sizing: inherit;
}

*:before, *:after {
    box-sizing: inherit;
}

section {
    min-height: 60vh;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: hidden;
}

section:before {
    content: "";
    position: absolute;
    opacity: var(--blur-opacity);
}
</style>
