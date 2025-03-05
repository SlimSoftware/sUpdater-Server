<template>
    <a class="btn btn-primary mb-2" @click="addClicked">Add</a>

    <table class="table table-sm table-striped table-bordered w-auto mt-2">
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
                    <DeleteButton @delete-confirmed="deleteConfirmed(installer.id)" />
                </td>
            </tr>
        </tbody>
    </table>

    <div v-if="selectedInstaller">
        <div v-if="selectedIndex === -2" class="mb-3 col-md-2">
            <label for="archSelect"
                >Arch
                <i
                    class="bi bi-question-circle"
                    title="Arch not listed? Add a detectinfo entry for this arch first!"
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

/** The index of the installer to edit. -1 = none selected, -2 = new */
const selectedIndex = ref(-1);

const selectedInstaller = computed((): Installer => {
    let installer = ref();

    if (selectedIndex.value === -2) {
        installer.value = <Installer>{};
        if (props.appId) {
            installer.value.app_id = props.appId;
        }
    } else {
        installer.value = selectedIndex.value > -1 ? installers.value[selectedIndex.value] : null;
        if (installer.value && props.appId) {
            installer.value.app_id = props.appId;
        }
    }

    return installer.value;
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
                console.error('Detectinfo not found for installer');
                return;
            }

            selectedInstaller.value.detectinfo_id = detectInfoId;
        }
    }
);

function addClicked() {
    selectedIndex.value = -2;
}

function editClicked(index: number) {
    if (selectedIndex.value != index) {
        selectedIndex.value = index;
    }
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
            await axios.request({
                url: selectedInstaller.value.id
                    ? `apps/edit/installers/${selectedInstaller.value?.id}`
                    : 'apps/edit/installers',
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
            console.error(
                'An error occurred while saving installer'.concat(error instanceof Error ? `: ${error.message}` : '')
            );
        }
    }
}

async function deleteConfirmed(id: number) {
    try {
        await axios.request({
            method: 'DELETE',
            baseURL: '/apps/edit',
            url: `installers/${id}`
        });

        installers.value = installers.value.filter((i) => i.id !== id);
        selectedIndex.value = -1;
    } catch (error) {
        console.error(
            'An error occurred while deleting installer'.concat(error instanceof Error ? `: ${error.message}` : '')
        );
    }
}
</script>
