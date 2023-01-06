<template>
    <label for="dlInput">Download link</label>
    <div class="input-group">
        <input type="text" class="form-control" id="dlInput" name="downloadLink" required
            v-model="downloadLink" />
        <a class="btn btn-primary">Test link</a>
    </div>
    <span id="dlParsedHintContainer" class="text-muted" :style="previewHintContainerStyle">
        Preview: <span id="dlParsedHint">{{ previewDownloadLink }}</span>
    </span>
    <AvailableVariablesExpander :variables="variables" :variableIndicator="variableIndicator" />
</template>

<script lang="ts" setup>
    import { ref, computed } from 'vue';
    import { parseText, containsVariables } from '../variable-parser';

    const props = defineProps({
        link: String,
        version: String
    });

    const downloadLink = ref(props.link);
    const variables = {
        ver: props.version ? props.version : '',
        verDotless: props.version ? props.version.replace('.', '') : '',
        'verX.Y': props.version ? splitVersion(props.version, 2) : ''
    };
    const variableIndicator = '%';

    function splitVersion(version: string, digits: number)
    {
        let newVersion = '';
        let numbers = version.split(".", digits);
        for (let i = 0; i < digits; i++) {
            newVersion += numbers[i];

            if (i < digits - 1) {
                newVersion += '.';
            }
        }
        
        return newVersion;
    }

    const previewDownloadLink = computed(() => {
        if (downloadLink.value !== undefined)
            return parseText(downloadLink.value, variables);
    });

    const previewHintContainerStyle = computed(() => {
        let displayValue = 'none';

        if (downloadLink.value !== undefined && containsVariables(downloadLink.value, variables)) {
            displayValue = 'block';
        }

        return { display: displayValue };
    });
</script>
