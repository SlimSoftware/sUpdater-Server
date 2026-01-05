<template>
    <span>
        <RouterLink class="btn btn-primary ms-3 mb-3" :to="{ name: 'portable-apps-new' }">Add</RouterLink>

        <table v-if="portableApps.length > 0" class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="w-75">Name</th>
                    <th scope="col" class="w-25">Version</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <PortableAppItem v-for="app in portableApps" :key="app.id" :portable-app="app" />
            </tbody>
        </table>

        <p v-else-if="fetchError" class="text-danger">Could not load apps from the server</p>
        <p v-else-if="!isLoading"><em>No portable apps available yet</em></p>
    </span>
</template>

<script lang="ts" setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import PortableApp from '../../types/portable-apps/PortableApp';
import PortableAppItem from '../../components/PortableAppItem.vue';

const portableApps = ref<PortableApp[]>([]);
const isLoading = ref(true);
const fetchError = ref(false);

async function fetch() {
    try {
        const response = await axios.get('portable-apps');
        portableApps.value = response.data;
    } catch (error) {
        fetchError.value = true;
        if (error instanceof Error) {
            console.error('Error fetching portable apps'.concat(error?.message ?? ''));
        }
    } finally {
        isLoading.value = false;
    }
}

onMounted(fetch);
</script>
