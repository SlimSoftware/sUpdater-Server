<template>
    <AppFormTabs :is-new="id === undefined">
        <template #appContent>
            <div v-if="errorMessage" class="text-danger">
                An error occurred while fetching the app: {{ errorMessage }}
            </div>
            <div v-else-if="!isLoading">
                <div v-if="addSuccess" class="text-primary mb-2">
                    App added successfully, you can now add its detection info and installers.
                </div>
                <div v-else-if="editSuccess" class="text-primary mb-2">Changes saved successfully</div>
                <form @submit.prevent="save">
                    <div class="mb-3 col-md-3">
                        <label for="nameInput">Name</label>
                        <input
                            id="nameInput"
                            v-model="appForm.name"
                            type="text"
                            class="form-control"
                            name="name"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="versionInput">Version</label>
                        <input v-model="appForm.version" type="text" class="form-control" placeholder="(latest)" />
                    </div>

                    <div class="form-check mb-2">
                        <input
                            id="noupdateCheckbox"
                            v-model="appForm.noupdate"
                            type="checkbox"
                            class="form-check-input"
                        />
                        <label for="noupdateCheckbox" class="form-check-label">
                            Use this app's own updater to check for updates
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="releaseNotesInput">Release notes URL</label>
                        <input v-model="appForm.release_notes_url" type="text" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label for="websiteInput">Website URL</label>
                        <input v-model="appForm.website_url" type="text" class="form-control" />
                    </div>

                    <input class="btn btn-primary" type="submit" value="Save" />
                </form>
            </div>
        </template>

        <template #detectInfoContent>
            <DetectInfoForm :detectinfo="app?.detectinfo" :app-id="app?.id" />
        </template>

        <template #installersContent>
            <InstallersForm
                :installers="app?.installers"
                :detectinfo="app?.detectinfo"
                :app-id="app?.id"
                :version="app?.version != undefined ? app.version : ''"
            />
        </template>
    </AppFormTabs>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import api from '../../../api';
import AppFormTabs from './AppFormTabs.vue';
import DetectInfoForm from './DetectInfoForm.vue';
import InstallersForm from './InstallersForm.vue';

const props = defineProps({
    id: String,
});

const isLoading = ref(true);
const app = ref<App>();
const appForm = ref(<AppForm>{});
const addSuccess = ref(false);
const editSuccess = ref(false);
const errorMessage = ref();

onMounted(() => {
    fetchApp();
});

async function fetchApp() {
    if (props.id) {
        let response;
        try {
            response = await api.get(`apps/${props.id}`);
            app.value = response.data;
            appForm.value.name = response.data.name;
            appForm.value.version = response.data.version;
            appForm.value.noupdate = response.data.noupdate;
            appForm.value.release_notes_url = response.data.release_notes_url;
            appForm.value.website_url = response.data.website_url;
        } catch (error) {
            if (error instanceof Error) {
                errorMessage.value = error?.message;
            }
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

        const response = await api.request({
            baseURL: '/apps',
            url: props.id ? `/edit/${props.id}` : '/new',
            method: props.id ? 'PUT' : 'POST',
            data: appForm.value,
        });

        if (!props.id) {
            window.location.href = `/apps/edit/${response.data.id}`;
        } else {
            editSuccess.value = true;
        }
    } catch (error) {
        console.error('An error occurred while saving app'.concat(error instanceof Error ? ` ${error.message}` : ''));
        editSuccess.value = false;
    }
}
</script>
