<template>
    <div v-if="errorMessage" class="text-danger">An error occurred while fetching the detection info: {{ errorMessage }}</div>
    <div v-else-if="!isLoading">
        <div class="mb-3 col-md-2">
            <label for="archSelect">Arch</label>
            <select class="form-select" id="archSelect" name="arch" v-model="detectInfo.arch">
                <option value="0">Any</option>
                <option value="1">32-bit</option>
                <option value="2">64-bit</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="regKeyInput">Registry key</label>
            <input type="text" class="form-control" id="regKeyInput" name="regKey" :value="detectInfo.reg_key" />
        </div>

        <div class="mb-3 col-md-3">
            <label for="regValueInput">Registry value</label>
            <input type="text" class="form-control" id="regValueInput" name="regValue"
                :value="detectInfo.reg_value" />
        </div>

        <div class="mb-3">
            <label for="exePathInput">Executable path</label>
            <input type="text" class="form-control" id="exePathInput" name="exePath"
                :value="detectInfo.exe_path" />
            <details>
                <summary>Available variables</summary>
                <p>%pf64% = Program Files on 64 bit systems, does not detect on 32 bit systems<br />
                    %pf32% = Program Files (x86) on 64 bit systems, Program Files on 32 bit systems</p>
            </details>
        </div>

        <input type="hidden" name="id" :value="detectInfo.id" />
        <input class="btn btn-primary" type="submit" value="Save" />
    </div>
</template>

<script lang="ts" setup>
import { ref, onMounted } from 'vue';
import { useFetch } from '../../../fetch';

const props = defineProps({
    id: String
});

const isLoading = ref(true);
const detectInfo = ref();
const errorMessage = ref();

onMounted(() => {
    if (props.id !== '') {
        useFetch(`detectinfo/${props.id}`).then(({ json, error }) => {
            detectInfo.value = json;
            errorMessage.value = error?.message;
            isLoading.value = false;
        });
    } else {
        detectInfo.value = {};
        isLoading.value = false;
    }
});

</script>