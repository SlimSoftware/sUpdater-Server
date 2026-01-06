<template>
    <div v-if="!isLoading" class="mt-3">
        <form @submit.prevent="save">
            <div class="mb-3 col-md-3">
                <label for="nameInput">Name</label>
                <input id="nameInput" v-model="appForm.name" type="text" class="form-control" name="name" required />
            </div>

            <div class="mb-3 col-md-3">
                <label for="versionInput">Version</label>
                <input v-model.lazy="appForm.version" type="text" class="form-control" placeholder="(latest)" />
            </div>

            <div class="form-check mb-2">
                <input id="noupdateCheckbox" v-model="appForm.noupdate" type="checkbox" class="form-check-input" />
                <label for="noupdateCheckbox" class="form-check-label">
                    Use this app's own updater to check for updates
                </label>
            </div>

            <div class="mb-3">
                <URLInput v-model="appForm.release_notes_url" label="Release notes URL" />
            </div>
            <div class="mb-3">
                <URLInput v-model="appForm.website_url" label="Website URL" />
            </div>

            <input class="btn btn-primary" type="submit" value="Save" />
        </form>
    </div>

    <template v-if="id && !isLoading">
        <DetectInfoForm :detectinfo="app?.detectinfo" :app-id="app?.id" />

        <InstallersForm
            :installers="app?.installers"
            :detectinfo="app?.detectinfo"
            :app-id="app?.id"
            :version="appForm.version ?? ''"
            :variables
        />
    </template>
</template>

<script lang="ts" setup>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import DetectInfoForm from './DetectInfoForm.vue';
import InstallersForm from './InstallersForm.vue';
import router from '../../../router';
import { useGlobalStore } from '../../../stores/global';
import { useToastStore } from '../../../stores/toast';
import URLInput from '../URLInput.vue';
import App from '../../../types/apps/App';
import AppForm from '../../../types/apps/AppForm';
import { getVariablesMap } from '../../../variable-parser';

const globalStore = useGlobalStore();
const toastStore = useToastStore();

const props = defineProps({
    id: {
        type: Number,
        required: false
    }
});

const isLoading = ref(true);
const app = ref<App>();
const appForm = ref(<AppForm>{ noupdate: false });

const variables = computed(() => getVariablesMap(app.value?.version));

onMounted(() => {
    fetchApp();
});

async function fetchApp() {
    if (props.id) {
        try {
            const response = await axios.get(`apps/${props.id}`);
            app.value = response.data;
            appForm.value = response.data;
            globalStore.pageTitle = `Edit ${app.value?.name}`;
        } catch (error) {
            toastStore.show('An error occurred while loading the app', 'danger');
            console.log(error);
        } finally {
            isLoading.value = false;
        }
    } else {
        isLoading.value = false;
    }
}

async function save() {
    try {
        if (appForm.value.version?.trim() === '') {
            appForm.value.version = null;
        }

        const response = await axios.request({
            url: `apps/${props.id ?? ''}`,
            method: props.id ? 'PUT' : 'POST',
            data: appForm.value
        });

        if (!props.id) {
            toastStore.show(
                'Sucessfully created the app, you can now add its detection info and installers',
                'success'
            );
            router.push(`/apps/${response.data.id}`);
        } else {
            toastStore.show('Succesfully saved the app', 'success');
        }
    } catch (error) {
        toastStore.show('An error occurred while saving the app', 'danger');
        console.error(error);
    }
}
</script>
