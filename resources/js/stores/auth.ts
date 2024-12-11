import axios from 'axios';
import { defineStore } from 'pinia';
import { computed, ref } from 'vue';
import LoginForm from '../types/LoginForm';

export const useAuthStore = defineStore('auth', () => {
    const authenticated = ref(false);
    const user = ref();

    const token = computed({
        get: () => localStorage.getItem('token'),
        set: (value) => localStorage.setItem('token', value ?? '')
    });

    async function logIn(loginForm: LoginForm) {
        await axios.get('/sanctum/csrf-cookie');
        const response = await axios.post('login', loginForm);

        if (response.status === 200) {
            token.value = response.data.token;
            user.value = response.data.user;
        }
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
