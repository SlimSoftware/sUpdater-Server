<script setup lang="ts">
import router, { routes } from '../../router';
import { useAuthStore } from '../../stores/auth';
import NavItem from './NavItem.vue';

const navRoutes = routes.filter((r) => r.meta?.showInMenu === true);

const authStore = useAuthStore();

async function logOut() {
    await authStore.logOut();
    router.push('login');
}
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/img/brand.png" width="32" height="32" class="d-inline-block align-top" alt="" />
                sUpdater Server
            </a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navbarSupportedContent" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    <NavItem
                        v-for="route in navRoutes"
                        :key="route.name"
                        :route-name="route.name?.toString() ?? ''"
                        :page-title="route.meta?.pageTitle ?? ''"
                    />
                </ul>
                <ul class="navbar-nav my-2 my-md-0">
                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="userDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                        >
                            {{ authStore.user?.username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <a class="dropdown-item" @click="logOut"> Log out </a>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>
