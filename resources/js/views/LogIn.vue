<script setup lang="ts"></script>

<template>
    <form method="POST" action="/login">
        <div class="col-md-4 mb-3">
            <label for="username">Username</label>
            <input
                id="username"
                type="text"
                class="form-control"
                name="username"
                value="{{ old('username') }}"
                required
            />
        </div>

        <div class="col-md-4 mb-3">
            <label for="password">Password</label>
            <input
                id="password"
                type="password"
                class="form-control"
                name="password"
                autocomplete="current-password"
                required
            />
        </div>

        <input class="btn btn-primary" type="submit" value="Log In" />
    </form>
</template>
