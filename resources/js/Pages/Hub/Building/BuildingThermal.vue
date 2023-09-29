<script setup>
import { Head, useForm, Link } from '@inertiajs/vue3';
import SidebarLayout from '../../../Layouts/SidebarLayout.vue';
import {
    CheckCircleIcon,
    ExclamationTriangleIcon,
    ChevronRightIcon,
} from '@heroicons/vue/20/solid';
import CellarForm from '../../../Components/CellarForm.vue';
import RoofForm from '../../../Components/RoofForm.vue';
import WallForm from '../../../Components/WallForm.vue';
import { ref } from 'vue';
import BzBreadcrumbs from '../Components/BzBreadcrumbs.vue';
import BzCard from '../Components/BzCard.vue';

const props = defineProps({
    building: Object,
});

const active = ref('wall');

const form = useForm({});

const steps = [
    {
        name: 'Gebäude',
        route: route('hub.buildings.index'),
    },
    {
        name:
            props.building.data.address +
            ', ' +
            props.building.data.postal_code +
            ' ' +
            props.building.data.city,
        route: route('hub.buildings.show.index', {
            building: props.building.data.id,
        }),
    },

    {
        name: 'Thermische Hülle',
        route: route('hub.buildings.thermal', {
            building: route().params.building,
        }),
    },
];
</script>

<template>
    <Head>
        <title>Thermische Hülle</title>
    </Head>

    <SidebarLayout>
        <bz-breadcrumbs :steps="steps" />

        <bz-card>
            <template #title>Wandaufbau</template>
            <template #subtitle
                >Angaben zur Außenwand, Fenster und Dämmung</template
            >
            <template #content>
                <wall-form
                    :building-id="building.data.id"
                    :wall="building.data.wall" />
            </template>
        </bz-card>

        <bz-card>
            <template #title>Dachaufbau</template>
            <template #subtitle
                >Angaben zum Dach, Dachfenster und Dämmung</template
            >
            <template #content>
                <roof-form
                    :building-id="building.data.id"
                    :roof="building.data.roof" />
            </template>
        </bz-card>

        <bz-card>
            <template #title>Keller</template>
            <template #subtitle
                >Angaben zum Keller, Kellerdecke und Dämmung</template
            >
            <template #content>
                <cellar-form
                    :building-id="building.data.id"
                    :cellar="building.data.cellarModel" />
            </template>
        </bz-card>
    </SidebarLayout>
</template>
