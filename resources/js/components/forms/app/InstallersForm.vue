<template>
    <a class="btn btn-primary mb-2" @click="addClicked">Add</a>

    <table class="table table-sm table-striped table-bordered w-auto mt-2">
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
                    <DeleteButton @delete-confirmed="deleteConfirmed(installer.id)" />
                </td>
            </tr>
        </tbody>
    </table>

    <div v-if="selectedInstaller">
        <div class="mb-3 col-md-2" v-if="selectedIndex === -2">
            <label for="archSelect">Arch</label>
            <select class="form-select" id="archSelect" name="arch" v-model="selectedInstaller.arch">
                <option v-for="(arch, index) in Arch" :value="index">{{ arch }}</option>
            </select>
        </div>

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
import api from '../../../api';
import Arch from '../../../enums/Arch'

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

const installers = ref(props.installers);

/** The index of the installer to edit. -1 = none selected, -2 = new */
const selectedIndex = ref(-1);

const selectedInstaller = computed(() => {
    let installer;

    if (selectedIndex.value === -2) {
        installer = <Installer>{};
        if (props.appId) {
            installer.app_id = props.appId;
        }
    } else {
        installer = selectedIndex.value > -1 ? installers.value[selectedIndex.value] : null;
        if (installer && props.appId) {
            installer.app_id = props.appId;
        }
    }

    return installer;
});

function addClicked() {
    selectedIndex.value = -2;
}

function editClicked(index: number) {
    if (selectedIndex.value != index) {
        selectedIndex.value = index; 
    }
}

function getArchNameForInstaller(installer: Installer) {
    const archIndex = props.detectinfo.find(d => d.id === installer.detectinfo_id)?.arch;
    return archIndex ? Arch[archIndex] : '';
}

async function save() {
    if (selectedInstaller.value) {
        try {
            await api.request({
                baseURL: '/apps/edit',
                url: selectedInstaller.value.id ? `installers/${selectedInstaller.value?.id}` : 'installers',
                method: selectedInstaller.value.id ? 'PUT' : 'POST',
                data: selectedInstaller.value
            });

            if (!selectedInstaller.value.id) {
                installers.value.push(selectedInstaller.value);
                selectedIndex.value = -2;
            } else {
                selectedIndex.value = -1;
            }
                       

        } catch (error) {
            console.log('An error occurred while saving installer'.concat(error instanceof Error ? `: ${error.message}` : ''));
        }
    }
}

async function deleteConfirmed(id: Number) {
    try {
        await api.request({        
            method: 'DELETE',
            baseURL: '/apps/edit',
            url: `installers/${id}`
        });

        installers.value = installers.value.filter(i => i.id !== id);
        selectedIndex.value = -1;
    } catch (error) {
        console.log('An error occurred while deleting installer'.concat(error instanceof Error ? `: ${error.message}` : ''));
    }
}
</script>