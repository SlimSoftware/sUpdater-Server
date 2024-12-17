<script setup lang="ts">
import { ref } from 'vue';
import LoginForm from '../types/LoginForm';
import { useAuthStore } from '../stores/auth';
import router from '../router';

const authStore = useAuthStore();

const loginForm = ref<LoginForm>({} as LoginForm);

async function submitLoginForm() {
    const success = await authStore.logIn(loginForm.value);
    if (success) router.push('apps');
}
</script>

<template>
    <form :onsubmit="submitLoginForm">
        <div class="col-md-4 mb-3">
            <label for="username">Username</label>
            <input v-model="loginForm.username" type="text" class="form-control" required />
        </div>

        <div class="col-md-4 mb-3">
            <label for="password">Password</label>
            <input
                v-model="loginForm.password"
                type="password"
                class="form-control"
                autocomplete="current-password"
                required
            />
        </div>

        <input class="btn btn-primary" type="submit" value="Log In" />
    </form>
</template>
