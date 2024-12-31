<script setup lang="ts">
import { useRoute } from 'vue-router';
import AppForm from '../../components/forms/app/AppForm.vue';

const route = useRoute();
const id = +route.params.id;
</script>

<template>
    <AppForm :id />
</template>
