<template>
    <details>
        <summary>Available variables</summary>
        <div v-for="(variableValue, variableName) in variables">
            {{ variableIndicator }}{{ variableName }}{{ variableIndicator }} = {{ variableValue }}
        </div>
    </details>
</template>

<script lang="ts" setup>
defineProps({
    variables: Object,
    variableIndicator: String,
});
</script>
