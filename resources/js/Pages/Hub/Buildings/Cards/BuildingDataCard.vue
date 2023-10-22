<script setup>
import { PaperClipIcon } from '@heroicons/vue/24/outline';
import BzButton from '../../../../Components/BzButton.vue';

defineProps({
    building: Object,
});
</script>

<template>
    <div class="rounded-lg shadow bg-white mt-4 flex flex-col">
        <div class="flex px-6 py-4 justify-between items-center">
            <div>
                <h3 class="text-base font-semibold leading-7 text-gray-900">
                    Gebäudedaten
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    Detaillierte Angaben zum Gebäude
                </p>
            </div>
            <bz-button type="secondary">bearbeiten</bz-button>
        </div>
        <div class="border-t border-gray-100">
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Adresse
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.address }},
                        {{ building.data.postal_code }}
                        {{ building.data.city }}
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Bauweise
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.type }},
                        {{ building.data.additional_type }}
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Wohnfläche
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.floor_area }} m²
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Wohneinheiten
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.housing_units }}
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Stockwerke
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.floors }}
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Baujahr (Heizung)
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.construction_year }} ({{
                            building.data.construction_year_heating ?? '-'
                        }})
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Keller
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.cellar }}
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Belüftung
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.ventilation }}
                    </dd>
                </div>
                <div class="px-4 py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm leading-6 font-medium text-gray-900">
                        Grundriss
                    </dt>
                    <dd
                        class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                        {{ building.data.layout }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</template>
