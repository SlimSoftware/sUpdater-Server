<template>
    <div v-if="!isLoading" class="mt-3">
        <!-- <div v-if="addSuccess" class="text-primary mb-2">
            App added successfully, you can now add its detection info and installers.
        </div>
        <div v-else-if="editSuccess" class="text-primary mb-2">Changes saved successfully</div> -->
        <form @submit.prevent="save">
            <div class="mb-3 col-md-3">
                <label for="nameInput">Name</label>
                <input id="nameInput" v-model="appForm.name" type="text" class="form-control" name="name" required />
            </div>

            <div class="mb-3 col-md-3">
                <label for="versionInput">Version</label>
                <input v-model="appForm.version" type="text" class="form-control" placeholder="(latest)" />
            </div>

            <div class="form-check mb-2">
                <input id="noupdateCheckbox" v-model="appForm.noupdate" type="checkbox" class="form-check-input" />
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

    <template v-if="id && !isLoading">
        <DetectInfoForm :detectinfo="app?.detectinfo" :app-id="app?.id" />

        <InstallersForm
            :installers="app?.installers"
            :detectinfo="app?.detectinfo"
            :app-id="app?.id"
            :version="appForm.version ?? ''"
        />
    </template>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import DetectInfoForm from './DetectInfoForm.vue';
import InstallersForm from './InstallersForm.vue';
import router from '../../../router';
import { useGlobalStore } from '../../../stores/global';
import { useToastStore } from '../../../stores/toast';

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
const appForm = ref(<AppForm>{});

onMounted(() => {
    fetchApp();
});

async function fetchApp() {
    if (props.id) {
        try {
            const response = await axios.get(`apps/${props.id}`);
            app.value = response.data;
            globalStore.pageTitle = `Edit ${app.value?.name}`;

            appForm.value.name = response.data.name;
            appForm.value.version = response.data.version;
            appForm.value.noupdate = response.data.noupdate;
            appForm.value.release_notes_url = response.data.release_notes_url;
            appForm.value.website_url = response.data.website_url;
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
