<template>
    <button type="submit" class="btn btn-danger btn-sm" @click="deleteClicked">
        <i class="bi-trash"></i>
    </button>
</template>

<script lang="ts" setup>
const props = defineProps<{
    name: string;
}>();

const emit = defineEmits(['deleteConfirmed']);

async function deleteClicked() {
    const confirmed = confirm(`Are you sure you want to delete ${props.name}?`);
    if (confirmed) {
        emit('deleteConfirmed');
    }
}
</script>
