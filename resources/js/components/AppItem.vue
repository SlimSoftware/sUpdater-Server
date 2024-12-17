<template>
    <tr v-if="itemVisible">
        <td class="align-middle">{{ app.name }}</td>
        <td class="align-middle">{{ app.version || '(latest)' }}</td>
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
import DeleteButton from './DeleteButton.vue';
import axios from 'axios';

const props = defineProps({
    app: {
        type: Object as () => App,
        required: true
    }
});

const itemVisible = ref(true);

async function onDeleteConfirmed() {
    const response = await axios.delete(`apps/${props.app.id}`, {
        baseURL: '/'
    });

    if (response.status === 204) {
        itemVisible.value = false;
    }
}
</script>
