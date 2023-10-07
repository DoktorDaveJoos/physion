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
import { ref } from 'vue';
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
    bauantrag_date: null,
    vollmacht: null,
});

const submit = () => {
    form.transform((data) => ({
        ...data,
        bauantrag_date: dayjs(data.bauantrag_date).format('YYYY-MM-DD'),
    })).post(route('hub.buildings.isfp.store', props.building.data.id));
};

const downloadTemplate = () => {
    window.open('/vollmacht.pdf', '_blank');
};

const steps = [
    {
        id: '01',
        name: 'Rechnungsempfänger',
        description: 'Geben Sie die Kontaktdaten des Rechnungsempfängers ein',
        href: '#',
        status: props.building.data.products.isfp ? 'complete' : 'current',
    },
    {
        id: '02',
        name: 'Vor-Ort-Termin',
        description:
            'Bauzertifikate ist gesetzlich verpflichtet, das Gebäude vor Ort zu prüfen',
        href: '#',
        status: props.building.data.products.isfp ? 'current' : 'upcoming',
    },
    {
        id: '03',
        name: 'Fertigstellung und Zuschuss',
        description: 'Nach Fertigstellung des iSFP erhalten Sie den Zuschuss',
        href: '#',
        status: 'upcoming',
    },
];
</script>

<template>
    <Head>
        <title>Sanierungsfahrplan</title>
    </Head>

    <building-show-wrapper :building="building">
        <bz-card>
            <template #title>Sanierungsfahrplan iSFP</template>
            <template #subtitle
                >Erstellen Sie jetzt einen iSFP für das Gebäude
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

                <template v-if="!building.data.products.isfp">
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
                                            <strong>Rechnungsempfängers</strong>
                                            ein. Der
                                            <strong>Zuschuss</strong> durch die
                                            Bafa wird auf das Konto des
                                            Rechnungsempfängers überwiesen.
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
                        <div
                            class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
                            <el-form-item
                                :error="form.errors.bauantrag_date"
                                label="Datum des Bauantrags o. der Bauanzeige des Gebäudes"
                                required>
                                <el-date-picker
                                    v-model="form.bauantrag_date"
                                    type="date"
                                    placeholder="Datum auswählen"
                                    format="DD.MM.YYYY"
                                    style="width: 100%" />
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
                                Sanierungsfahrplan erstellen</bz-button
                            >
                        </div>
                    </el-form>
                </template>
                <template v-else>
                    <div class="bg-white rounded-b-lg">
                        <div class="px-4 py-5 sm:p-6">
                            <h3
                                class="text-base font-semibold leading-6 text-gray-900">
                                Vor-Ort-Termin
                            </h3>
                            <div class="mt-2 max-w-xl text-sm text-gray-500">
                                <p>
                                    Bauzertifikate stellt nun den Antrag auf
                                    Energieberatung. Dieser Antrag muss in jedem
                                    Fall vor der Erstellung des iSFP gestellt
                                    werden um den Zuschuss zu erhalten.
                                    Anschließend meldet sich Bauzertifikate bei
                                    Ihnen bezüglich eines Vor-Ort-Termins. Im
                                    Anschluss erhalten Sie den iSFP.
                                </p>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </bz-card>
    </building-show-wrapper>
</template>
