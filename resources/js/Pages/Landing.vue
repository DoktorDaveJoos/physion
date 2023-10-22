<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';

import { Head } from '@inertiajs/vue3';

// const checkTool = ref(false);
</script>

<template>
    <GuestLayout>
        <Head>
            <title>Startseite</title>
        </Head>

        <div class="w-full">
            <div class="grid grid-cols-2">
                <div class="flex flex-col items-center justify-center">
                    <span class="text-primary text-lg">
                        bauzertifikate.de
                    </span>
                </div>
                <div class="min-h-screen bg-primary w-full" />
            </div>
        </div>
    </GuestLayout>
</template>
