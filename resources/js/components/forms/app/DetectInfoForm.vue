<template>
    <h3 class="mt-4 d-inline-block">Detection Info</h3>
    <a class="btn btn-primary ms-2 mb-2" @click="addClicked" v-if="!addNew">Add</a>

    <table class="table table-sm table-striped table-bordered w-auto mt-2" v-if="detectinfo.length > 0">
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
                    <DeleteButton
                        :name="`the ${archNames[info.arch]} detection`"
                        @delete-confirmed="deleteConfirmed(info.id)"
                    />
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mt-2 fst-italic" v-else-if="!selectedDetectInfo">No detection info has been added yet</div>

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

            <input class="btn btn-primary" value="Save" type="submit" />
        </form>
    </div>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import DeleteButton from '../../DeleteButton.vue';
import { archNames } from '../../../enums/Arch';
import axios from 'axios';
import { useToastStore } from '../../../stores/toast';

const toastStore = useToastStore();

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
const addNew = ref(false);
const selectedIndex = ref<number | null>(null);

const selectedDetectInfo = computed(() => {
    let info;

    if (addNew.value) {
        info = <DetectInfo>{};
        if (props.appId) {
            info.app_id = props.appId;
        }
    } else {
        info = selectedIndex.value != null ? detectinfo.value[selectedIndex.value] : null;
        if (info && props.appId) {
            info.app_id = props.appId;
        }
    }

    return info;
});

function addClicked() {
    addNew.value = true;
}

function editClicked(index: number) {
    if (selectedIndex.value != index) {
        selectedIndex.value = index;
    } else {
        selectedIndex.value = null;
    }

    addNew.value = false;
}

async function save() {
    if (selectedDetectInfo.value) {
        try {
            await axios.request({
                url: `apps/detectinfo/${selectedDetectInfo.value?.id ?? ''}`,
                method: selectedDetectInfo.value.id ? 'PUT' : 'POST',
                data: selectedDetectInfo.value
            });

            if (!selectedDetectInfo.value.id) {
                detectinfo.value.push(selectedDetectInfo.value);
            }

            selectedIndex.value = null;
            toastStore.show('Succesfully saved the detection info', 'success');
        } catch (error) {
            toastStore.show('An error occurred while saving the detection info', 'danger');
            console.error(error);
        }
    }
}

async function deleteConfirmed(id: number) {
    try {
        await axios.delete(`/apps/detectinfo/${id}`);

        detectinfo.value = detectinfo.value.filter((i) => i.id !== id);
        selectedIndex.value = null;
    } catch (error) {
        toastStore.show('An error occurred while deleting the detection info', 'danger');
        console.error(error);
    }
}
</script>
