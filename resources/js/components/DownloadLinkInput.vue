<template>
    <label for="dlInput">Download link</label>
    <div class="input-group">
        <input id="dlInput" v-model="downloadLink" type="text" class="form-control" name="downloadLink" required />
        <a class="btn btn-primary" @click="openDownloadLink">Test link</a>
    </div>
    <span class="text-muted" :style="previewHintContainerStyle">Preview: {{ previewDownloadLink }} </span>
    <AvailableVariablesExpander :variables="variables" :variable-indicator="variableIndicator" />
</template>

<script lang="ts" setup>
import { ref, computed, watch } from 'vue';
import { parseText, containsVariables } from '../variable-parser';
import AvailableVariablesExpander from './AvailableVariablesExpander.vue';

const props = defineProps({
    version: String,
    modelValue: String,
});
const emit = defineEmits(['update:modelValue']);

const downloadLink = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit('update:modelValue', value);
    },
});

const variables = ref(getVariables());
const variableIndicator = '%';

function getVariables() {
    return {
        ver: props.version ? props.version : '',
        'ver.0': props.version ? props.version.replaceAll('.', '') : '',
        'ver.1': props.version ? splitVersion(props.version, 2) : '',
        'ver.2': props.version ? splitVersion(props.version, 3) : '',
        'ver.3': props.version ? splitVersion(props.version, 4) : '',
    };
}

function splitVersion(version: string, digits: number) {
    let newVersion = '';
    let numbers = version.split('.', digits);
    for (let i = 0; i < digits; i++) {
        if (numbers[i] === undefined) {
            break;
        }

        newVersion += numbers[i];

        if (i < digits - 1) {
            newVersion += '.';
        }
    }

    return newVersion;
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

watch(
    () => props.version,
    () => {
        variables.value = getVariables();
    },
);

function openDownloadLink() {
    window.open(previewDownloadLink.value, '_blank');
}
</script>
