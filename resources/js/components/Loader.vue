<template>
    <div
        v-if="globalStore.isLoading"
        class="d-flex position-fixed top-0 start-0 w-100 h-100 justify-content-center align-items-center"
    >
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</template>

<script setup lang="ts">
import { useGlobalStore } from '../stores/global';

const globalStore = useGlobalStore();
</script>
