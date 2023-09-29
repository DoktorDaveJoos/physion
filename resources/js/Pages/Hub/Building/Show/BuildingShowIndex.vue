<script setup>
import { Head } from '@inertiajs/vue3';
import BuildingDataCard from '../Cards/BuildingDataCard.vue';

import BuildingThermalCard from '../Cards/BuildingThermalCard.vue';
import BuildingEnergyCard from '../Cards/BuildingEnergyCard.vue';
import BuildingShowWrapper from './BuildingShowWrapper.vue';

defineProps({
    building: Object,
});
</script>

<template>
    <Head>
        <title>Gebäude</title>
    </Head>

    <building-show-wrapper :building="building">
        <building-data-card :building="building" />
        <building-thermal-card :building="building" />
        <building-energy-card :building="building" />
    </building-show-wrapper>
</template>
