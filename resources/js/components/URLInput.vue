<template>
    <a class="text-black" v-if="isUrl" :href="href" target="_blank">{{ label }}</a>
    <span v-else>{{ label }}</span>

    <input v-model="url" type="text" class="form-control" :required />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { isValidUrl } from '../utils/url';

const url = defineModel<string>();

const href = computed(() => {
    const link = props.previewUrl ?? url.value;
    return `${link}`;
});

const isUrl = computed(() => {
    return isValidUrl(url.value ?? props.previewUrl);
});

const props = defineProps<{
    previewUrl?: string;
    label: string;
    required?: boolean;
}>();
</script>
