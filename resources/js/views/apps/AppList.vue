<template>
    <span>
        <a class="btn btn-primary ms-3 mb-3" @click="router.push({ name: 'apps-new' })">Add</a>

        <p v-if="fetchError" class="text-danger">Could not load apps from the server</p>

        <table v-else-if="apps.length > 0" class="table table-sm table-striped table-bordered">
            <thead>
                <tr>
                    <th scope="col" class="w-75">Name</th>
                    <th scope="col" class="w-25">Version</th>
                    <th scope="col">Edit</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <AppItem v-for="app in apps" :key="app.id" :app="app" @deleted="onAppDeleted" />
            </tbody>
        </table>

        <p v-else><em>No apps available yet</em></p>
    </span>
</template>

<script lang="ts" setup>
import { onMounted, ref } from 'vue';
import axios from 'axios';
import AppItem from '../../components/AppItem.vue';
import { useRouter } from 'vue-router';
import App from '../../types/apps/App';

const router = useRouter();

const apps = ref<App[]>([]);
const isLoading = ref(true);
const fetchError = ref(false);

onMounted(fetchApps);

async function fetchApps() {
    try {
        const response = await axios.get('apps');
        apps.value = response.data;
    } catch (error) {
        if (error instanceof Error) {
            fetchError.value = true;
            console.error('Error fetching apps'.concat(error?.message ?? ''));
        }
    } finally {
        isLoading.value = false;
    }
}

async function onAppDeleted(id: number) {
    try {
        await axios.delete(`apps/${id}`);
        apps.value = apps.value.filter((a) => a.id !== id);
    } catch (error) {
        // TODO: show toast message here
        console.error(error);
    }
}
</script>

<style>
th,
td {
    padding: 5px 7.5px !important;
}
</style>
