<template>
    <div v-if="errorMessage" class="text-danger">An error occurred while fetching the installers: {{ errorMessage }}</div>
    <div v-else-if="!isLoading">
        <div class="mb-3">
            <DownloadLinkInput :link="installer.download_link" :version="version" />
        </div>

        <div class="mb-3">
            <label for="launchArgsInput">Launch arguments</label>
            <input type="text" class="form-control" id="launchArgsInput" name="launchArgs"
                :value="installer.launch_args" />
        </div>

        <input type="hidden" name="id" :value="installer.id" />
        <input class="btn btn-primary" type="submit" value="Save" />
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import { useFetch } from '../../../fetch';
import DownloadLinkInput from '../../DownloadLinkInput.vue';

const props = defineProps({
    id: String
});

const isLoading = ref(true);
const installer = ref();
const version = ref();
const errorMessage = ref();

onMounted(() => {
    if (props.id !== '') {
        useFetch(`installers/${props.id}`).then(({ json, error }) => {
            installer.value = json;
            version.value = json.app.version;
            errorMessage.value = error?.message;
            isLoading.value = false;
        });
    } else {
        installer.value = {};
        version.value = '';
        isLoading.value = false;
    }
});

</script>