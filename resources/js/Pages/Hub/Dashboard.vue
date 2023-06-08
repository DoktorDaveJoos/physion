<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { InertiaLink } from '@inertiajs/inertia-vue3';
import SideNavWrapper from './Components/SideNavWrapper.vue';
</script>

<template>
    <side-nav-wrapper title="Hub" subtitle="Dashboard">
        <div class="flex flex-col bg-white p-10 rounded border border-gray-200">
            <p class="text-gray-800 text-md font-semibold">
                Welcome to the Hub!
            </p>

            <p class="text-gray-700 text-sm mt-6">
                Das ist das Hub Dashboard. In Zukunft wirst Du hier alles
                finden, was Du für Deine Ausweise benötigst. Wir arbeiten stetig
                daran, das Hub zu verbessern und neue Funktionen hinzuzufügen.
            </p>
        </div>
    </side-nav-wrapper>
</template>
