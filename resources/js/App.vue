<script setup>

</script>

<template>
    <router-view v-slot="{ Component, route }">
        <div :key="route.name">
            <Component :is="Component" />
        </div>
    </router-view>
    <footer class="w-full text-center bg-white rounded-lg shadow-sm m-4">
        <small>&copy; 2024 Your Company, Inc. All rights reserved.</small>
    </footer>
</template>

<style scoped>

</style>
