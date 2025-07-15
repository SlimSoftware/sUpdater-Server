<template>
    <tr v-if="itemVisible">
        <td class="align-middle">{{ app.name }}</td>
        <td class="align-middle">{{ app.version || '(latest)' }}</td>
        <td>
            <RouterLink class="btn btn-primary btn-sm" :to="{ name: 'apps-edit', params: { id: app.id } }">
                <i class="bi-pencil-fill"></i>
            </RouterLink>
        </td>
        <td>
            <DeleteButton :name="app.name" @delete-confirmed="emit('deleted', app.id)" />
        </td>
    </tr>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import DeleteButton from './DeleteButton.vue';
import { RouterLink } from 'vue-router';
import App from '../types/apps/App';

defineProps<{
    app: App;
}>();

const emit = defineEmits(['deleted']);

const itemVisible = ref(true);
</script>
