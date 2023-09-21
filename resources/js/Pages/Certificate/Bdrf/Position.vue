<script setup>
import { CheckCircleIcon } from '@heroicons/vue/24/outline';
import { InformationCircleIcon } from '@heroicons/vue/20/solid';
import {
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue';
import { ref, watch } from 'vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import { ElNotification } from 'element-plus';
import FormHeader from '../../../Components/FormHeader.vue';
import Maps from '../../../Components/Maps.vue';
import Orientation from '../../../Components/Orientation.vue';
import PageWrapper from '../../../Wrappers/PageWrapper.vue';
import BzButton from '../../../Components/BzButton.vue';
import LayoutForm from './Position/LayoutForm.vue';

const props = defineProps({
    order: {
        type: Object,
        required: true,
    },
    signature: {
        type: String,
        required: true,
    },
});

const form = useForm({
    layout: props.order.certificate.layout ?? 'rectangle',
    side_a: props.order.certificate.side_a
        ? parseInt(props.order.certificate.side_a)
        : null,
    side_b: props.order.certificate.side_b
        ? parseInt(props.order.certificate.side_b)
        : null,
    side_c: props.order.certificate.side_c
        ? parseInt(props.order.certificate.side_c)
        : null,
    side_d: props.order.certificate.side_d
        ? parseInt(props.order.certificate.side_d)
        : null,
    orientation: props.order.certificate.orientation ?? null,
    maps: props.order.certificate.maps ?? null,
});

const agree = () => {
    router.put(
        route('bdrf.maps', {
            bdrf: props.order.certificate?.id,
            signature: props.signature,
            page: 'position',
        }),
        {
            maps: 'agreed',
        },
        {
            preserveScroll: true,
            onSuccess: () => {
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
        route('bdrf.maps', {
            bdrf: props.order.certificate?.id,
            signature: route().params.signature,
            page: 'position',
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
    const url = usePage().props.user
        ? route('hub.certificates.update', {
              order: props.order.slug,
              page: 'position',
          })
        : route('certificate.update', {
              order: props.order.slug,
              page: 'position',
              signature: route().params.signature,
          });

    form.put(url);
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
    form.side_a = props.order.certificate.side_a
        ? parseInt(props.order.certificate.side_a)
        : null;
    form.side_b = props.order.certificate.side_b
        ? parseInt(props.order.certificate.side_b)
        : null;
    form.side_c = props.order.certificate.side_c
        ? parseInt(props.order.certificate.side_c)
        : null;
    form.side_d = props.order.certificate.side_d
        ? parseInt(props.order.certificate.side_d)
        : null;
});

if (
    !props.order.certificate.place_id &&
    props.order.certificate.maps === 'initial'
) {
    // Deny on the fly if the user address has
    // no place_id and the maps status is initial
    deny();
}
</script>

<template>
    <page-wrapper>
        <el-form
            class="grid sm:grid-cols-2 sm:gap-x-8"
            label-position="top"
            size="large">
            <form-header
                subtitle="Geben Sie den Grundriss Ihres Gebäudes an und bemaßen Sie die Längen."
                title="Grundriss" />

            <div class="sm:col-span-2 mb-10">
                <RadioGroup v-model="selectedFloorPlan" class="sm:col-span-2">
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
                                            {{ floorPlan.description }}
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
                                                v-if="floorPlan.short === 'l'">
                                                <div
                                                    class="h-8 w-6 bg-blue-100"></div>
                                                <div
                                                    class="h-5 w-6 bg-blue-100"></div>
                                            </template>

                                            <template
                                                v-if="floorPlan.short === 't'">
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
                                        'h-5 w-5 text-blue-600',
                                    ]"
                                    aria-hidden="true" />
                                <span
                                    :class="[
                                        active ? 'border' : 'border-2',
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
            <LayoutForm :form="form" :type="selectedFloorPlan.short" />

            <el-divider class="sm:col-span-2"></el-divider>

            <form-header
                subtitle="Die Lage des Gebäudes ist wichtig für die Berechnung der
           Sonneneinstrahlung."
                title="Lage" />

            <div class="sm:col-span-2 grid grid-cols-2">
                <div>
                    <template v-if="order.certificate.maps === 'initial'">
                        <div
                            class="flex flex-col h-full justify-center space-y-4">
                            <div class="flex">
                                <span
                                    class="inline-flex items-center rounded-md bg-red-100 px-2.5 py-0.5 text-sm font-medium text-red-800"
                                    >Wichtig</span
                                >
                            </div>
                            <p class="mt-1 text-gray-800">
                                Auf der rechten Karte ist Ihre Adresse markiert
                                und das Gebäude ist zu erkennen.
                            </p>
                            <div class="flex space-x-4">
                                <el-button
                                    class="w-full justify-center sm:justify-start"
                                    type="primary"
                                    @click="agree"
                                    >Bestätige
                                </el-button>
                                <el-button
                                    class="w-full justify-center sm:justify-start"
                                    type="default"
                                    @click="deny"
                                    >Nein / Nicht sicher
                                </el-button>
                            </div>
                        </div>
                    </template>

                    <template v-if="order.certificate.maps === 'agreed'">
                        <div
                            class="flex flex-col h-full justify-center space-y-4">
                            <div class="flex">
                                <span
                                    class="inline-flex items-center rounded-md bg-green-100 px-2.5 py-0.5 text-sm font-medium text-green-800"
                                    >Bestätigt</span
                                >
                            </div>
                            <p class="mt-1 text-gray-800">
                                Auf der rechten Karte ist Ihre Adresse markiert
                                und das Gebäude ist zu erkennen.
                            </p>
                            <div class="flex space-x-4">
                                <el-button
                                    class=""
                                    @click="order.certificate.maps = 'initial'"
                                    >Rückgängig
                                </el-button>
                            </div>
                        </div>
                    </template>

                    <template v-if="order.certificate.maps === 'denied'">
                        <div class="flex flex-col h-full justify-center">
                            <div class="flex-1 flex flex-col space-y-4 py-10">
                                <div class="flex">
                                    <span
                                        class="inline-flex items-center rounded-md bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800"
                                        >Manuell</span
                                    >
                                </div>

                                <p class="mt-1 text-gray-800">
                                    Bitte drehen Sie das Gebäude in der Anzeige
                                    rechts mithilfe der Schaltflächen so, dass
                                    es der Lage Ihres Gebäudes entspricht.
                                </p>

                                <div class="rounded-md bg-blue-50 p-4">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <InformationCircleIcon
                                                aria-hidden="true"
                                                class="h-5 w-5 text-blue-400" />
                                        </div>
                                        <div
                                            class="ml-3 flex-1 md:flex md:justify-between">
                                            <p class="text-sm text-blue-700">
                                                Die
                                                <strong>ungefähre</strong>
                                                Richtung ist ausreichend
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div
                                v-if="order.certificate.place_id"
                                class="flex space-x-4">
                                <el-button
                                    text
                                    @click="order.certificate.maps = 'initial'"
                                    >Zurück zu Maps
                                </el-button>
                            </div>
                        </div>
                    </template>
                </div>

                <div>
                    <template
                        v-if="
                            order.certificate.maps === 'initial' ||
                            order.certificate.maps === 'agreed'
                        ">
                        <Suspense>
                            <div class="flex justify-end">
                                <Maps
                                    :place_id="order.certificate.place_id"
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

            <el-divider class="sm:col-span-2"></el-divider>

            <div class="grid sm:flex sm:justify-between sm:col-span-2 gap-4">
                <div class="grid sm:block">
                    <bz-button
                        v-if="$page.props.user"
                        as="link"
                        type="secondary"
                        :href="
                            route('hub.certificates.show', {
                                order: order.slug,
                                page: 'details',
                            })
                        ">
                        Zurück
                    </bz-button>
                    <bz-button
                        v-else
                        as="link"
                        type="secondary"
                        :href="
                            route('certificate.show', {
                                signature: route().params.signature,
                                order: order.slug,
                                page: 'details',
                            })
                        ">
                        Zurück
                    </bz-button>
                </div>
                <div class="grid sm:block">
                    <bz-button
                        :disabled="order.certificate.maps === 'initial'"
                        @click="submit">
                        {{
                            order.certificate.maps === 'initial'
                                ? 'Lage muss erst bestätigt werden'
                                : 'Speichern & Weiter'
                        }}
                    </bz-button>
                </div>
            </div>
        </el-form>
    </page-wrapper>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
