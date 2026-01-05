<template>
    <tr v-if="itemVisible">
        <td class="align-middle">{{ portableApp.name }}</td>
        <td class="align-middle">{{ portableApp.version || '(latest)' }}</td>
        <td>
            <RouterLink
                class="btn btn-primary btn-sm"
                :to="{ name: 'portable-apps-edit', params: { id: portableApp.id } }"
            >
                <i class="bi-pencil-fill"></i>
            </RouterLink>
        </td>
        <td>
            <DeleteButton :id="portableApp.id" :name="portableApp.name" @delete-confirmed="onDeleteConfirmed()" />
        </td>
    </tr>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import DeleteButton from './DeleteButton.vue';
import axios from 'axios';
import { RouterLink } from 'vue-router';
import PortableApp from '../types/portable-apps/PortableApp';
import { useToastStore } from '../stores/toast';

const toastStore = useToastStore();

const props = defineProps<{
    portableApp: PortableApp;
}>();

const itemVisible = ref(true);

async function onDeleteConfirmed() {
    try {
        await axios.delete(`portable-apps/${props.portableApp.id}`);
        itemVisible.value = false;
        toastStore.show('Succesfully deleted the app', 'success');
    } catch (error) {
        toastStore.show('Could not delete the app', 'danger');
        console.error(error);
    }
}
</script>
