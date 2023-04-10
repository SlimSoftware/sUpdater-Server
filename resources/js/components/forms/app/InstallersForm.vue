<template>
    <table class="table table-sm table-striped table-bordered w-auto mt-3">
        <thead>
            <tr>
                <th scope="col">Arch</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="installer, index in installers">
                <td>{{ getArchNameForInstaller(installer) }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" @click="editClicked(index)">
                        <i class="bi-pencil-fill"></i>
                    </a>
                </td>
                <td>
                    <DeleteButton @delete-confirmed="(installer.id)" />
                </td>
            </tr>
        </tbody>
    </table>

    <div v-if="selectedInstaller">
        <div class="mb-3">
            <DownloadLinkInput :link="selectedInstaller.download_link" :version="version" />
        </div>

        <div class="mb-3">
            <label for="launchArgsInput">Launch arguments</label>
            <input type="text" class="form-control" id="launchArgsInput" name="launchArgs"
                :value="selectedInstaller.launch_args" />
        </div>

        <input type="hidden" name="id" :value="selectedInstaller.id" />
        <input class="btn btn-primary" type="submit" value="Save" />
    </div>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import DeleteButton from '../../DeleteButton.vue';
import DownloadLinkInput from '../../DownloadLinkInput.vue';

const props = defineProps({
    installers: {
        type: Array<Installer>,
        default: () => []
    },
    detectinfo: {
        type: Array<DetectInfo>,
        default: () => []
    },
    version: {
        type: String,
        default: () => ''
    },
    appId: {
        type: Number
    }
});

const selectedIndex = ref(-1);
const selectedInstaller = computed(() => {
    return selectedIndex.value !== -1 ? props.installers[selectedIndex.value] : null;
});

function editClicked(index: number) {
    if (selectedIndex.value != index) {
        selectedIndex.value = index; 
    }
}

function getArchNameForInstaller(installer: Installer) {
    const archIndex = props.detectinfo.find(d => d.id === installer.detectinfo_id)?.arch;
    return archIndex ? getArchString(archIndex) : '';
}

function getArchString(arch: number) {
    if (arch === 0)
        return 'Any';
    else if (arch === 1)
        return '32-bit';
    else if (arch === 2)
        return '64-bit';
}
</script>