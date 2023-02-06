<template>
    <div v-if="errorMessage" class="text-danger">An error occurred while fetching the app: {{ errorMessage }}</div>
    <div v-else-if="!isLoading">
        <div class="mb-3 col-md-3">
            <label for="nameInput">Name</label>
            <input type="text" class="form-control" id="nameInput" name="name" :value="app.name" required />
        </div>

        <div class="mb-3 col-md-3">
            <label for="versionInput">Version</label>
            <input type="text" class="form-control" id="versionInput" name="version" v-model.lazy="version" placeholder="(latest)" />
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

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import { useFetch } from '../../../fetch';

const props = defineProps({
    id: String
});

const isLoading = ref(true);
const app = ref();
const version = ref();
const errorMessage = ref();

onMounted(() => {
    if (props.id !== '') {
        useFetch(`apps/${props.id}`).then(({ json, error }) => {
            app.value = json;
            errorMessage.value = error?.message;

            if (json?.version !== '(latest)') {
                version.value = json.version;
            } else {
                version.value = '';
            }

            isLoading.value = false;
        });
    } else {
        app.value = {};
        version.value = '';
        isLoading.value = false;
    }
});

</script>