<script setup>
import {
    ChevronRightIcon,
    ClipboardIcon,
    DocumentMagnifyingGlassIcon,
    GlobeAltIcon,
    HomeModernIcon,
    BoltIcon,
} from '@heroicons/vue/24/outline';

import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import dayjs from 'dayjs';
import BzButton from '../../../Components/BzButton.vue';
import { computed } from 'vue';
import PageWrapper from '../../../Wrappers/PageWrapper.vue';

const props = defineProps({
    order: Object,
    owner: Object,
    product: Object,
});

const feedbackForm = useForm({
    feedback: null,
});

const showSummary = computed(() => {
    return props.order.meta.steps.length >= 5;
});

const allItems = [
    {
        name: 'Allgemeine Daten',
        description: 'Auftragserfassung und allgemeine Daten.',
        tag: 'general',
        href: route('certificate.show', {
            signature: route().params.signature,
            order: props.order.slug,
            page: 'general',
        }),
        iconColor: 'bg-cyan-500',
        icon: ClipboardIcon,
    },
    {
        name: 'Gebäudedetails',
        description: 'Spezifische Daten zum Gebäude.',
        tag: 'details',
        href: route('certificate.show', {
            signature: route().params.signature,
            order: props.order.slug,
            page: 'details',
        }),
        iconColor: 'bg-sky-300',
        icon: DocumentMagnifyingGlassIcon,
    },
    {
        name: 'Lage & Grundriss',
        description: 'Angaben zur Bemaßung und Lage des Gebäudes.',
        tag: 'position',
        href: route('certificate.show', {
            signature: route().params.signature,
            order: props.order.slug,
            page: 'position',
        }),
        iconColor: 'bg-blue-300',
        icon: GlobeAltIcon,
    },
    {
        name: 'Thermische Hülle',
        description: 'Angaben zur thermischen Hülle des Gebäudes.',
        tag: 'thermal',
        href: route('certificate.show', {
            signature: route().params.signature,
            order: props.order.slug,
            page: 'thermal',
        }),
        iconColor: 'bg-indigo-300',
        icon: HomeModernIcon,
    },
    {
        name: 'Energie',
        description: 'Angaben zur Heizanlage und erneuerbaren Energien.',
        tag: 'energy',
        href: route('certificate.show', {
            signature: route().params.signature,
            order: props.order.slug,
            page: 'energy',
        }),
        iconColor: 'bg-violet-300',
        icon: BoltIcon,
    },
];

const items = computed(() => {
    return allItems.filter((item) => {
        return !props.order.meta.steps.includes(item.tag);
    });
});

const submit = () => {
    const url = usePage().props.user
        ? route('hub.certificates.update', {
              order: props.order.slug,
              page: 'summary',
          })
        : route('certificate.update', {
              order: props.order.slug,
              page: 'summary',
              signature: route().params.signature,
          });

    feedbackForm.put(url);
};
</script>

<template>
    <page-wrapper>
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Zusammenfassung
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Überprüfen Sie die Bestellung und nutzen Sie das Feedback-Feld
                für Informationen die Sie uns mitteilen möchten
            </p>
        </div>
        <div v-if="showSummary" class="mt-5 border-t border-gray-200">
            <div class="divide-y divide-gray-200">
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Allgemein</dt>
                    <dd
                        class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div class="flex-grow">
                            <div class="flex flex-col">
                                <span class="font-medium text-xs text-gray-400"
                                    >Auftraggeber</span
                                >
                                <span>{{ order.owner.name }}</span>
                                <span>{{ order.owner.email }}</span>
                                <span v-if="order.owner.phone">{{
                                    order.owner.phone
                                }}</span>

                                <span
                                    class="font-medium text-xs text-gray-400 mt-4"
                                    >Gebäude</span
                                >
                                <span>{{
                                    order.certificate.street_address
                                }}</span>
                                <span
                                    >{{ order.certificate.zip }},
                                    {{ order.certificate.city }}</span
                                >
                                <span
                                    >{{ order.certificate.type }},
                                    {{
                                        order.certificate.additional_type
                                    }}</span
                                >
                            </div>
                        </div>
                        <Link
                            :href="
                                route('certificate.show', {
                                    order: props.order.slug,
                                    page: 'general',
                                    signature: route().params.signature,
                                })
                            "
                            class="ml-4 flex-shrink-0">
                            <bz-button plain> Bearbeiten </bz-button>
                        </Link>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Gebäudedetails
                    </dt>
                    <dd
                        class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div class="flex-grow">
                            <div class="flex flex-col">
                                <span class="font-medium text-xs text-gray-400"
                                    >Gebäude</span
                                >
                                <span
                                    >Baujahr:
                                    {{ order.certificate.construction_year }}
                                </span>
                                <span
                                    >{{
                                        order.certificate.housing_units
                                    }}
                                    Wohneinheit/en</span
                                >
                                <span
                                    >{{ order.certificate.floor_area }} m²</span
                                >
                                <span
                                    >{{ order.certificate.ventilation }},
                                    Keller:
                                    {{ order.certificate.cellar.type }}</span
                                >

                                <template
                                    v-if="order.certificate.cooling_count > 0">
                                    <span
                                        class="font-medium text-xs text-gray-400 mt-4"
                                        >Kühlung</span
                                    >
                                    <span>{{ order.certificate.cooling }}</span>
                                    <span v-if="order.certificate.cooling_count"
                                        >Servicepflichte Klima:
                                        {{ order.certificate.cooling_count }},
                                        Nächster Service:
                                        {{
                                            dayjs(
                                                order.certificate
                                                    .cooling_service
                                            ).format('DD.MM.YYYY')
                                        }}</span
                                    >
                                </template>
                            </div>
                        </div>
                        <Link
                            :href="
                                route('certificate.show', {
                                    order: props.order.slug,
                                    page: 'details',
                                    signature: route().params.signature,
                                })
                            "
                            class="ml-4 flex-shrink-0">
                            <bz-button plain> Bearbeiten </bz-button>
                        </Link>
                    </dd>
                </div>

                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Feedback</dt>
                    <dd
                        class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <el-input
                            v-model="feedbackForm.feedback"
                            :rows="4"
                            type="textarea"
                            placeholder="Möchten Sie uns noch etwas mitteilen?" />
                    </dd>
                </div>
            </div>
        </div>

        <div v-else class="w-full my-6">
            <div
                class="rounded-md bg-yellow-50 border border-yellow-200 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <ExclamationTriangleIcon
                            class="h-5 w-5 mt-0.5 text-yellow-400"
                            aria-hidden="true" />
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-yellow-800">
                            Datenerfassung nicht abgeschlossen
                        </h3>
                        <div class="mt-2 text-sm text-yellow-700">
                            <p>
                                Bitte stellen Sie sicher, dass Sie die
                                Datenerfassung vollständig abgeschlossen haben,
                                bevor Sie fortfahren. Es wurden die
                                untenstehende Punkte noch nicht ausgefüllt.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <ul role="list" class="divide-y divide-gray-200">
                <li v-for="(item, itemIdx) in items" :key="itemIdx">
                    <div class="group relative flex items-start space-x-3 py-4">
                        <div class="flex-shrink-0">
                            <span
                                :class="[
                                    item.iconColor,
                                    'inline-flex h-10 w-10 items-center justify-center rounded-lg',
                                ]">
                                <component
                                    :is="item.icon"
                                    class="h-6 w-6 text-white"
                                    aria-hidden="true" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="text-sm font-medium text-gray-900">
                                <a :href="item.href">
                                    <span
                                        class="absolute inset-0"
                                        aria-hidden="true" />
                                    {{ item.name }}
                                </a>
                            </div>
                            <p class="text-sm text-gray-500">
                                {{ item.description }}
                            </p>
                        </div>
                        <div class="flex-shrink-0 self-center">
                            <ChevronRightIcon
                                class="h-5 w-5 text-gray-400 group-hover:text-gray-500"
                                aria-hidden="true" />
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <el-divider />

        <div class="grid sm:flex sm:justify-between sm:col-span-2 gap-4">
            <div class="grid sm:block">
                <bz-button
                    as="link"
                    type="secondary"
                    :href="
                        route('certificate.show', {
                            signature: route().params.signature,
                            order: order.slug,
                            page: 'consumption',
                        })
                    ">
                    Zurück
                </bz-button>
            </div>
            <div class="grid sm:block">
                <bz-button :disabled="!showSummary" @click="submit">
                    Bestellung abschließen
                </bz-button>
            </div>
        </div>
    </page-wrapper>
</template>
