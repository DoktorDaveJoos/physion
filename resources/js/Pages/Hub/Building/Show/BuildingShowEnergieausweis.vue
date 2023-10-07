<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import { CheckIcon } from '@heroicons/vue/24/outline';
import BuildingShowWrapper from './BuildingShowWrapper.vue';
import BzCard from '../../Components/BzCard.vue';
import BzButton from '../../../../Components/BzButton.vue';
import { computed, ref } from 'vue';
import DialogModal from '../../../../Components/DialogModal.vue';
import { ElNotification } from 'element-plus';

const props = defineProps({
    building: Object,
});

const modal = ref(false);

const form = useForm({
    type: null,
    reason: null,
    suggestion_check: {
        attic: false,
        external_wall: false,
        windows: false,
        cellar_ceiling: false,
        led: false,
    },
});

const bdrfExists = computed(() => {
    return props.building.data.products.bdrf?.id;
});

const vrbrExists = computed(() => {
    return props.building.data.products.vrbr?.id;
});

const bdrfThermalExists = computed(() => {
    return (
        props.building.data.wall &&
        props.building.data.roof &&
        props.building.data.cellarModel
    );
});

const vrbrConsumptionExists = computed(() => {
    return parseInt(props.building.data.consumptionMonths) >= 36;
});

const bdrfHeatingExists = computed(() => {
    return (
        props.building.data.heatingSystems?.length > 0 &&
        props.building.data.heatingSystems.filter(
            (heatingSystem) => heatingSystem.water_included
        ).length > 0
    );
});

const order = (type) => {
    form.type = type;
    modal.value = true;
};

const cancel = () => {
    form.reset();
    modal.value = false;
};

const submitOrder = () => {
    form.post(
        route('hub.certificates.store', {
            building: props.building.data.id,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                ElNotification({
                    title: 'Bestellung erfolgreich',
                    message: 'Ihre Bestellung wurde erfolgreich abgeschlossen.',
                    type: 'success',
                });
                modal.value = false;
            },
        }
    );
};

const bdrfSteps = [
    {
        id: '01',
        name: 'Gebäudedaten',
        description: 'Allgemeine Daten vollständig erfassen',
        href: '#',
        status:
            props.building.data.status === 'created' ? 'current' : 'complete',
    },
    {
        id: '02',
        name: 'Gebäudedaten',
        description: 'Thermische Hülle & Energieträger vollständig erfassen',
        href: '#',
        status: bdrfThermalExists.value
            ? 'complete'
            : props.building.data.status === 'created'
            ? 'upcoming'
            : bdrfThermalExists.value && bdrfHeatingExists.value
            ? 'complete'
            : 'current',
    },
    {
        id: '03',
        name: 'Bedarfsausweis',
        description: 'Daten prüfen und Bestellung abschließen',
        href: '#',
        status: bdrfExists.value
            ? 'complete'
            : bdrfThermalExists.value && bdrfHeatingExists.value
            ? 'current'
            : 'upcoming',
    },
];

const vrbrSteps = [
    {
        id: '01',
        name: 'Gebäudedaten',
        description: 'Allgemeine Daten vollständig erfassen',
        href: '#',
        status:
            props.building.data.status === 'created' ? 'current' : 'complete',
    },
    {
        id: '02',
        name: 'Gebäudedaten',
        description: 'Verbrauchsdaten über min. 3 Jahre erfassen',
        href: '#',
        status: vrbrExists.value
            ? 'complete'
            : props.building.data.status === 'created'
            ? 'upcoming'
            : vrbrConsumptionExists.value
            ? 'complete'
            : 'current',
    },
    {
        id: '03',
        name: 'Verbrauchsausweis',
        description: 'Daten prüfen und Bestellung abschließen',
        href: '#',
        status: vrbrExists.value
            ? 'complete'
            : vrbrConsumptionExists.value
            ? 'current'
            : 'upcoming',
    },
];

console.log(parseInt(props.building.data.consumptionMonths));
</script>

<template>
    <Head>
        <title>Energieausweis</title>
    </Head>

    <building-show-wrapper :building="building">
        <bz-card
            :class="
                vrbrExists
                    ? 'opacity-50 hover:opacity-100 transition duration-150'
                    : null
            ">
            <template #title>Bedarfsausweis</template>
            <template #subtitle>Bedarfsorientierter Energieausweis</template>
            <template #button>
                <div class="flex space-x-2">
                    <template
                        v-if="bdrfExists && building.data.products.bdrf?.file">
                        <bz-button
                            v-if="bdrfExists"
                            as="a"
                            :href="
                                route('hub.certificates.download', bdrfExists)
                            "
                            >Download</bz-button
                        >
                        <bz-button v-if="bdrfExists" type="secondary"
                            >Per Mail verschicken
                        </bz-button>
                    </template>
                    <template v-else-if="bdrfExists"
                        ><span class="text-xs text-gray-500 animate-pulse"
                            >In Bearbeitung...</span
                        >
                    </template>
                </div>
                <bz-button
                    v-if="!bdrfExists"
                    :disabled="
                        !bdrfThermalExists ||
                        !bdrfHeatingExists ||
                        building.data.status === 'created'
                    "
                    as="link"
                    >Bestellen</bz-button
                >
            </template>
            <template #content>
                <nav
                    aria-label="Progress"
                    class="mx-auto border-b border-gray-100">
                    <ol class="overflow-hidden lg:flex" role="list">
                        <li
                            v-for="(step, stepIdx) in bdrfSteps"
                            :key="step.id"
                            class="relative overflow-hidden lg:flex-1">
                            <div
                                :class="[
                                    stepIdx === 0
                                        ? 'rounded-t-md border-b-0'
                                        : '',
                                    stepIdx === bdrfSteps.length - 1
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
                                                class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600">
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
                                        class="absolute left-0 top-0 h-full w-1 bg-blue-600 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" />
                                    <span
                                        :class="[
                                            stepIdx !== 0 ? 'lg:pl-9' : '',
                                            'flex items-start px-6 py-5 text-sm font-medium',
                                        ]">
                                        <span class="flex-shrink-0">
                                            <span
                                                class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-blue-600">
                                                <span
                                                    class="text-blue-600 mt-0.5"
                                                    >{{ step.id }}</span
                                                >
                                            </span>
                                        </span>
                                        <span
                                            class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                            <span
                                                class="text-sm font-medium text-blue-600"
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
                <template
                    v-if="bdrfExists && !building.data.products.bdrf?.file">
                    <div class="rounded-b-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-base font-semibold leading-6 text-gray-900">
                                Bestellung in Bearbeitung
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Ihre Bestellung wird gerade bearbeitet.
                                    Sobald der Energieausweis fertiggestellt
                                    ist, können Sie ihn hier herunterladen. Sie
                                    werden zusätzlich per Mail benachrichtigt.
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else-if="building.data.status === 'created'">
                    <div class="bg-white rounded-b-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-base font-semibold leading-6 text-gray-900">
                                Lage & Position erfassen
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Für den Energieausweis muss die Lage,
                                    Position und Grundriss erfasst werden. Für
                                    den Bedarfsausweis ist es zudem erforderlich
                                    auch die Heizungsanlage und die thermische
                                    Hülle zu erfassen.
                                </p>
                            </div>
                            <div class="mt-3 text-sm leading-6 flex flex-col">
                                <Link
                                    :href="
                                        route(
                                            'hub.buildings.show.position',
                                            building.data.id
                                        )
                                    "
                                    class="font-semibold text-blue-600 hover:text-blue-500">
                                    Jetzt Position & Lage erfassen
                                    <span aria-hidden="true"> &rarr;</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else-if="!bdrfExists">
                    <div class="bg-white rounded-b-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-base font-semibold leading-6 text-gray-900">
                                Thermische Hülle & Energieträger erfassen
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Für den bedarfsorientierten Energieausweis
                                    muss die thermische Hülle, der Energieträger
                                    und die Heizungsanlage erfasst werden.
                                    Zusätzlich können Sie erneuerbare Energien
                                    wie Photovoltaik oder Solarthermie erfassen,
                                    falls diese vorhanden sind.
                                </p>
                            </div>
                            <div class="mt-3 text-sm leading-6 flex flex-col">
                                <Link
                                    :href="
                                        route(
                                            'hub.buildings.show.thermal',
                                            building.data.id
                                        )
                                    "
                                    class="font-semibold text-blue-600 hover:text-blue-500">
                                    Jetzt thermische Hülle erfassen
                                    <span aria-hidden="true"> &rarr;</span>
                                </Link>
                                <Link
                                    :href="
                                        route(
                                            'hub.buildings.show.energy',
                                            building.data.id
                                        )
                                    "
                                    class="font-semibold text-blue-600 hover:text-blue-500">
                                    Jetzt Energieträger und Heizungsanlage
                                    erfassen
                                    <span aria-hidden="true"> &rarr;</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </bz-card>

        <bz-card
            :class="
                bdrfExists
                    ? 'opacity-50 hover:opacity-100 transition duration-150'
                    : null
            ">
            <template #title>Verbrauchsausweis</template>
            <template #subtitle>Verbrauchsorientierter Energieausweis</template>
            <template #button>
                <template
                    v-if="vrbrExists && building.data.products.vrbr?.file">
                    <div class="flex space-x-2">
                        <bz-button v-if="vrbrExists">Download</bz-button>
                        <bz-button v-if="vrbrExists" type="secondary"
                            >Send per Mail
                        </bz-button>
                    </div>
                </template>
                <template v-else-if="vrbrExists"
                    ><span class="text-xs text-gray-500 animate-pulse"
                        >In Bearbeitung...</span
                    >
                </template>
                <bz-button
                    v-if="!vrbrExists"
                    :disabled="
                        !vrbrConsumptionExists ||
                        building.data.status === 'created'
                    "
                    @click="order('vrbr')"
                    >Bestellen</bz-button
                >
            </template>
            <template #content>
                <nav
                    aria-label="Progress"
                    class="mx-auto border-b border-gray-100">
                    <ol class="overflow-hidden lg:flex" role="list">
                        <li
                            v-for="(step, stepIdx) in vrbrSteps"
                            :key="step.id"
                            class="relative overflow-hidden lg:flex-1">
                            <div
                                :class="[
                                    stepIdx === 0
                                        ? 'rounded-t-md border-b-0'
                                        : '',
                                    stepIdx === vrbrSteps.length - 1
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
                                                class="flex h-8 w-8 items-center justify-center rounded-full bg-blue-600">
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
                                        class="absolute left-0 top-0 h-full w-1 bg-blue-600 lg:bottom-0 lg:top-auto lg:h-1 lg:w-full" />
                                    <span
                                        :class="[
                                            stepIdx !== 0 ? 'lg:pl-9' : '',
                                            'flex items-start px-6 py-5 text-sm font-medium',
                                        ]">
                                        <span class="flex-shrink-0">
                                            <span
                                                class="flex h-8 w-8 items-center justify-center rounded-full border-2 border-blue-600">
                                                <span
                                                    class="text-blue-600 mt-0.5"
                                                    >{{ step.id }}</span
                                                >
                                            </span>
                                        </span>
                                        <span
                                            class="ml-4 mt-0.5 flex min-w-0 flex-col">
                                            <span
                                                class="text-sm font-medium text-blue-600"
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
                <template
                    v-if="vrbrExists && !building.data.products.vrbr?.file">
                    <div class="rounded-b-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-base font-semibold leading-6 text-gray-900">
                                Bestellung in Bearbeitung
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Ihre Bestellung wird gerade bearbeitet.
                                    Sobald der Energieausweis fertiggestellt
                                    ist, können Sie ihn hier herunterladen. Sie
                                    werden zusätzlich per Mail benachrichtigt.
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else-if="building.data.status === 'created'">
                    <div class="bg-white rounded-b-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-base font-semibold leading-6 text-gray-900">
                                Lage & Position erfassen
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Für den Energieausweis muss die Lage,
                                    Position und Grundriss erfasst werden. Für
                                    den Verbrauchsausweis muss zusätzlich noch
                                    der Verbrauch des Gebäudes erfasst werden.
                                </p>
                            </div>
                            <div class="mt-3 text-sm leading-6 flex flex-col">
                                <Link
                                    :href="
                                        route(
                                            'hub.buildings.show.position',
                                            building.data.id
                                        )
                                    "
                                    class="font-semibold text-blue-600 hover:text-blue-500">
                                    Jetzt Position & Lage erfassen
                                    <span aria-hidden="true"> &rarr;</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else-if="!vrbrExists && !vrbrConsumptionExists">
                    <div class="bg-white rounded-b-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-base font-semibold leading-6 text-gray-900">
                                Verbrauch erfassen
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Für den verbrauchsorientierten
                                    Energieausweis müssen die Verbrauchsdaten
                                    von mindestens 3 Jahren (36 Monate) erfasst
                                    werden. Zusätzlich können Sie Leerstand,
                                    falls vorhanden, erfassen.
                                </p>
                            </div>
                            <div class="mt-3 text-sm leading-6 flex flex-col">
                                <Link
                                    :href="
                                        route(
                                            'hub.buildings.show.consumption',
                                            building.data.id
                                        )
                                    "
                                    class="font-semibold text-blue-600 hover:text-blue-500">
                                    Jetzt Verbrauch erfassen
                                    <span aria-hidden="true"> &rarr;</span>
                                </Link>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </bz-card>
    </building-show-wrapper>

    <dialog-modal :closeable="true" :show="modal" @close="cancel">
        <template #title
            ><span class=""
                >{{
                    form.type === 'vrbr'
                        ? 'Verbrauchsausweis'
                        : 'Bedarfsausweis'
                }}
                - Bestellung abschließen</span
            ></template
        >
        <template #content>
            <el-form
                :model="form"
                class="grid sm:grid-cols-2 sm:gap-x-8"
                label-position="top"
                size="large"
                @submit.prevent="">
                <el-form-item
                    :error="form.errors.reason"
                    :required="true"
                    label="Ausstellungsgrund">
                    <el-select
                        v-model="form.reason"
                        class="w-full"
                        placeholder="Bitte auswählen">
                        <el-option
                            default-first-option
                            label="Modernisierung/Änderung"
                            value="Modernisierung/Änderung" />
                        <el-option
                            default-first-option
                            label="Vermietung/Verkauf"
                            value="Vermietung/Verkauf" />
                        <el-option
                            default-first-option
                            label="Sonstiges"
                            value="Sonstiges" />
                    </el-select>
                </el-form-item>
                <div class="flex flex-col">
                    <el-checkbox
                        v-model="form.suggestion_check.attic"
                        label="Dach-/Dachbodendämmung"></el-checkbox>
                    <el-checkbox
                        v-model="form.suggestion_check.external_wall"
                        label="Außenwanddämmung"></el-checkbox>
                    <el-checkbox
                        v-model="form.suggestion_check.windows"
                        label="Wärmeschutz-/Isolierverglasung"></el-checkbox>
                    <el-checkbox
                        v-model="form.suggestion_check.cellar_ceiling"
                        label="Kellerdeckendämmung"></el-checkbox>
                    <el-checkbox
                        v-model="form.suggestion_check.led"
                        label="Ausschließlich LED Leuchtmittel"></el-checkbox>
                </div>
            </el-form>
        </template>
        <template #footer>
            <div class="flex justify-end space-x-2">
                <bz-button type="secondary" @click="cancel"
                    >Abbrechen</bz-button
                >
                <bz-button @click="submitOrder"
                    >Kostenpflichtig bestellen</bz-button
                >
            </div>
        </template>
    </dialog-modal>
</template>
