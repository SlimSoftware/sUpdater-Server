<template>
    <label for="dlInput">Download link</label>
    <div class="input-group">
        <input id="dlInput" v-model="downloadLink" type="text" class="form-control" name="downloadLink" required />
        <input id="fileInput" type="file" class="d-none" @change="uploadFile" />
        <button className="btn btn-primary" @click="uploadFileButtonClicked">Upload file</button>
    </div>
    <span class="text-muted" :style="previewHintContainerStyle"
        >Preview:
        <a class="btn-link" role="button" @click="openDownloadLink">{{ previewDownloadLink }}</a>
    </span>
    <AvailableVariablesExpander :variables="variables" :variable-indicator="variableIndicator" />
</template>

<script lang="ts" setup>
import { ref, computed, watch } from 'vue';
import { parseText, containsVariables } from '../variable-parser';
import AvailableVariablesExpander from './AvailableVariablesExpander.vue';
import api from '../api';

const props = defineProps({
    version: {
        type: String,
        default: '',
    },
    modelValue: {
        type: String,
        default: '',
    },
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

watch(
    () => props.version,
    () => {
        variables.value = getVariables();
    },
);

function openDownloadLink() {
    window.open(previewDownloadLink.value, '_blank');
}

function uploadFileButtonClicked() {
    const fileInput = document.querySelector('#fileInput') as HTMLInputElement;
    fileInput.click();
}

async function uploadFile(event: Event) {
    const fileInput = event.target as HTMLInputElement;
    if (fileInput && fileInput.files) {
        const file = fileInput.files[0];
        const formData = new FormData();
        formData.append('file', file);

        const response = await api.post('upload', formData, {
            baseURL: '/',
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        });

        if (response.data.path) {
            const newUrl = `${window.location.origin}/${response.data.path}`;

            if (containsVariables(downloadLink.value, variables.value)) {
                const userConfirmed = confirm(
                    `File uploaded, but the current download link contains variables. Do you want to update the download link to: ${newUrl} ?`,
                );
                if (!userConfirmed) {
                    return;
                }
            }

            downloadLink.value = newUrl;
        }
    }
}
</script>
