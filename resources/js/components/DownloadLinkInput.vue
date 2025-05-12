<template>
    <URLInput v-model="downloadLink" label="Download link" :preview-url="previewDownloadLink" />

    <span class="text-muted" :style="previewHintContainerStyle">Preview: {{ previewDownloadLink }} </span>
    <AvailableVariablesExpander :variables="variables" />
</template>

<script lang="ts" setup>
import { computed } from 'vue';
import { parseText, containsVariables } from '../variable-parser';
import AvailableVariablesExpander from './AvailableVariablesExpander.vue';
import URLInput from './URLInput.vue';

const props = defineProps<{
    version?: string;
}>();

const downloadLink = defineModel<string>();

const variables = computed(() => {
    return {
        ver: props.version ? props.version : '',
        'ver.0': props.version ? props.version.replaceAll('.', '') : '',
        'ver.1': props.version ? splitVersion(props.version, 2) : '',
        'ver.2': props.version ? splitVersion(props.version, 3) : '',
        'ver.3': props.version ? splitVersion(props.version, 4) : ''
    };
});

function splitVersion(version: string, digits: number) {
    const numbers = version.split('.', digits);
    return numbers.join('.');
}

const previewDownloadLink = computed(() => {
    if (downloadLink.value !== undefined) {
        return parseText(downloadLink.value, variables.value);
    }
    return '';
});

const previewHintContainerStyle = computed(() => {
    let displayValue = 'none';

    if (downloadLink.value !== undefined && containsVariables(downloadLink.value, variables.value)) {
        displayValue = 'block';
    }

    return { display: displayValue };
});
</script>
