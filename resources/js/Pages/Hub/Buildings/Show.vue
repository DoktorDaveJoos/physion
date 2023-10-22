<script setup>
import { Head } from '@inertiajs/vue3';
import BuildingDataCard from './Cards/BuildingDataCard.vue';

import BuildingThermalCard from './Cards/BuildingThermalCard.vue';
import BuildingEnergyCard from './Cards/BuildingEnergyCard.vue';
import BuildingWrapper from './Shared/BuildingWrapper.vue';

defineProps({
    building: Object,
});
</script>

<template>
    <Head>
        <title>Gebäude</title>
    </Head>

    <building-wrapper :building="building" sub-tabs-active>
        <building-data-card :building="building" />
        <building-thermal-card :building="building" />
        <building-energy-card :building="building" />
    </building-wrapper>
</template>
