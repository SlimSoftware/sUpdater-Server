<script setup lang="ts">
import { RouterView, useRouter } from 'vue-router';
import NavBar from './components/layout/NavBar.vue';
import { useAuthStore } from './stores/auth';
import { onMounted } from 'vue';
import { useGlobalStore } from './stores/global';
import Toast from './components/Toast.vue';
import Loader from './components/Loader.vue';

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
    <Toast />

    <main class="container my-3 min-h-100">
        <h1 class="d-inline">{{ globalStore.pageTitle }}</h1>
        <Loader v-if="globalStore.isLoading" />
        <RouterView class="mt-2" />
    </main>
</template>
