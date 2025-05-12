<template>
    <a class="text-black" v-if="previewUrl || url" :href="href" target="_blank">{{ label }}</a>
    <span v-else>{{ label }}</span>

    <input v-model="url" type="text" class="form-control" required />
</template>

<script setup lang="ts">
import { computed } from 'vue';

const url = defineModel<string>();

const href = computed(() => {
    const link = props.previewUrl ?? url.value;
    return `${link}`;
});

const props = defineProps<{
    previewUrl?: string;
    label: string;
}>();
</script>
