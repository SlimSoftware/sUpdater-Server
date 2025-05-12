<template>
    <h3 class="mt-4 d-inline-block">Installers</h3>
    <a class="btn btn-primary ms-2 mb-2" @click="addClicked" v-if="!addNew">Add</a>

    <table class="table table-sm table-striped table-bordered w-auto mt-2" v-if="installers.length > 0">
        <thead>
            <tr>
                <th scope="col">Arch</th>
                <th scope="col">Download link</th>
                <th scope="col">Edit</th>
                <th scope="col">Delete</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(installer, index) in installers" :key="index">
                <td>{{ getArchNameForInstaller(installer) }}</td>
                <td>{{ installer.download_link }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" @click="editClicked(index)">
                        <i class="bi-pencil-fill"></i>
                    </a>
                </td>
                <td>
                    <DeleteButton
                        :name="`the ${getArchNameForInstaller(installer)} installer`"
                        @delete-confirmed="deleteConfirmed(installer.id)"
                    />
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mt-2 fst-italic" v-else-if="!selectedInstaller">No installers have been added yet</div>

    <div v-if="selectedInstaller">
        <div v-if="addNew" class="mb-3 col-md-2">
            <label for="archSelect"
                >Arch
                <i
                    class="bi bi-question-circle"
                    title="Arch not listed? Add a detection info entry for this arch first!"
                ></i
            ></label>
            <select id="archSelect" v-model="selectedInstaller.arch" class="form-select" name="arch" required>
                <option v-for="(arch, index) in unusedArchs" :key="index" :value="index">
                    {{ arch }}
                </option>
            </select>
        </div>

        <div class="mb-3">
            <DownloadLinkInput v-model="selectedInstaller.download_link_raw" :version="version" />
        </div>

        <div class="mb-3">
            <label for="launchArgsInput">Launch arguments</label>
            <input
                id="launchArgsInput"
                v-model="selectedInstaller.launch_args"
                type="text"
                class="form-control"
                name="launchArgs"
            />
        </div>

        <button class="btn btn-primary" type="submit" @click="save">Save</button>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref, watch } from 'vue';
import DeleteButton from '../../DeleteButton.vue';
import DownloadLinkInput from '../../DownloadLinkInput.vue';
import { archNames } from '../../../enums/Arch';
import axios from 'axios';
import { useToastStore } from '../../../stores/toast';

const toastStore = useToastStore();

const props = defineProps({
    installers: {
        type: Array<Installer>,
        default: []
    },
    detectinfo: {
        type: Array<DetectInfo>,
        default: []
    },
    version: {
        type: String,
        default: ''
    },
    appId: {
        type: Number,
        default: undefined
    }
});

const installers = ref(props.installers);
const addNew = ref(false);
const selectedIndex = ref<number | null>(null);

const selectedInstaller = computed(() => {
    let installer;

    if (addNew.value) {
        installer = <Installer>{};
        if (props.appId) {
            installer.app_id = props.appId;
        }
    } else {
        installer = selectedIndex.value != null ? installers.value[selectedIndex.value] : null;
        if (installer && props.appId) {
            installer.app_id = props.appId;
        }
    }

    return installer;
});

const unusedArchs = computed(() => {
    const allArchs = props.detectinfo.map((d) => d.arch);
    return archNames.filter((_arch, index) => allArchs.includes(index));
});

watch(
    () => selectedInstaller.value?.arch,
    () => {
        if (selectedInstaller.value) {
            const detectInfoId = getDetectInfoFromArch(selectedInstaller.value.arch)?.id;
            if (!detectInfoId) {
                toastStore.show('Could not load detection info for this installer', 'danger');
                return;
            }

            selectedInstaller.value.detectinfo_id = detectInfoId;
        }
    }
);

function addClicked() {
    addNew.value = true;
}

function editClicked(index: number) {
    if (selectedIndex.value !== index) {
        selectedIndex.value = index;
    } else {
        selectedIndex.value = null;
    }

    addNew.value = false;
}

function getDetectInfoFromArch(arch: number) {
    return props.detectinfo.find((d) => d.arch === arch);
}

function getArchNameForInstaller(installer: Installer) {
    const archIndex = props.detectinfo.find((d) => d.id === installer.detectinfo_id)?.arch;
    return archIndex != null ? archNames[archIndex] : '';
}

async function save() {
    if (selectedInstaller.value) {
        try {
            const response = await axios.request({
                url: `apps/installers/${selectedInstaller.value?.id}`,
                method: selectedInstaller.value.id ? 'PUT' : 'POST',
                data: selectedInstaller.value
            });

            if (!selectedInstaller.value.id) {
                selectedInstaller.value.id = response.data.id;
                installers.value.push(selectedInstaller.value);
            }

            selectedIndex.value = null;
            toastStore.show('Succesfully saved the installer', 'success');
        } catch (error) {
            toastStore.show('An error occurred while saving the installer', 'danger');
            console.error(error);
        }
    }
}

async function deleteConfirmed(id: number) {
    try {
        await axios.delete(`/apps/installers/${id}`);

        installers.value = installers.value.filter((i) => i.id !== id);
        selectedIndex.value = null;
    } catch (error) {
        toastStore.show('An error occurred while deleting the installer', 'danger');
        console.error(error);
    }
}
</script>
