<script setup>
import { PaperClipIcon } from '@heroicons/vue/24/outline';
import BzButton from '../../../../Components/BzButton.vue';

defineProps({
    building: Object,
});
</script>

<template>
    <div class="rounded-lg shadow bg-white ring-2 ring-blue-300 flex flex-col">
        <div class="flex px-6 py-4 justify-between items-center">
            <div>
                <h3 class="text-base font-semibold leading-7 text-gray-900">
                    Produkte
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    Energieausweise, Sanierungsfahrplan & BzA
                </p>
            </div>
        </div>
        <div class="border-t border-gray-100">
            <ul class="divide-y divide-gray-100">
                <li class="px-6 py-4 grid grid-cols-3 items-center">
                    <span class="leading-6 font-semibold text-gray-900"
                        >Verbrauchsausweis</span
                    >
                    <p class="text-xs text-gray-500 max-w-md">
                        Verbrauchsorientierter Energieausweis. Für Wohngebäude
                        ab 1978. Verbrauchsdaten der letzten 3 Jahre
                        erforderlich.
                    </p>
                    <div class="flex justify-end">
                        <bz-button type="secondary">bestellen</bz-button>
                    </div>
                </li>
                <li
                    v-if="!building.data.products.bdrf"
                    class="px-6 py-4 grid grid-cols-3 items-center">
                    <span class="leading-6 font-semibold text-gray-900"
                        >Bedarfsausweis</span
                    >
                    <p class="text-xs text-gray-500 max-w-md">
                        Verbrauchsorientierter Energieausweis. Für alle
                        Wohngebäude. Keine Verbrauchsdaten erforderlich.
                    </p>
                    <div class="flex justify-end">
                        <bz-button type="secondary">bestellen</bz-button>
                    </div>
                </li>
                <li class="px-6 py-4 grid grid-cols-3 items-center">
                    <span class="leading-6 font-semibold text-gray-900"
                        >Sanierungsfahrplan</span
                    >
                    <p class="text-xs text-gray-500 max-w-md">
                        iFSP Sanierungsfahrplan. Für alle bestehenden
                        Wohngebäude.
                    </p>
                    <div class="flex justify-end">
                        <bz-button type="secondary">bestellen</bz-button>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>
