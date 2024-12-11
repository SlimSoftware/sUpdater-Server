<script setup lang="ts">
import { ref } from 'vue';
import LoginForm from '../types/LoginForm';
import { useAuthStore } from '../stores/auth';

const authStore = useAuthStore();

const loginForm = ref<LoginForm>({} as LoginForm);

async function submitLoginForm() {
    await authStore.logIn(loginForm.value);
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
