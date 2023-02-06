<template>
    <tr v-if="itemVisible">
        <td class="align-middle w-75">{{ props.name }}</td>
        <td class="align-middle w-25">{{ props.version }}</td>
        <td>
            <a class="btn btn-primary btn-sm" :href="`apps/edit/${props.id}`">
                <i class="bi-pencil-fill"></i>
            </a>
        </td>
        <td>
            <DeleteButton :id="id" @delete-confirmed="onDeleteConfirmed()" />
        </td>
    </tr>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import { useFetch } from '../fetch';
import DeleteButton from './DeleteButton.vue';

const props = defineProps({
    id: String,
    name: String,
    version: String,
    editLink: String
});

const itemVisible = ref(true);

async function onDeleteConfirmed()
{
    const { response } = await useFetch(`apps/${props.id}`, 'DELETE');
    if (response?.status === 204) {
        itemVisible.value = false;
    }   
}

</script>