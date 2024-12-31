import axios from 'axios';
import { defineStore } from 'pinia';
import { ref } from 'vue';
import LoginForm from '../types/LoginForm';
import User from '../types/User';

export const useAuthStore = defineStore('auth', () => {
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
        user.value = undefined;
    }

    async function checkAuth() {
        const response = await axios.get('authenticated');
        return response.data.authenticated as boolean;
    }

    async function getUser() {
        const response = await axios.get('user');
        user.value = response.data;
        return user.value;
    }

    return { logIn, logOut, user, checkAuth, getUser };
});
