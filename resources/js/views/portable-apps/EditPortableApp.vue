<script setup lang="ts">
import { useRoute } from 'vue-router';
import PortableAppForm from '../../components/forms/portable-apps/PortableAppForm.vue';

const route = useRoute();
const id = +route.params.id;
</script>

<template>
    <PortableAppForm :id />
</template>
