<script setup>
import { EnvelopeIcon } from '@heroicons/vue/24/outline';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { onMounted, ref } from 'vue';
import { InertiaLink } from '@inertiajs/inertia-vue3';
import BzButton from '../../Components/BzButton.vue';

defineProps({
    result: {
        type: Object,
        required: true,
    },
});

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

const statuses = {
    created: 'In Datenerfassung',
    open: 'In Bearbeitung',
    finalized: 'Datenerfassung abgeschlossen',
    shipped: 'Abgeschlossen',
    in_clarification: 'In Klärung',
};
</script>

<template>
    <GuestLayout>
        <div class="relative bg-white">
            <div class="absolute inset-0">
                <div class="absolute inset-y-0 left-0 w-1/2 bg-slate-50" />
            </div>
            <div class="relative mx-auto max-w-7xl lg:grid lg:grid-cols-5">
                <div
                    class="bg-slate-50 py-16 px-6 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12">
                    <div class="mx-auto max-w-lg">
                        <h2
                            class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            Find my {{ animated }}{{ blinking ? '|' : '' }}
                        </h2>
                        <p class="mt-3 text-lg leading-6 text-gray-500">
                            Unser einzigartiger "Find My Energieausweis" Service
                            garantiert, dass Sie Ihren Energieausweis niemals
                            wieder verlieren oder verlegen können.
                        </p>
                        <p class="mt-3 text-lg leading-6 text-gray-500">
                            Selbst wenn Sie die Bestellnummer nicht mehr kennen,
                            können Sie Ihren Ausweis einfach durch die Angabe
                            Ihrer E-Mail-Adresse in Verbindung mit der
                            Postleitzahl des Gebäudes auffinden. Mit dieser
                            innovativen Lösung haben Sie jederzeit und von
                            überall Zugriff auf Ihren wichtigen Energieausweis.
                        </p>
                        <dl class="mt-8 text-base text-gray-500">
                            <div class="mt-3">
                                <dt class="">Trotzdem nicht gefunden?</dt>
                                <dd class="flex items-center">
                                    <EnvelopeIcon
                                        class="h-6 w-6 flex-shrink-0 text-gray-400"
                                        aria-hidden="true" />
                                    <span class="ml-3"
                                        >support@bauzertifikate.de</span
                                    >
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div
                    class="bg-white py-16 px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
                    <div class="mx-auto max-w-lg lg:max-w-none">
                        <div>
                            <h1 class="font-bold text-2xl">Ergebnis</h1>
                            <div class="mt-6 flow-root">
                                <ul
                                    role="list"
                                    class="divide-y divide-gray-100">
                                    <li
                                        class="flex items-center justify-between gap-x-6 py-5">
                                        <div class="min-w-0">
                                            <div
                                                class="flex items-start gap-x-3">
                                                <p
                                                    class="text-sm font-semibold leading-6 text-gray-900">
                                                    #{{ result.data.slug }}
                                                </p>
                                                <p
                                                    class="rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-600">
                                                    {{
                                                        statuses[
                                                            result.data.status
                                                        ]
                                                    }}
                                                </p>
                                            </div>
                                            <div
                                                class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                                <p class="whitespace-nowrap">
                                                    Erstellt am
                                                    <time
                                                        :datetime="
                                                            result.created_at
                                                        "
                                                        >{{
                                                            result.data
                                                                .created_at
                                                        }}</time
                                                    >
                                                </p>
                                            </div>
                                        </div>
                                        <div
                                            class="flex flex-none items-center gap-x-4">
                                            <bz-button
                                                type="secondary"
                                                as="link"
                                                :href="result.links.self"
                                                >Bestellung ansehen</bz-button
                                            >
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
