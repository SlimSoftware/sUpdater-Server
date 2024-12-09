<script setup lang="ts">
import { RouterView } from 'vue-router';
import NavBar from './components/layout/NavBar.vue';
import { useAuthStore } from './stores/auth';

const authStore = useAuthStore();

authStore.checkAuth();
</script>

<template>
    <NavBar />
    <RouterView />
</template>
