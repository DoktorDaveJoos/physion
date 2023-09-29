<script setup>
import { Head } from '@inertiajs/vue3';
import BuildingDocumentsCard from '../Cards/BuildingDocumentsCard.vue';
import BuildingPhotosCard from '../Cards/BuildingPhotosCard.vue';
import BuildingShowWrapper from './BuildingShowWrapper.vue';

defineProps({
    building: Object,
});
</script>

<template>
    <Head>
        <title>Dokumente</title>
    </Head>

    <building-show-wrapper :building="building">
        <building-documents-card :building="building" />
        <building-photos-card :building="building" />
    </building-show-wrapper>
</template>
