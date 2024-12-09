import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useGlobalStore = defineStore('global', () => {
    const isLoading = ref(false);

    return {
        isLoading
    };
});
