<script setup>
import { EnvelopeIcon } from '@heroicons/vue/24/outline';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { onMounted, ref } from 'vue';
import { InertiaLink } from '@inertiajs/inertia-vue3';
import BzButton from '../../Components/BzButton.vue';
import BlinkingWrapper from './Components/BlinkingWrapper.vue';

defineProps({
    result: {
        type: Object,
        required: true,
    },
});

const statuses = {
    created: 'In Datenerfassung',
    open: 'In Bearbeitung',
    finalized: 'Datenerfassung abgeschlossen',
    shipped: 'Abgeschlossen',
    in_clarification: 'In Klärung',
};
</script>

<template>
    <blinking-wrapper>
        <div
            class="bg-white py-16 px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
            <div class="mx-auto max-w-lg lg:max-w-none">
                <div><h1 class="font-bold">Erledigt!</h1></div>
                <p class="mt-6">
                    Wir haben dir eine E-Mail mit dem Link zum Auftrag
                    zugeschickt.
                </p>
            </div>
        </div>
    </blinking-wrapper>
</template>
