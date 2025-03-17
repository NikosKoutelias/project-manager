<script setup>

</script>

<template>
    <router-view v-slot="{ Component, route }">
        <div :key="route.name">
            <Component :is="Component" />
        </div>
    </router-view>
    <footer class="w-full text-center bg-white flex justify-center ">
        <div class="relative size-56">
            <div class="absolute inset-x-0 bottom-0 h-16"><small>&copy; 2024 Your Company, Inc. All rights reserved.</small></div>
        </div>
    </footer>
</template>

<style scoped>

</style>
