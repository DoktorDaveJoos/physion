<script setup>
import AppLayout from '@/Layouts/SideBarLayout.vue';
import Welcome from '@/Jetstream/Welcome.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="flex flex-col">
                <a href="/nova">Nova</a>
                <a href="/telescope">Telescope (David only)</a>
            </div>
        </div>
    </AppLayout>
</template>
