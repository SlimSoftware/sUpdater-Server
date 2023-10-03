<template>
    <details>
        <summary>Available variables</summary>
        <div v-for="(variableValue, variableName) in variables" :key="variableName">
            {{ variableIndicator }}{{ variableName }}{{ variableIndicator }} = {{ variableValue }}
        </div>
    </details>
</template>

<script lang="ts" setup>
defineProps({
    variables: {
        type: Object,
        default: () => ({}),
    },
    variableIndicator: {
        type: String,
        default: '',
    },
});
</script>
