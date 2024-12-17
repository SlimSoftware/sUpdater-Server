import axios from 'axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import LoginForm from '../types/LoginForm';
import User from '../types/User';

export const useAuthStore = defineStore('auth', () => {
    const authenticated = ref(false);
    const user = ref<User>();

    async function logIn(loginForm: LoginForm) {
        try {
            await axios.get('/sanctum/csrf-cookie');
            await axios.post('login', loginForm);
            user.value = { username: loginForm.username };
            return true;
        } catch (error) {
            console.error(error);
            return false;
        }
    }

    async function logOut() {
        await axios.post('logout');
        delete user.value;
    }

    async function checkAuth() {
        const response = await axios.get('authenticated');
        return response.data.authenticated as boolean;
    }

    return { authenticated, logIn, logOut, user, checkAuth };
});
