<template>
    <a class="text-black" v-if="isUrl" :href="url" target="_blank">{{ label ?? url }}</a>
    <span v-else>{{ props.label }}</span>
</template>

<script setup lang="ts">
import { isValidUrl } from '@/utils/url';
import { computed } from 'vue';

const props = defineProps<{ label?: string; url: string }>();

const isUrl = computed(() => {
    return isValidUrl(props.url);
});
</script>
