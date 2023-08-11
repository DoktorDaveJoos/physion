<script setup>
import { Link } from '@inertiajs/vue3';
import ApplicationLogo from './ApplicationLogo.vue';
import ApplicationMark from './ApplicationMark.vue';
</script>

<template>
    <Link :href="'/'">
        <div class="flex flex-col items-center">
            <application-mark />
        </div>
    </Link>
</template>
