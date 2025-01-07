<script setup lang="ts">
import { RouterLink } from 'vue-router';

defineProps<{
    routeName: string;
    pageTitle: string;
}>();
</script>

<template>
    <li class="nav-item">
        <RouterLink class="nav-link" :to="{ name: routeName }">
            {{ pageTitle }}
        </RouterLink>
    </li>
</template>
