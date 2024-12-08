<script setup lang="ts">

</script>

<template>
<li class="nav-item">
    <a :class="{'nav-link': true, 'active': Route::is($routeName)})
        href="{{ route($routeName) }}">
        {{ $pageTitle }}
    </a>
</li>
</template>