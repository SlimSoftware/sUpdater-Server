import { defineStore } from 'pinia';
import { reactive } from 'vue';

type ToastType = 'success' | 'danger' | 'info' | 'primary' | 'secondary';
type Toast = {
    isVisible: boolean;
    message: string;
    type: ToastType;
};

export const useToastStore = defineStore('toast', () => {
    const toast = reactive<Toast>({
        isVisible: false,
        message: '',
        type: 'success'
    });

    async function show(message: string, type: ToastType = 'info') {
        toast.message = message;
        toast.type = type;
        toast.isVisible = true;
    }

    return {
        show,
        toast
    };
});
