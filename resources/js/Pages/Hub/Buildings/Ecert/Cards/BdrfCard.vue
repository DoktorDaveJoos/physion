<script setup>
import BzButton from '../../../../../Components/BzButton.vue';
import { Link } from '@inertiajs/vue3';
import BzCard from '../../../Components/BzCard.vue';
import { CheckIcon } from '@heroicons/vue/24/outline';
import { computed } from 'vue';

const props = defineProps({
    building: Object,
});

defineEmits(['create-bdrf']);

const buildingData = computed(() => props.building.data);

const steps = [
    {
        id: '01',
        name: 'Gebäudedaten',
        description: 'Allgemeine Daten vollständig erfassen',
        href: '#',
        status: buildingData.value.general && buildingData.value.position ? 'complete' : 'current',
        links: [
            {
                show: !buildingData.value.general,
                name: 'Jetzt Gebäudedaten erfassen',
                href: route('buildings.general.show', buildingData.value.id),
            },
            {
                show: !buildingData.value.position,
                name: 'Jetzt Lage & Position erfassen',
                href: route('buildings.position.show', buildingData.value.id),
            },
        ],
    },
    {
        id: '02',
        name: 'Thermische Hülle & Energieträger',
        description: 'Dach, Wand, Keller & Energieträger erfassen',
        href: '#',
        status: buildingData.value.thermal && buildingData.value.heating
            ? 'complete'
            : buildingData.value.general && buildingData.value.position ? 'current' : 'upcoming',
        links: [
            {
                show: !buildingData.value.thermal,
                name: 'Jetzt thermische Hülle erfassen',
                href: route('buildings.thermal.show', buildingData.value.id),
            },
            {
                show: !buildingData.value.heating,
                name: 'Jetzt Energieträger erfassen',
                href: route('buildings.energy.show', buildingData.value.id),
            },
        ],
    },
    {
        id: '03',
        name: 'Bedarfsausweis',
        description: 'Daten prüfen und Bestellung abschließen',
        href: '#',
        status: buildingData.value.products.bdrf?.done
            ? 'complete'
            : buildingData.value.products.bdrf
                ? 'current'
                : 'upcoming',
    },
];

const orderReady = computed(() => {
    return buildingData.value.general && buildingData.value.position && buildingData.value.thermal && buildingData.value.heating;
});
</script>

<template>
    <bz-card>
        <template #title>Bedarfsausweis</template>
        <template #subtitle>Bedarfsorientierter Energieausweis</template>
        <template #button>
            <template v-if="buildingData.products.bdrf?.done">
                <div class="flex space-x-2">
                    <bz-button>Download</bz-button>
                    <bz-button type="secondary">Send per Mail</bz-button>
                </div>
            </template>
            <template v-else-if="buildingData.products.bdrf && !buildingData.products.bdrf?.done"
            ><span class="text-xs text-gray-500 animate-pulse"
            >In Bearbeitung...</span
            >
            </template>
            <bz-button
                v-else-if="!buildingData.has_building_application"
                :disabled="!orderReady"
                @click="() => $emit('create-bdrf')">Bestellen
            </bz-button>
            <template v-else>
                <div class="flex items-end space-x-2">
                    <span class="text-xs text-gray-500">Je nach Aufwand können zusätzliche Kosten für diese Option anfallen.</span>
                    <bz-button
                        @click="() => $emit('create-bdrf')">Mit Baugesuch bestellen
                    </bz-button>
                </div>
            </template>
        </template>
        <template #content>
            <nav aria-label="Progress" class="mx-auto border-b border-gray-100">
                <ol class="overflow-hidden lg:flex" role="list">
                    <li
                        v-for="(step, stepIdx) in steps"
                        :key="step.id"
                        class="relative overflow-hidden lg:flex-1">
                        <div
                            :class="[
                                stepIdx === 0 ? 'rounded-t-md border-b-0' : '',
                                stepIdx === steps.length - 1
                                    ? 'rounded-b-md border-t-0'
                                    : '',
                                'overflow-hidden border border-gray-200 lg:border-0',
                            ]">
                            <a
                                v-if="step.status === 'complete'"
                                :href="step.href"
                                class="group">
                                <span
                                    aria-hidden="true"
                                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-gray-200 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" />
                                <span
                                    :class="[
                                        stepIdx !== 0 ? 'lg:pl-9' : '',
                                        'flex items-start px-6 py-5 text-sm font-medium',
                                    ]">
                                    <span class="flex-shrink-0">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-primary">
                                            <CheckIcon
                                                aria-hidden="true"
                                                class="h-4 w-4 text-white" />
                                        </span>
                                    </span>
                                    <span
                                        class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                        <span class="text-sm font-medium">{{
                                                step.name
                                            }}</span>
                                        <span
                                            class="text-sm font-medium text-gray-500"
                                        >{{ step.description }}</span
                                        >
                                    </span>
                                </span>
                            </a>
                            <a
                                v-else-if="step.status === 'current'"
                                :href="step.href"
                                aria-current="step">
                                <span
                                    aria-hidden="true"
                                    class="absolute left-0 top-0 h-full w-1 bg-primary lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" />
                                <span
                                    :class="[
                                        stepIdx !== 0 ? 'lg:pl-9' : '',
                                        'flex items-start px-6 py-5 text-sm font-medium',
                                    ]">
                                    <span class="flex-shrink-0">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-primary">
                                            <span class="text-primary mt-0.5">{{
                                                    step.id
                                                }}</span>
                                        </span>
                                    </span>
                                    <span
                                        class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                        <span
                                            class="text-sm font-medium text-primary"
                                        >{{ step.name }}</span
                                        >
                                        <span
                                            class="text-sm font-medium text-gray-500"
                                        >{{ step.description }}</span
                                        >
                                    </span>
                                </span>
                            </a>
                            <a v-else :href="step.href" class="group">
                                <span
                                    aria-hidden="true"
                                    class="absolute left-0 top-0 h-full w-1 bg-transparent group-hover:bg-gray-200 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" />
                                <span
                                    :class="[
                                        stepIdx !== 0 ? 'lg:pl-9' : '',
                                        'flex items-start px-6 py-5 text-sm font-medium',
                                    ]">
                                    <span class="flex-shrink-0">
                                        <span
                                            class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300">
                                            <span
                                                class="text-gray-500 mt-0.5"
                                            >{{ step.id }}</span
                                            >
                                        </span>
                                    </span>
                                    <span
                                        class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                        <span
                                            class="text-sm font-medium text-gray-500"
                                        >{{ step.name }}</span
                                        >
                                        <span
                                            class="text-sm font-medium text-gray-500"
                                        >{{ step.description }}</span
                                        >
                                    </span>
                                </span>
                            </a>
                            <template v-if="stepIdx !== 0">
                                <!-- Separator -->
                                <div
                                    aria-hidden="true"
                                    class="absolute inset-0 left-0 top-0 hidden w-3 lg:block">
                                    <svg
                                        class="h-full w-full text-gray-300"
                                        fill="none"
                                        preserveAspectRatio="none"
                                        viewBox="0 0 12 82">
                                        <path
                                            d="M0.5 0V31L10.5 41L0.5 51V82"
                                            stroke="currentcolor"
                                            vector-effect="non-scaling-stroke" />
                                    </svg>
                                </div>
                            </template>
                        </div>
                    </li>
                </ol>
            </nav>

            <template v-if="buildingData.products.bdrf?.done">
                <div class="rounded-b-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3
                            class="text-base font-semibold leading-6 text-gray-900">
                            Bestellung abgeschlossen
                        </h3>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>
                                Ihr Energieausweis ist fertiggestellt und kann
                                unter <strong>Aufträge</strong> heruntergeladen werden.
                            </p>
                        </div>
                    </div>
                </div>
            </template>

            <template v-else-if="buildingData.products.bdrf && !buildingData.products.bdrf?.done">
                <div class="rounded-b-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3
                            class="text-base font-semibold leading-6 text-gray-900">
                            Bestellung in Bearbeitung
                        </h3>
                        <div class="mt-2 text-sm text-gray-500">
                            <p>
                                Ihre Bestellung wird gerade bearbeitet. Sobald
                                der Energieausweis fertiggestellt ist, können
                                Sie ihn hier herunterladen. Sie werden
                                zusätzlich per Mail benachrichtigt.
                            </p>
                        </div>
                    </div>
                </div>
            </template>

            <template v-else>
                <div class="bg-white rounded-b-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3
                            class="text-base font-semibold leading-6 text-gray-900">
                            Hinweis zum Bedarfsausweis
                        </h3>
                        <div class="mt-2 max-w text-sm text-gray-500">
                            <p>

                                Für einen Bedarfsausweis werden Daten wie die Gebäudegröße, die Bauweise, das
                                Dämmmaterial, die Heizungsanlage, die Fenster und Türen, die Belüftung und die
                                Warmwasserversorgung benötigt.
                            </p>
                        </div>
                        <div class="mt-3 text-sm leading-6 flex flex-col">

                            <template v-for="step in steps">
                                <template v-for="link in step.links">
                                    <Link
                                        v-if="link.show"
                                        :href="link.href"
                                        class="font-semibold text-primary hover:text-blue-500">
                                        {{ link.name }}
                                        <span aria-hidden="true"> &rarr;</span>
                                    </Link>
                                </template>
                            </template>

                        </div>
                    </div>
                </div>
            </template>

        </template>
    </bz-card>
</template>
