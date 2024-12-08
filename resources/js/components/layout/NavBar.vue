<script setup lang="ts">
import NavItem from './navItem.vue';

const routes = {
    apps: 'Apps',
    portable_apps: 'Portable Apps',
};
</script>

<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/img/brand.png" width="32" height="32" class="d-inline-block align-top" alt="" />
                sUpdater Server
            </a>
            <!-- <button
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
                        v-for="(pageTitle, routeName) in routes"
                        :key="routeName"
                        :route-name="routeName"
                        :page-title="pageTitle"
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
                            {{ Auth::user()->username }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <a
                                        class="dropdown-item"
                                        href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                    >
                                        Log out
                                    </a>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div> -->
        </div>
    </nav>
</template>
