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
            <tr v-for="info, index in detectInfo">
                <td>{{ getArchString(info.arch) }}</td>
                <td>
                    <a class="btn btn-primary btn-sm" @click="editClicked(index)">
                        <i class="bi-pencil-fill"></i>
                    </a>
                </td>
                <td>
                    <DeleteButton :id="info.id.toString()" @delete-confirmed="(info.id)" />
                </td>
            </tr>
        </tbody>
    </table>

    <input class="btn btn-primary" value="Add" />

    <div v-if="selectedDetectInfo">
        <div class="mb-3 col-md-2">
            <label for="archSelect">Arch</label>
            <select class="form-select" id="archSelect" name="arch" v-model="selectedDetectInfo.arch">
                <option value="0">{{ getArchString(0) }}</option>
                <option value="1">{{ getArchString(1) }}</option>
                <option value="2">{{ getArchString(2) }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="regKeyInput">Registry key</label>
            <input type="text" class="form-control" id="regKeyInput" name="regKey" :value="selectedDetectInfo.reg_key" />
        </div>

        <div class="mb-3 col-md-3">
            <label for="regValueInput">Registry value</label>
            <input type="text" class="form-control" id="regValueInput" name="regValue"
                :value="selectedDetectInfo.reg_value" />
        </div>

        <div class="mb-3">
            <label for="exePathInput">Executable path</label>
            <input type="text" class="form-control" id="exePathInput" name="exePath" :value="selectedDetectInfo.exe_path" />
            <details>
                <summary>Available variables</summary>
                <p>%pf64% = Program Files on 64 bit systems, does not detect on 32 bit systems<br />
                    %pf32% = Program Files (x86) on 64 bit systems, Program Files on 32 bit systems</p>
            </details>
        </div>

        <input type="hidden" name="id" :value="selectedDetectInfo.id" />
        <input class="btn btn-primary" type="submit" value="Save" />
    </div>
</template>

<script lang="ts" setup>
import { computed, ref } from 'vue';
import DeleteButton from '../../DeleteButton.vue';

const props = defineProps({
    detectInfo: {
        type: Array<DetectInfo>,
        default: () => []
    }
});

console.log(props.detectInfo);

const selectedIndex = ref(-1);
const selectedDetectInfo = computed(() => {
    return selectedIndex.value !== -1 ? props.detectInfo[selectedIndex.value] : null;
});

function getArchString(arch: number) {
    if (arch === 0)
        return 'Any';
    else if (arch === 1)
        return '32-bit';
    else if (arch === 2)
        return '64-bit';
}

function editClicked(index: number) {
    if (selectedIndex.value != index) {
        selectedIndex.value = index;
    }
}
</script>