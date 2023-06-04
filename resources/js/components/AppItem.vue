<template>
    <tr v-if="itemVisible">
        <td class="align-middle w-75">{{ app.name }}</td>
        <td class="align-middle w-25">{{ app.version || '(latest)' }}</td>
        <td>
            <a class="btn btn-primary btn-sm" :href="`apps/edit/${app.id}`">
                <i class="bi-pencil-fill"></i>
            </a>
        </td>
        <td>
            <DeleteButton :id="app.id" @delete-confirmed="onDeleteConfirmed()" />
        </td>
    </tr>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import api from '../api';
import DeleteButton from './DeleteButton.vue';

const props = defineProps({
    app: {
        type: Object as () => App,
        required: true,
    },
    editLink: String,
});

const itemVisible = ref(true);

async function onDeleteConfirmed() {
    const response = await api.delete(`apps/${props.app.id}`);
    if (response?.status === 204) {
        itemVisible.value = false;
    }
}
</script>
