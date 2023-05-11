<template>
    <a class="btn btn-primary mb-2" href="/apps/new">Add</a>

    <div v-if="isLoading" class="d-flex justify-content-center">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <table v-else-if="apps.length > 0" class="table table-sm table-striped table-bordered w-auto">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Version</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <AppItem v-for="app in apps" :key="app.id" :app="app" />
        </tbody>
    </table>

    <p v-else><em>No apps available yet</em></p>
</template>

<script lang="ts" setup>
import { ref } from 'vue';
import api from '../api';
import AppItem from './AppItem.vue';

const apps = ref<App[]>([]);
const isLoading = ref(true);
const fetchError = ref(false);

async function fetchApps() {
    try {
        const response = await api.get('apps');
        apps.value = response.data;
        isLoading.value = false;
    } catch (error) {
        if (error instanceof Error) {
            fetchError.value = true;
            console.error('Error fetching apps' + error?.message ?? '');
        }
    }
}

fetchApps();
</script>