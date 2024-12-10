import axios from 'axios';
import { defineStore } from 'pinia';
import { computed, ref } from 'vue';

export const useAuthStore = defineStore('auth', () => {
    const authenticated = ref(false);
    const user = ref();

    const token = computed({
        get: () => localStorage.getItem('token'),
        set: (value) => localStorage.setItem('token', value ?? '')
    });

    async function logIn(payload: object) {
        await axios.post('logout', payload);
        user.value = null;
    }

    async function logOut() {
        await axios.post('logout');
        user.value = null;
    }

    function parseToken(token: string) {}

    async function checkAuth() {
        const response = await axios.get('authenticated');
        return response.data.authenticated as boolean;
    }

    return { authenticated, logIn, logOut, user, checkAuth, parseToken };
});
