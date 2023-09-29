<script setup>
import SidebarLayout from '../../../Layouts/SidebarLayout.vue';
import { Head } from '@inertiajs/vue3';
import BuildingDocumentsCard from './Cards/BuildingDocumentsCard.vue';
import BuildingPhotosCard from './Cards/BuildingPhotosCard.vue';
import BuildingDataCard from './Cards/BuildingDataCard.vue';
import BuildingProductsCard from './Cards/BuildingProductsCard.vue';
import { ref } from 'vue';
import BuildingThermalCard from './Cards/BuildingThermalCard.vue';
import BuildingEnergyCard from './Cards/BuildingEnergyCard.vue';

defineProps({
    building: Object,
});

const tabs = [
    { name: 'Allgemein', idx: 0 },
    { name: 'Detail', idx: 1 },
    { name: 'Dokumente', idx: 2 },
    { name: 'Produkte', idx: 3 },
    { name: 'Förderungscheck', idx: 4 },
];

const active = ref(0);

const handleTabChange = (idx) => {
    active.value = tabs.find((tab) => tab.idx === idx).idx;
};
</script>

<template>
    <Head>
        <title>Gebäude</title>
    </Head>

    <SidebarLayout>
        <div
            class="rounded-lg shadow bg-white px-6 py-4 flex items-center justify-between mb-6">
            <div class="flex space-x-2">
                <h3
                    class="text-lg font-display font-semibold leading-6 text-gray-900">
                    {{ building.data.address }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    {{ building.data.postal_code }} {{ building.data.city }}
                </p>
            </div>
            <div>
                <div class="sm:hidden">
                    <label class="sr-only" for="tabs">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select
                        id="tabs"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        name="tabs">
                        <option
                            v-for="tab in tabs"
                            :key="tab.name"
                            :selected="tab.idx === active">
                            {{ tab.name }}
                        </option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav aria-label="Tabs" class="flex space-x-4">
                        <button
                            v-for="(tab, idx) in tabs"
                            :key="tab.name"
                            :aria-current="
                                tab.idx === active ? 'page' : undefined
                            "
                            :class="[
                                idx === active
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'text-gray-500 hover:text-gray-700',
                                'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',
                            ]"
                            type="button"
                            @click="handleTabChange(idx)">
                            {{ tab.name }}
                        </button>
                    </nav>
                </div>
            </div>
        </div>

        <template v-if="active === 0">
            <building-data-card :building="building" />
            <building-photos-card :building="building" />
        </template>
        <template v-else-if="active === 1">
            <building-thermal-card :building="building" />
            <building-energy-card :building="building" />
        </template>
        <template v-else-if="active === 2">
            <building-documents-card :building="building" />
        </template>
        <template v-else-if="active === 3">
            <building-products-card :building="building" />
        </template>
    </SidebarLayout>
</template>
