import { defineStore } from 'pinia';
import { ref, watch } from 'vue';

export const useGlobalStore = defineStore('global', () => {
    const isLoading = ref(false);
    const pageTitle = ref('');

    watch(pageTitle, () => {
        const appName = 'sUpdater Server';
        document.title = pageTitle.value ? `${pageTitle.value} - ${appName}` : appName;
    });

    return {
        isLoading,
        pageTitle
    };
});
