<template>
    <button type="submit" class="btn btn-danger btn-sm">
        <i class="bi-trash" @click="deleteClicked"></i>
    </button>
</template>

<script lang="ts" setup>
const emit = defineEmits(['deleteConfirmed']);

async function deleteClicked() {
    const confirmed = confirm('Are you sure you want to delete this?');
    if (confirmed) {
        emit('deleteConfirmed');
    }
}
</script>
