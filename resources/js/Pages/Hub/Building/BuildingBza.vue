<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BuildingShowWrapper from './Show/BuildingShowWrapper.vue';
import BzCard from '../Components/BzCard.vue';
import BzDropzone from '../../../Components/BzDropzone.vue';
import BzButton from '../../../Components/BzButton.vue';
import {
    ArrowDownTrayIcon,
    XMarkIcon,
    PaperClipIcon,
    TrashIcon,
    CheckIcon,
} from '@heroicons/vue/24/outline';
import { InformationCircleIcon } from '@heroicons/vue/20/solid';
import { computed, ref } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
    building: Object,
});

const showTip = ref(true);

const form = useForm({
    type: null,
    title: null,
    first_name: null,
    last_name: null,
    country: null,
    postal_code: null,
    city: null,
    street: null,
    house_number: null,
    phone: null,
    email: null,
    vollmacht: null,
});

const submit = () => {
    form.post(
        route('hub.products.buildings.bza.store', props.building.data.id)
    );
};

const downloadTemplate = () => {
    window.open('/vollmacht.pdf', '_blank');
};

const bzaExists = computed(() => {
    return props.building.data.products.bza?.id;
});

const thermalExists = computed(() => {
    return (
        props.building.data.wall &&
        props.building.data.roof &&
        props.building.data.cellarModel
    );
});

const heatingExists = computed(() => {
    return (
        props.building.data.heatingSystems?.length > 0 &&
        props.building.data.heatingSystems.filter(
            (heatingSystem) => heatingSystem.water_included
        ).length > 0
    );
});

const steps = [
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
        status: thermalExists.value
            ? 'complete'
            : props.building.data.status === 'created'
            ? 'upcoming'
            : thermalExists.value && heatingExists.value
            ? 'complete'
            : 'current',
    },
    {
        id: '03',
        name: 'Kreditnehmer',
        description: 'Kundendaten inklusive Vollmacht erfassen',
        href: '#',
        status: bzaExists.value
            ? 'complete'
            : thermalExists.value && heatingExists.value
            ? 'current'
            : 'upcoming',
    },
];
</script>

<template>
    <Head>
        <title>BzA</title>
    </Head>

    <building-show-wrapper :building="building" sub-tabs-products-active>
        <bz-card class="mt-4">
            <template #title>Bestätigung zum Antrag</template>
            <template #subtitle>BzA für Wohngebäude erstellen</template>
            <template #button>
                <div class="flex space-x-2">
                    <template
                        v-if="
                            bzaExists && building.data.products.bza?.bza_path
                        ">
                        <bz-button
                            v-if="bzaExists"
                            as="a"
                            :href="
                                route('hub.certificates.download', bzaExists)
                            "
                            >Download</bz-button
                        >
                        <bz-button v-if="bzaExists" type="secondary"
                            >Per Mail verschicken
                        </bz-button>
                    </template>
                    <template v-else-if="bzaExists"
                        ><span class="text-xs text-gray-500 animate-pulse"
                            >In Bearbeitung...</span
                        >
                    </template>
                </div>
            </template>
            <template #content>
                <nav
                    aria-label="Progress"
                    class="mx-auto border-b border-gray-100">
                    <ol class="overflow-hidden lg:flex" role="list">
                        <li
                            v-for="(step, stepIdx) in steps"
                            :key="step.id"
                            class="relative overflow-hidden lg:flex-1">
                            <div
                                :class="[
                                    stepIdx === 0
                                        ? 'rounded-t-md border-b-0'
                                        : '',
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
                    v-if="
                        building.data.status === 'finished' &&
                        !building.data.products.bza?.id
                    ">
                    <div class="px-6 pt-4">
                        <div v-if="showTip" class="rounded-md bg-blue-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <InformationCircleIcon
                                        class="h-5 w-5 text-blue-400"
                                        aria-hidden="true" />
                                </div>
                                <div
                                    class="ml-3 flex-1 md:flex md:justify-between">
                                    <div>
                                        <p class="text-sm text-blue-700">
                                            Bitte tragen Sie die Kontaktdaten
                                            des
                                            <strong>Kreditnehmers</strong>
                                            ein. Der
                                            <strong>Kredit</strong> muss dann an
                                            diese Person ausgezahlt werden.
                                        </p>
                                    </div>
                                    <div class="ml-auto pl-3">
                                        <div class="-mx-1.5 -my-1.5">
                                            <button
                                                type="button"
                                                @click="showTip = false"
                                                class="inline-flex rounded-md bg-blue-50 p-1.5 text-blue-500 hover:bg-blue-100 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:ring-offset-2 focus:ring-offset-blue-50">
                                                <span class="sr-only"
                                                    >Dismiss</span
                                                >
                                                <XMarkIcon
                                                    class="h-5 w-5"
                                                    aria-hidden="true" />
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <el-form
                        :model="form"
                        label-position="top"
                        size="large"
                        @submit.prevent="submit">
                        <div
                            class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
                            <el-form-item
                                :error="form.errors.type"
                                required
                                label="Art des Rechnungsempfängers">
                                <el-select
                                    v-model="form.type"
                                    class="w-full"
                                    placeholder="Bitte auswählen">
                                    <el-option
                                        v-for="type in [
                                            'Privatperson',
                                            'Unternehmen',
                                            'Unternehmen mit kommunaler Beteiligung',
                                            'Zusammenschluss von Privatpersonen',
                                            'Freiberufliche Tätigkeit',
                                            'Kommunale Gebietskörperschaft',
                                            'Körperschaft',
                                            'Wohnungseigentümergemeinschaft',
                                            'Stiftung',
                                            'Kirche',
                                            'Gemeinnützige Organisation',
                                        ]"
                                        default-first-option
                                        :label="type"
                                        :value="type" />
                                </el-select>
                            </el-form-item>

                            <el-form-item
                                :error="form.errors.title"
                                required
                                label="Anrede">
                                <el-select
                                    v-model="form.title"
                                    class="w-full"
                                    placeholder="Bitte auswählen">
                                    <el-option
                                        default-first-option
                                        label="Herr"
                                        value="Herr" />
                                    <el-option
                                        default-first-option
                                        label="Frau"
                                        value="Frau" />
                                    <el-option
                                        default-first-option
                                        label="Divers"
                                        value="Divers" />
                                </el-select>
                            </el-form-item>

                            <el-form-item
                                :error="form.errors.first_name"
                                required
                                label="Vorname">
                                <el-input v-model="form.first_name" />
                            </el-form-item>

                            <el-form-item
                                :error="form.errors.last_name"
                                label="Nachname"
                                required>
                                <el-input v-model="form.last_name" />
                            </el-form-item>
                        </div>
                        <div
                            class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
                            <el-form-item
                                :error="form.errors.street"
                                label="Straße"
                                required>
                                <el-input v-model="form.street" />
                            </el-form-item>

                            <el-form-item
                                :error="form.errors.house_number"
                                label="Hausnummer"
                                required>
                                <el-input v-model="form.house_number" />
                            </el-form-item>

                            <el-form-item
                                :error="form.errors.postal_code"
                                label="Postleitzahl"
                                required>
                                <el-input v-model="form.postal_code" />
                            </el-form-item>

                            <el-form-item
                                :error="form.errors.city"
                                label="Stadt / Gemeinde"
                                required>
                                <el-input v-model="form.city" />
                            </el-form-item>

                            <el-form-item
                                :error="form.errors.country"
                                label="Land"
                                required>
                                <el-input v-model="form.country" />
                            </el-form-item>
                        </div>
                        <div
                            class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
                            <el-form-item
                                :error="form.errors.phone"
                                label="Telefonnummer"
                                required>
                                <el-input v-model="form.phone" />
                            </el-form-item>

                            <el-form-item
                                :error="form.errors.email"
                                label="Email"
                                required>
                                <el-input v-model="form.email" />
                            </el-form-item>
                        </div>
                        <div class="px-6 py-4 border-b border-gray-100">
                            <span class="text-red-500">* </span>
                            <span class="text-sm text-gray-600"
                                >Vollmacht des Rechnungsempfängers</span
                            >
                            <bz-dropzone
                                v-if="!form.vollmacht"
                                class="mt-2"
                                :allowed-mime-types="['application/pdf']"
                                @select="(e) => (form.vollmacht = e)">
                                <template #text>Vollmacht hochladen</template>
                                <template #template>
                                    <bz-button
                                        class="mt-2"
                                        type="secondary"
                                        @click="downloadTemplate">
                                        <arrow-down-tray-icon
                                            class="h-4 w-4 mr-2"
                                            aria-hidden="true" />
                                        Vorlage herunterladen</bz-button
                                    >
                                </template>
                            </bz-dropzone>
                            <div
                                v-else
                                class="rounded-lg px-6 py-4 mt-2 flex justify-between border border-gray-200">
                                <div class="space-x-2 flex items-center">
                                    <PaperClipIcon
                                        class="h-5 w-5 text-gray-400"
                                        aria-hidden="true" />
                                    <span class="text-gray-700 text-sm">
                                        {{ form.vollmacht.name }}
                                    </span>
                                </div>
                                <trash-icon
                                    class="h-5 w-5 text-gray-500 cursor-pointer hover:text-red-500 transition duration-75"
                                    aria-hidden="true"
                                    @click="form.vollmacht = null" />
                            </div>
                        </div>
                        <div class="flex justify-end px-6 py-4">
                            <bz-button
                                type="primary"
                                :disabled="!form.isDirty || form.processing"
                                @click="submit">
                                BzA beantragen</bz-button
                            >
                        </div>
                    </el-form>
                </template>
                <template v-else-if="bzaExists">
                    <div class="bg-white rounded-b-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-base font-semibold leading-6 text-gray-900">
                                BzA beantragt
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Der BzA wurde beantragt und wird in Kürze
                                    erstellt. Bezüglich des Zielzustands des
                                    Gebäudes werden wir uns mit Ihnen in
                                    Verbindung setzen.
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
                <template v-else-if="!bzaExists">
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
    </building-show-wrapper>
</template>
