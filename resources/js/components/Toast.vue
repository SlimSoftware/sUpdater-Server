<script setup lang="ts">
import { nextTick, onMounted, useTemplateRef, watch } from 'vue';
import { useToastStore } from '../stores/toast';
import { Toast } from 'bootstrap';
import { storeToRefs } from 'pinia';

const toastStore = useToastStore();
const { toast } = storeToRefs(toastStore);

const toastRef = useTemplateRef('toastRef');

let bootstrapToast: Toast | null;

onMounted(() => {
    if (!toastRef.value) return;
    bootstrapToast = new Toast(toastRef.value, { delay: 3000 });
});

watch(
    () => toast.value.isVisible,
    async () => {
        if (toast.value.isVisible) {
            toast.value.type = toast.value.type !== 'success' ? toast.value.type : 'primary';
            await nextTick();

            bootstrapToast?.show();
            toastStore.toast.isVisible = false;
        }
    }
);
</script>

<template>
    <div
        :class="[
            'toast align-items-center',
            `bg-${toast.type}`,
            'position-fixed bottom-0 start-50 translate-middle-x p-2 mb-2 text-white'
        ]"
        role="alert"
        aria-live="assertive"
        aria-atomic="true"
        ref="toastRef"
    >
        <div class="d-flex">
            <div class="toast-body fs-6">{{ toast.message }}</div>
            <button
                type="button"
                class="btn-close btn-close-white me-2 m-auto"
                data-bs-dismiss="toast"
                aria-label="Close"
            ></button>
        </div>
    </div>
</template>
