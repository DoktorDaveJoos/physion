<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import CellarForm from '../../../../Components/CellarForm.vue';
import RoofForm from '../../../../Components/RoofForm.vue';
import WallForm from '../../../../Components/WallForm.vue';
import { ref } from 'vue';
import BzCard from '../../Components/BzCard.vue';
import BuildingWrapper from '../Shared/BuildingWrapper.vue';

const props = defineProps({
    building: Object,
});

const active = ref('wall');

const form = useForm({});

const steps = [
    {
        name: 'Gebäude',
        route: route('buildings.index'),
    },
    {
        name:
            props.building.data.address +
            ', ' +
            props.building.data.postal_code +
            ' ' +
            props.building.data.city,
        route: route('buildings.show', {
            building: props.building.data.id,
        }),
    },

    {
        name: 'Thermische Hülle',
        route: route('buildings.thermal.show', {
            building: route().params.building,
        }),
    },
];
</script>

<template>
    <Head>
        <title>Thermische Hülle</title>
    </Head>

    <building-wrapper :building="building" sub-tabs-active>
        <div class="py-4 space-y-4">
            <bz-card>
                <template #title>Wandaufbau</template>
                <template #subtitle
                    >Angaben zur Außenwand, Fenster und Dämmung
                </template>
                <template #content>
                    <wall-form
                        :building-id="building.data.id"
                        :wall="building.data.wall" />
                </template>
            </bz-card>

            <bz-card>
                <template #title>Dachaufbau</template>
                <template #subtitle
                    >Angaben zum Dach, Dachfenster und Dämmung
                </template>
                <template #content>
                    <roof-form
                        :building-id="building.data.id"
                        :roof="building.data.roof" />
                </template>
            </bz-card>

            <bz-card>
                <template #title>Keller</template>
                <template #subtitle
                    >Angaben zum Keller, Kellerdecke und Dämmung
                </template>
                <template #content>
                    <cellar-form
                        :building-id="building.data.id"
                        :cellar="building.data.cellarModel" />
                </template>
            </bz-card>
        </div>
    </building-wrapper>
</template>
