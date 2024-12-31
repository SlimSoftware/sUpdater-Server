<script setup lang="ts">
import { RouterView, useRouter } from 'vue-router';
import NavBar from './components/layout/NavBar.vue';
import { useAuthStore } from './stores/auth';
import { onMounted } from 'vue';
import { useGlobalStore } from './stores/global';

const router = useRouter();

const authStore = useAuthStore();
const globalStore = useGlobalStore();

onMounted(async () => {
    const authenticated = await authStore.checkAuth();

    if (!authenticated) {
        router.replace('login');
    } else {
        await authStore.getUser();
    }
});
</script>

<template>
    <NavBar />

    <main class="container mt-2">
        <h1 class="d-inline">{{ globalStore.pageTitle }}</h1>
        <RouterView />
    </main>
</template>
