<template>
    <div v-if="errorMessage" class="text-danger">An error occurred while fetching the app: {{ errorMessage }}</div>
    <div v-else-if="!isLoading">
        <h5><b>General</b></h5>
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
                v-model="app.detect_info.noupdate" />
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

        <h5><b>Detect info</b></h5>
        <div class="mb-3 col-md-2">
            <label for="archSelect">Arch</label>
            <select class="form-select" id="archSelect" name="arch" v-model="app.detect_info.arch">
                <option value="0">Any</option>
                <option value="1">32-bit</option>
                <option value="2">64-bit</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="regKeyInput">Registry key</label>
            <input type="text" class="form-control" id="regKeyInput" name="regKey" :value="app.detect_info.reg_key" />
        </div>

        <div class="mb-3 col-md-3">
            <label for="regValueInput">Registry value</label>
            <input type="text" class="form-control" id="regValueInput" name="regValue"
                :value="app.detect_info.reg_value" />
        </div>

        <div class="mb-3">
            <label for="exePathInput">Executable path</label>
            <input type="text" class="form-control" id="exePathInput" name="exePath"
                :value="app.detect_info.exe_path" />
            <details>
                <summary>Available variables</summary>
                <p>%pf64% = Program Files on 64 bit systems, does not detect on 32 bit systems<br />
                    %pf32% = Program Files (x86) on 64 bit systems, Program Files on 32 bit systems</p>
            </details>
        </div>

        <h5><b>Installer Info</b></h5>
        <div class="mb-3">
            <DownloadLinkInput :link="app.installer.download_link" :version="version.value" />
        </div>

        <div class="mb-3">
            <label for="launchArgsInput">Launch arguments</label>
            <input type="text" class="form-control" id="launchArgsInput" name="launchArgs"
                :value="app.installer.launch_args" />
        </div>

        <input type="hidden" name="id" :value="app.id" />
        <input class="btn btn-primary" type="submit" value="Save" />
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import { useFetch } from '../../fetch';

const props = defineProps({
    id: String
});

const isLoading = ref(true);
const app = ref();
const version = ref();
const errorMessage = ref();

onMounted(() => {
    if (props.id !== '') {
        useFetch(`app/${props.id}`).then(({ json, error }) => {
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
        app.value = {
            detect_info: {},
            installer: []
        };
        version.value = '';
        isLoading.value = false;
    }
});

</script>