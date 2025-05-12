<template>
    <div v-if="!isLoading" class="mt-3">
        <form @submit.prevent="save">
            <div class="mb-3 col-md-3">
                <label for="nameInput">Name</label>
                <input id="nameInput" v-model="app.name" type="text" class="form-control" name="name" required />
            </div>

            <div class="mb-3 col-md-3">
                <label for="versionInput">Version</label>
                <input v-model="app.version" type="text" class="form-control" placeholder="(latest)" />
            </div>

            <div class="mb-3">
                <URLInput v-model="app.release_notes_url" label="Release notes URL" />
            </div>

            <div class="mb-3">
                <URLInput v-model="app.release_notes_url" label="Release notes URL" />
            </div>

            <input class="btn btn-primary" type="submit" value="Save" />
        </form>
    </div>

    <ArchivesForm v-if="id && !isLoading" :archives="app.archives" :portable-app="app" />
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import ArchivesForm from './ArchivesForm.vue';
import PortableApp from '../../../types/portable-apps/PortableApp';
import { useGlobalStore } from '../../../stores/global';
import router from '../../../router';
import { useToastStore } from '../../../stores/toast';
import URLInput from '../../URLInput.vue';

const globalStore = useGlobalStore();
const toastStore = useToastStore();

const props = defineProps({
    id: {
        type: Number,
        required: false
    }
});

const isLoading = ref(true);
const app = ref(<PortableApp>{});

onMounted(() => {
    fetchApp();
});

async function fetchApp() {
    if (props.id) {
        try {
            const response = await axios.get(`portable-apps/${props.id}`);
            app.value = response.data;
            globalStore.pageTitle = `Edit ${app.value.name}`;
        } catch (error) {
            toastStore.show('An error occurred while loading the app', 'danger');
            console.error(error);
        } finally {
            isLoading.value = false;
        }
    } else {
        globalStore.pageTitle = 'New Portable App';
        isLoading.value = false;
    }
}

async function save() {
    try {
        if (app.value.version?.trim() === '') delete app.value.version;

        const response = await axios.request({
            url: `/portable-apps/${props.id ?? ''}`,
            method: props.id ? 'PUT' : 'POST',
            data: app.value
        });

        if (!props.id) {
            router.push(`/portable-apps/${response.data.id}`);
        } else {
            toastStore.show('Sucessfully created the Portable App', 'success');
        }
    } catch (error) {
        toastStore.show('An error occurred while saving the Portable App', 'danger');
        console.error(error);
    }
}
</script>
