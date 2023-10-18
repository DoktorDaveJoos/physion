<script setup>
import { Head, router, useForm, usePage, Link } from '@inertiajs/vue3';

import BzCard from '../Components/BzCard.vue';
import SidebarLayout from '../../../Layouts/SidebarLayout.vue';
import BzBreadcrumbs from '../Components/BzBreadcrumbs.vue';
import {
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue';
import LayoutForm from '../../Certificate/Bdrf/Position/LayoutForm.vue';
import FormHeader from '../../../Components/FormHeader.vue';
import Orientation from '../../../Components/Orientation.vue';
import { CheckCircleIcon } from '@heroicons/vue/24/outline';
import BzButton from '../../../Components/BzButton.vue';
import Maps from '../../../Components/Maps.vue';
import { InformationCircleIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { ElNotification } from 'element-plus';
import { ref, watch } from 'vue';
import Badge from '../../../Components/Badge.vue';
import BuildingShowWrapper from './Show/BuildingShowWrapper.vue';

const props = defineProps({
    building: Object,
});

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
        name: 'Position & Grundriss',
        route: route('hub.buildings.show.position', {
            building: props.building.data.id,
        }),
    },
];

const form = useForm({
    layout: props.building.data.layout ?? 'rectangle',
    side_a: props.building.data.side_a
        ? parseInt(props.building.data.side_a)
        : null,
    side_b: props.building.data.side_b
        ? parseInt(props.building.data.side_b)
        : null,
    side_c: props.building.data.side_c
        ? parseInt(props.building.data.side_c)
        : null,
    side_d: props.building.data.side_d
        ? parseInt(props.building.data.side_d)
        : null,
    orientation: props.building.data.orientation ?? null,
    maps: props.building.data.maps ?? null,
});

const agree = () => {
    router.put(
        route('building.maps', {
            building: props.building.data?.id,
        }),
        {
            maps: 'agreed',
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                form.maps = 'agreed';
                ElNotification({
                    title: 'Super!',
                    message: 'Lage erfolgreich bestätigt',
                    type: 'success',
                });
            },
        }
    );
};

const deny = () => {
    router.put(
        route('building.maps', {
            building: props.building.data?.id,
        }),
        {
            maps: 'denied',
        },
        {
            preserveScroll: true,
            onSuccess: () => {
                form.maps = 'denied';
            },
        }
    );
};

const setOrientation = (value) => {
    form.orientation = value;
};

const submit = () => {
    form.put(
        route('hub.buildings.position.update', {
            building: props.building.data.id,
        })
    );
};

const floorPlans = [
    {
        id: 1,
        title: 'Rechteck',
        description: 'Rechteck & Quadrat',
        short: 'rectangle',
    },
    {
        id: 2,
        title: 'L-Form',
        description: 'Demnächst verfügbar',
        short: 'l',
    },
    {
        id: 3,
        title: 'T-Form',
        description: 'Demnächst verfügbar',
        short: 't',
    },
];

const selectedFloorPlan = ref(floorPlans.find((f) => f.short === form.layout));

watch(selectedFloorPlan, (value) => {
    form.layout = value.short;
    form.side_a = props.building.data.side_a
        ? parseInt(props.building.data.side_a)
        : null;
    form.side_b = props.building.data.side_b
        ? parseInt(props.building.data.side_b)
        : null;
    form.side_c = props.building.data.side_c
        ? parseInt(props.building.data.side_c)
        : null;
    form.side_d = props.building.data.side_d
        ? parseInt(props.building.data.side_d)
        : null;
});

if (!props.building.data.place_id && props.building.data.maps === 'initial') {
    // Deny on the fly if the user address has
    // no place_id and the maps status is initial
    deny();
}
</script>

<template>
    <Head>
        <title>Grundriss & Position</title>
    </Head>
    <building-show-wrapper :building="building" sub-tabs-active>
        <div
            v-if="building.data.status === 'created'"
            class="rounded-md bg-blue-50 p-4 border-2 border-blue-500 mt-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <InformationCircleIcon
                        class="h-5 w-5 text-primary"
                        aria-hidden="true" />
                </div>
                <div class="ml-3 flex-1 md:flex md:justify-between">
                    <p class="text-sm font-bold text-blue-700">
                        Jetzt Lage & Position erfassen für Verbrauchs- und
                        Bedarfsausweis
                    </p>
                    <p class="mt-3 text-sm md:ml-6 md:mt-0">
                        <Link
                            :href="
                                route(
                                    'hub.buildings.show.index',
                                    building.data.id
                                )
                            "
                            class="whitespace-nowrap font-medium text-blue-700 hover:text-primary">
                            Vielleicht später
                            <span aria-hidden="true"> &rarr;</span>
                        </Link>
                    </p>
                </div>
            </div>
        </div>

        <bz-card class="mt-4">
            <template #title>Grundriss & Position</template>
            <template #subtitle>Allgemeine Daten zum Gebäude angeben</template>
            <template #button>
                <!--                <bz-button type="primary" @click="form.submit()">-->
                <!--                    Gebäude anlegen-->
                <!--                </bz-button>-->
            </template>
            <template #content>
                <el-form label-position="top" size="large">
                    <div
                        class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
                        <div class="sm:col-span-2 mb-10">
                            <RadioGroup
                                v-model="selectedFloorPlan"
                                class="sm:col-span-2">
                                <div
                                    class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                                    <RadioGroupOption
                                        v-for="floorPlan in floorPlans"
                                        :key="floorPlan.id"
                                        v-slot="{ checked, active }"
                                        :value="floorPlan"
                                        as="template">
                                        <div
                                            :class="[
                                                checked
                                                    ? 'border-transparent'
                                                    : 'border-gray-300',
                                                active
                                                    ? 'border-blue-500 ring-2 ring-blue-500'
                                                    : '',
                                                floorPlan.active
                                                    ? ''
                                                    : 'cursor-not-allowed',
                                                'relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none',
                                            ]">
                                            <span class="flex flex-1">
                                                <span class="flex flex-col">
                                                    <RadioGroupLabel
                                                        as="span"
                                                        class="block text-sm font-medium text-gray-900">
                                                        {{ floorPlan.title }}
                                                    </RadioGroupLabel>
                                                    <RadioGroupDescription
                                                        as="span"
                                                        class="mt-1 flex items-center text-sm text-gray-500">
                                                        {{
                                                            floorPlan.description
                                                        }}
                                                    </RadioGroupDescription>
                                                    <RadioGroupDescription
                                                        as="div"
                                                        class="mt-6 flex text-sm font-medium text-gray-900">
                                                        <template
                                                            v-if="
                                                                floorPlan.short ===
                                                                'rectangle'
                                                            ">
                                                            <div
                                                                class="h-8 w-12 bg-blue-100"></div>
                                                        </template>

                                                        <template
                                                            v-if="
                                                                floorPlan.short ===
                                                                'l'
                                                            ">
                                                            <div
                                                                class="h-8 w-6 bg-blue-100"></div>
                                                            <div
                                                                class="h-5 w-6 bg-blue-100"></div>
                                                        </template>

                                                        <template
                                                            v-if="
                                                                floorPlan.short ===
                                                                't'
                                                            ">
                                                            <div
                                                                class="flex flex-col items-center">
                                                                <div
                                                                    class="h-4 w-5 bg-blue-100"></div>
                                                                <div
                                                                    class="h-4 w-12 bg-blue-100"></div>
                                                            </div>
                                                        </template>
                                                    </RadioGroupDescription>
                                                </span>
                                            </span>
                                            <CheckCircleIcon
                                                :class="[
                                                    !checked ? 'invisible' : '',
                                                    'h-5 w-5 text-primary',
                                                ]"
                                                aria-hidden="true" />
                                            <span
                                                :class="[
                                                    active
                                                        ? 'border'
                                                        : 'border-2',
                                                    checked
                                                        ? 'border-blue-500'
                                                        : 'border-transparent',
                                                    'pointer-events-none absolute -inset-px rounded-lg',
                                                ]"
                                                aria-hidden="true" />
                                        </div>
                                    </RadioGroupOption>
                                </div>
                            </RadioGroup>
                        </div>
                        <LayoutForm
                            :form="form"
                            :type="selectedFloorPlan.short" />
                    </div>

                    <div
                        class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
                        <div class="sm:col-span-2 grid grid-cols-2">
                            <div>
                                <template
                                    v-if="building.data.maps === 'initial'">
                                    <div
                                        class="flex flex-col h-full justify-center space-y-4">
                                        <div class="flex">
                                            <badge
                                                label="wichtig"
                                                type="error" />
                                        </div>
                                        <p class="mt-1 text-gray-500 text-sm">
                                            Auf der rechten Karte ist Ihre
                                            Adresse markiert und das Gebäude ist
                                            zu erkennen.
                                            <strong class="text-gray-700">
                                                Bitte überprüfen Sie, ob die
                                                korrekte Adresse markiert ist.
                                            </strong>
                                        </p>
                                        <div class="flex space-x-4">
                                            <bz-button @click="agree"
                                                >Bestätigen
                                            </bz-button>
                                            <bz-button
                                                type="secondary"
                                                @click="deny"
                                                >Nein / Nicht sicher
                                            </bz-button>
                                        </div>
                                    </div>
                                </template>

                                <template
                                    v-if="building.data.maps === 'agreed'">
                                    <div
                                        class="flex flex-col h-full justify-center space-y-4">
                                        <div class="flex">
                                            <badge
                                                label="bestätigt"
                                                type="success" />
                                        </div>
                                        <p class="mt-1 text-gray-500 text-sm">
                                            Auf der rechten Karte ist Ihre
                                            Adresse markiert und das Gebäude ist
                                            zu erkennen.
                                        </p>
                                        <div class="flex space-x-4">
                                            <bz-button
                                                type="secondary"
                                                @click="
                                                    building.data.maps =
                                                        'initial'
                                                "
                                                >Rückgängig
                                            </bz-button>
                                        </div>
                                    </div>
                                </template>

                                <template
                                    v-if="building.data.maps === 'denied'">
                                    <div
                                        class="flex flex-col h-full justify-center">
                                        <div
                                            class="flex-1 flex flex-col space-y-4 py-10">
                                            <div class="flex">
                                                <badge
                                                    label="manuell"
                                                    type="info" />
                                            </div>

                                            <p class="mt-1 text-gray-800">
                                                Bitte drehen Sie das Gebäude in
                                                der Anzeige rechts mithilfe der
                                                Schaltflächen so, dass es der
                                                Lage Ihres Gebäudes entspricht.
                                            </p>

                                            <div
                                                class="rounded-md bg-blue-50 p-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <InformationCircleIcon
                                                            aria-hidden="true"
                                                            class="h-5 w-5 text-blue-400" />
                                                    </div>
                                                    <div
                                                        class="ml-3 flex-1 md:flex md:justify-between">
                                                        <p
                                                            class="text-sm text-blue-700">
                                                            Die
                                                            <strong
                                                                >ungefähre</strong
                                                            >
                                                            Richtung ist
                                                            ausreichend
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            v-if="building.data.place_id"
                                            class="flex space-x-4">
                                            <bz-button
                                                plain
                                                @click="
                                                    building.data.maps =
                                                        'initial'
                                                "
                                                >Zurück zu Maps
                                            </bz-button>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <div>
                                <template
                                    v-if="
                                        building.data.maps === 'initial' ||
                                        building.data.maps === 'agreed'
                                    ">
                                    <Suspense>
                                        <div class="flex justify-end">
                                            <Maps
                                                :place_id="
                                                    building.data.place_id
                                                "
                                                @notFound="" />
                                        </div>
                                        <template #fallback>
                                            <div class="flex justify-end">
                                                <div
                                                    class="h-54 w-54 relative shadow-xl lg:h-72 lg:w-72 rounded-full overflow-hidden">
                                                    <div
                                                        class="absolute w-full h-full rounded-full bg-slate-50">
                                                        <div
                                                            class="absolute inset-0 flex items-center justify-center">
                                                            <div
                                                                class="h-12 w-12 rounded-full bg-slate-50 flex items-center justify-center">
                                                                <svg
                                                                    class="h-6 w-6 text-slate-500 animate-spin"
                                                                    fill="none"
                                                                    viewBox="0 0 24 24">
                                                                    <circle
                                                                        class="opacity-25"
                                                                        cx="12"
                                                                        cy="12"
                                                                        r="10"
                                                                        stroke="currentColor"
                                                                        stroke-width="4"></circle>
                                                                    <path
                                                                        class="opacity-75"
                                                                        d="M4 12a8 8 0 018-8v8z"
                                                                        fill="currentColor"></path>
                                                                </svg>
                                                            </div>
                                                            <span
                                                                class="text-xs text-gray-500"
                                                                >loading...</span
                                                            >
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </template>
                                    </Suspense>
                                </template>
                                <template v-else>
                                    <div class="flex justify-end">
                                        <Orientation
                                            :value="form.orientation"
                                            @change="setOrientation" />
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end py-4 px-6">
                        <bz-button
                            :disabled="
                                building.data.maps === 'initial' ||
                                !form.isDirty
                            "
                            @click="submit">
                            {{
                                building.data.maps === 'initial'
                                    ? 'Lage muss erst bestätigt werden'
                                    : 'Speichern'
                            }}
                        </bz-button>
                    </div>
                </el-form>
            </template>
        </bz-card>
    </building-show-wrapper>
</template>
