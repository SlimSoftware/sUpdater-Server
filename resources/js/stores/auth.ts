import { defineStore } from 'pinia';
import { ref } from 'vue';

export const useAuthStore = defineStore('auth', () => {
    const authenticated = ref(false);
    const user = ref();

    async function logIn(payload) {}

    async function logOut() {}

    function parseToken(token: string) {}

    async function validateToken() {}

    return { authenticated, logIn, logOut, user, validateToken, parseToken };
});
