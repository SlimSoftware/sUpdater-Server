<template>
    <PortableAppFormTabs :is-new="!id">
        <template #appContent>
            <div v-if="errorMessage" class="text-danger">
                An error occurred while fetching the Portable App: {{ errorMessage }}
            </div>
            <div v-else-if="!isLoading">
                <div v-if="addSuccess" class="text-primary mb-2">
                    Portable App added successfully, you can now add its archives.
                </div>
                <div v-else-if="editSuccess" class="text-primary mb-2">Changes saved successfully</div>
                <form @submit.prevent="save">
                    <div class="mb-3 col-md-3">
                        <label for="nameInput">Name</label>
                        <input
                            id="nameInput"
                            v-model="app.name"
                            type="text"
                            class="form-control"
                            name="name"
                            required
                        />
                    </div>

                    <div class="mb-3 col-md-3">
                        <label for="versionInput">Version</label>
                        <input v-model="app.version" type="text" class="form-control" placeholder="(latest)" />
                    </div>

                    <div class="mb-3">
                        <label for="releaseNotesInput">Release notes URL</label>
                        <input v-model="app.release_notes_url" type="text" class="form-control" />
                    </div>

                    <div class="mb-3">
                        <label for="websiteInput">Website URL</label>
                        <input v-model="app.website_url" type="text" class="form-control" />
                    </div>

                    <input class="btn btn-primary" type="submit" value="Save" />
                </form>
            </div>
        </template>

        <template #archivesContent>
            <ArchivesForm :archives="app.archives" :portable-app="app" />
        </template>
    </PortableAppFormTabs>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import PortableAppFormTabs from './PortableAppFormTabs.vue';
import ArchivesForm from './ArchivesForm.vue';
import PortableApp from '../../../types/portable-apps/PortableApp';
import { useGlobalStore } from '../../../stores/global';
import router from '../../../router';
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
const app = ref(<PortableApp>{});
const addSuccess = ref(false);
const editSuccess = ref(false);
const errorMessage = ref();

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
            if (error instanceof Error) {
                errorMessage.value = error?.message;
            }
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
        if (app.value.version?.trim() === '') {
            delete app.value.version;
        }

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
        console.error('An error occurred while saving app'.concat(error instanceof Error ? ` ${error.message}` : ''));
        editSuccess.value = false;
    }
}
</script>
