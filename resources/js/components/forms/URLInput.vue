<template>
    <PreviewLink :url="previewUrl ?? url" :label />
    <input v-model="url" type="text" class="form-control" :required />
</template>

<script setup lang="ts">
import PreviewLink from '@/components/forms/PreviewLink.vue';

const url = defineModel<string>({ default: '' });

defineProps<{
    previewUrl?: string;
    label: string;
    required?: boolean;
}>();
</script>
