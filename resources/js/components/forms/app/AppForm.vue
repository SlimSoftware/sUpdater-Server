<template>
    <AppFormTabs :is-new="id === undefined">
        <template v-slot:appContent>
            <div v-if="errorMessage" class="text-danger">An error occurred while fetching the app: {{ errorMessage }}</div>
            <div v-else-if="!isLoading">
                <div class="mb-3 col-md-3">
                    <label for="nameInput">Name</label>
                    <input type="text" class="form-control" id="nameInput" name="name" :value="app.name" required />
                </div>

                <div class="mb-3 col-md-3">
                    <label for="versionInput">Version</label>
                    <input type="text" class="form-control" id="versionInput" name="version" :value="app.version"
                        placeholder="(latest)" />
                </div>

                <div class="form-check mb-2">
                    <input type="checkbox" id="noupdateCheckbox" name="noupdate" class="form-check-input"
                        v-model="app.noupdate" true-value="1" false-value="0" />
                    <label for="noupdateCheckbox" class="form-check-label">Use this app's own updater to check for
                        updates</label>
                </div>

                <div class="mb-3">
                    <label for="releaseNotesInput">Release notes URL</label>
                    <input type="text" class="form-control" id="releaseNotesInput" name="releaseNotesUrl"
                        :value="app.release_notes_url" />
                </div>

                <div class="mb-3">
                    <label for="websiteInput">Website URL</label>
                    <input type="text" class="form-control" id="websiteInput" name="websiteUrl" :value="app.website_url" />
                </div>

                <input type="hidden" name="id" :value="app.id" />
                <input class="btn btn-primary" type="submit" value="Save" />
            </div>
        </template>

        <template v-slot:detectInfoContent>
            <DetectInfoForm :detect-info="app?.detectinfo" :app-id="app?.id" />
        </template>

        <template v-slot:installersContent>
            <InstallersForm />
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
    id: String
});

const isLoading = ref(true);
const app = ref();
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
        } catch (error) {
            if (error instanceof Error)
                errorMessage.value = error?.message;
        }     
        isLoading.value = false;
    } else {
        app.value = {};
        isLoading.value = false;
    }
}
</script>