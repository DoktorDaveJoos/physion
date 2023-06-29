<template>
    <GuestLayout>
        <div class="absolute inset-0 flex">
            <div class="hidden w-5/12 md:flex flex-col bg-slate-50 -z-10"></div>
        </div>
        <div class="flex flex-col flex-grow md:flex-row">
            <div
                class="flex justify-center md:justify-end bg-slate-50 py-16 px-6 md:w-5/12 lg:px-8 lg:py-24 xl:pr-12">
                <div class="w-full max-w-lg">
                    <h2
                        class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                        Find my {{ animated }}{{ blinking ? '|' : '' }}
                    </h2>
                    <p class="mt-3 text-lg leading-6 text-gray-500">
                        Unser einzigartiger "Find My Energieausweis" Service
                        garantiert, dass Sie Ihren Energieausweis niemals wieder
                        verlieren oder verlegen können.
                    </p>
                    <p class="mt-3 text-lg leading-6 text-gray-500">
                        Selbst wenn Sie die Bestellnummer nicht mehr kennen,
                        können Sie Ihren Ausweis einfach durch die Angabe Ihrer
                        E-Mail-Adresse in Verbindung mit der Postleitzahl des
                        Gebäudes auffinden. Mit dieser innovativen Lösung haben
                        Sie jederzeit und von überall Zugriff auf Ihren
                        wichtigen Energieausweis.
                    </p>
                    <dl class="mt-8 text-base text-gray-500">
                        <div class="mt-3">
                            <dt class="">Trotzdem nicht gefunden?</dt>
                            <dd class="flex items-center">
                                <EnvelopeIcon
                                    aria-hidden="true"
                                    class="h-6 w-6 flex-shrink-0 text-gray-400" />
                                <span class="ml-3"
                                    >support@bauzertifikate.de</span
                                >
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
            <slot />
        </div>
    </GuestLayout>
</template>

<script setup>
import { EnvelopeIcon } from '@heroicons/vue/24/outline';
import GuestLayout from '../../../Layouts/GuestLayout.vue';
import { onMounted, ref } from 'vue';

const animated = ref('');
const blinking = ref(true);
const waiting = ref(true);

setInterval(() => {
    if (animated.value === 'Energieausweis' && waiting.value) {
        blinking.value = !blinking.value;
    }
}, 500);

onMounted(() => {
    'Energieausweis'.split('').forEach((letter, index) => {
        setTimeout(() => {
            animated.value += letter;
        }, 150 * index);
    });

    setTimeout(() => {
        waiting.value = false;
    }, 150 * 'Energieausweis'.length + 3000);
});
</script>
