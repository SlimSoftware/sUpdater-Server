<template>
    <ul class="nav nav-tabs mb-3">
        <li class="nav-item">
            <a :class="{'nav-link': true, 'active': activePage === 0}" @click="switchPage(0)">General</a>
        </li>
        <li class="nav-item">
            <a :class="{'nav-link': true, 'active': activePage === 1, 'disabled': isNew}" @click="switchPage(1)">Detection</a>
        </li>
        <li class="nav-item">
            <a :class="{'nav-link': true, 'active': activePage === 2, 'disabled': isNew}" @click="switchPage(2)">Installers</a>
        </li>
    </ul>

    <slot name="appContent" v-if="activePage === 0"></slot>
    <slot name="detectInfoContent" v-if="activePage === 1"></slot>
    <slot name="installersContent" v-if="activePage === 2"></slot>
</template>

<script setup lang="ts">
import { ref } from 'vue';

const props = defineProps({
    active: {
        type: Number,
        default: () => 0
    },
    isNew: {
        type: Boolean,
        default: () => true
    }
});

const activePage = ref(props.active);

function switchPage(pageIndex: number) {
    if (activePage.value != pageIndex) {
        activePage.value = pageIndex;
    }
}
</script>