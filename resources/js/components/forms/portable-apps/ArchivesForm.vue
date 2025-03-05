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
            <tr v-for="(archive, index) in archives" :key="index">
                <td>{{ archNames[archive.arch] }}</td>
                <td>{{ archive.download_link }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" @click="editClicked(index)">
                        <i class="bi-pencil-fill"></i>
                    </a>
                </td>
                <td>
                    <DeleteButton @delete-confirmed="deleteConfirmed(archive.id)" />
                </td>
            </tr>
        </tbody>
    </table>

    <div v-if="selectedArchive">
        <div v-if="selectedIndex === -2" class="mb-3 col-md-2">
            <label for="archSelect"
                >Arch
                <i
                    class="bi bi-question-circle"
                    title="Arch not listed? Add a detectinfo entry for this arch first!"
                ></i
            ></label>
            <select id="archSelect" v-model="selectedArchive.arch" class="form-select" required>
                <option v-for="(arch, index) in unusedArchs" :key="index" :value="index">
                    {{ arch }}
                </option>
            </select>
        </div>

        <div class="mb-3">
            <DownloadLinkInput v-model="selectedArchive.download_link_raw" :version="portableApp.version" />
        </div>

        <div class="mb-3 col-md-6">
            <label for="launchArgsInput">Launch file</label>
            <input
                id="launchArgsInput"
                v-model="selectedArchive.launch_file"
                type="text"
                class="form-control"
                required
            />
        </div>

        <div class="mb-3 col-md-3">
            <label for="extractModeInput">Extract mode</label>
            <select
                id="extractModeInput"
                v-model="selectedArchive.extract_mode"
                type="text"
                class="form-select"
                required
            >
                <option v-for="(mode, index) in extractModeNames" :key="index" :value="index">
                    {{ mode }}
                </option>
            </select>
        </div>

        <button class="btn btn-primary" type="submit" @click="save">Save</button>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import DeleteButton from '../../DeleteButton.vue';
import DownloadLinkInput from '../../DownloadLinkInput.vue';
import axios from 'axios';
import Archive from '../../../types/portable-apps/Archive';
import PortableApp from '../../../types/portable-apps/PortableApp';
import { archNames } from '../../../enums/Arch';
import { extractModeNames } from '../../../enums/ExtractMode';

const props = defineProps<{
    archives: Archive[];
    portableApp: PortableApp;
}>();

const archives = ref(props.archives);

/** The index of the installer to edit. -1 = none selected, -2 = new */
const selectedIndex = ref(-1);

const selectedArchive = computed(() => {
    let archive;

    if (selectedIndex.value === -2) {
        archive = <Archive>{};
        archive.portable_app_id = props.portableApp.id;
    } else {
        archive = selectedIndex.value > -1 ? props.archives[selectedIndex.value] : null;
    }

    return archive;
});

const unusedArchs = computed(() => {
    const allArchs = props.portableApp.archives.map((d) => d.arch);
    return archNames.filter((_arch, index) => allArchs.includes(index));
});

function addClicked() {
    selectedIndex.value = -2;
}

function editClicked(index: number) {
    if (selectedIndex.value != index) {
        selectedIndex.value = index;
    }
}

async function save() {
    if (selectedArchive.value) {
        try {
            await axios.request({
                baseURL: '/portable-apps/edit',
                url: selectedArchive.value.id ? `archives/${selectedArchive.value?.id}` : 'archives',
                method: selectedArchive.value.id ? 'PUT' : 'POST',
                data: selectedArchive.value
            });

            if (!selectedArchive.value.id) {
                archives.value.push(selectedArchive.value);
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

        archives.value = archives.value.filter((a) => a.id !== id);
        selectedIndex.value = -1;
    } catch (error) {
        console.error(
            'An error occurred while deleting installer'.concat(error instanceof Error ? `: ${error.message}` : '')
        );
    }
}
</script>
