<template>
    <URLInput v-model="downloadLink" label="Download link" :preview-url="previewDownloadLink" />
    <span class="text-muted" :style="previewHintContainerStyle">Preview: {{ previewDownloadLink }}</span>
    <AvailableVariablesExpander :variables="variables" />
</template>

<script lang="ts" setup>
import { type VariablesMap, getParsedValue, containsVariables } from '@/variable-parser';
import { computed } from 'vue';
import URLInput from './URLInput.vue';
import AvailableVariablesExpander from './AvailableVariablesExpander.vue';

const props = defineProps<{
    version?: string;
    variables: VariablesMap;
}>();

const downloadLink = defineModel<string>();

const previewDownloadLink = computed(() => getParsedValue(downloadLink.value, props.variables));

const previewHintContainerStyle = computed(() => {
    let displayValue = 'none';

    if (downloadLink.value !== undefined && containsVariables(downloadLink.value, props.variables)) {
        displayValue = 'block';
    }

    return { display: displayValue };
});
</script>
