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
            <tr v-for="(info, index) in detectinfo" :key="index">
                <td>{{ archNames[info.arch] }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" @click="editClicked(index)">
                        <i class="bi-pencil-fill"></i>
                    </a>
                </td>
                <td>
                    <DeleteButton @delete-confirmed="deleteConfirmed(info.id)" />
                </td>
            </tr>
        </tbody>
    </table>

    <div v-if="selectedDetectInfo">
        <form @submit.prevent="save">
            <div class="mb-3 col-md-2">
                <label for="archSelect">Arch</label>
                <select id="archSelect" v-model="selectedDetectInfo.arch" class="form-select" name="arch" required>
                    <option v-for="(arch, index) in archNames" :key="index" :value="index">{{ arch }}</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="regKeyInput">Registry key</label>
                <input
                    id="regKeyInput"
                    v-model="selectedDetectInfo.reg_key"
                    type="text"
                    class="form-control"
                    name="regKey"
                />
            </div>

            <div class="mb-3 col-md-3">
                <label for="regValueInput">Registry value</label>
                <input
                    id="regValueInput"
                    v-model="selectedDetectInfo.reg_value"
                    type="text"
                    class="form-control"
                    name="regValue"
                />
            </div>

            <div class="mb-3">
                <label for="exePathInput">Executable path</label>
                <input
                    id="exePathInput"
                    v-model="selectedDetectInfo.exe_path"
                    type="text"
                    class="form-control"
                    name="exePath"
                />
                <details>
                    <summary>Available variables</summary>
                    <p>
                        %pf64% = Program Files on 64 bit systems, does not detect on 32 bit systems<br />
                        %pf32% = Program Files (x86) on 64 bit systems, Program Files on 32 bit systems
                    </p>
                </details>
            </div>

            <input class="btn btn-primary" :value="saveButtonText" type="submit" />
        </form>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import DeleteButton from '../../DeleteButton.vue';
import { archNames } from '../../../enums/Arch';
import axios from 'axios';

const props = defineProps({
    detectinfo: {
        type: Array<DetectInfo>,
        default: []
    },
    appId: {
        type: Number,
        default: undefined
    }
});

const detectinfo = ref(props.detectinfo);

/** The index of the detectinfo to edit. -1 = none selected, -2 = new */
const selectedIndex = ref(-1);

const selectedDetectInfo = computed(() => {
    let info;

    if (selectedIndex.value === -2) {
        info = <DetectInfo>{};
        if (props.appId) {
            info.app_id = props.appId;
        }
    } else {
        info = selectedIndex.value > -1 ? detectinfo.value[selectedIndex.value] : null;
        if (info && props.appId) {
            info.app_id = props.appId;
        }
    }

    return info;
});

const saveButtonText = computed(() => {
    return selectedDetectInfo.value?.id ? 'Edit' : 'Save';
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
    if (selectedDetectInfo.value) {
        try {
            await axios.request({
                baseURL: '/apps/edit',
                url: selectedDetectInfo.value.id ? `detectinfo/${selectedDetectInfo.value?.id}` : 'detectinfo',
                method: selectedDetectInfo.value.id ? 'PUT' : 'POST',
                data: selectedDetectInfo.value
            });

            if (!selectedDetectInfo.value.id) {
                detectinfo.value.push(selectedDetectInfo.value);
                selectedIndex.value = -2;
            } else {
                selectedIndex.value = -1;
            }
        } catch (error) {
            console.error(
                'An error occurred while saving detect info'.concat(error instanceof Error ? `: ${error.message}` : '')
            );
        }
    }
}

async function deleteConfirmed(id: number) {
    try {
        await axios.request({
            baseURL: '/apps/edit',
            url: `detectinfo/${id}`
        });

        detectinfo.value = detectinfo.value.filter((i) => i.id !== id);
        selectedIndex.value = -1;
    } catch (error) {
        console.error(
            'An error occurred while deleting detect info'.concat(error instanceof Error ? `: ${error.message}` : '')
        );
    }
}
</script>
