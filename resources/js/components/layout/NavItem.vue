<script setup lang="ts">
import { useRoute, RouterLink } from 'vue-router';

const route = useRoute();

defineProps<{
    routeName: string;
    pageTitle: string;
}>();
</script>

<template>
    <li class="nav-item">
        <RouterLink :class="{ 'nav-link': true, active: route.name === routeName }" :to="{ name: routeName }">
            {{ pageTitle }}
        </RouterLink>
    </li>
</template>
