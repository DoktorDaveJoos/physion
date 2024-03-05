<script setup>
import { Head } from '@inertiajs/vue3';
import BuildingWrapper from '../Shared/BuildingWrapper.vue';
import CreateBuildingForm from '../../Components/CreateBuildingForm.vue';
import BzCard from '../../Components/BzCard.vue';

defineProps({
    building: Object,
});
</script>

<template>
    <Head>
        <title>Gebäude</title>
    </Head>

    <building-wrapper :building="building" sub-tabs-active>
        <suspense>
            <bz-card class="mt-4">
                <template #title>Allgemeine Daten</template>
                <template #subtitle
                    >Erfassen Sie allgemeine Daten zum Gebäude
                </template>
                <template #content>
                    <create-building-form :building="building" />
                </template>
            </bz-card>
        </suspense>
    </building-wrapper>
</template>
