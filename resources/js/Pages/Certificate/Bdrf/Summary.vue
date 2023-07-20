<script setup>
import StepperWrapper from '../../../Wrappers/StepperWrapper.vue';
import GuestLayout from '../../../Layouts/GuestLayout.vue';
import {
    ChevronRightIcon,
    ClipboardIcon,
    DocumentMagnifyingGlassIcon,
    ChartBarIcon,
} from '@heroicons/vue/24/outline';

import { ExclamationTriangleIcon } from '@heroicons/vue/20/solid';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import BzButton from '../../../Components/BzButton.vue';
import { computed } from 'vue';

const props = defineProps({
    order: Object,
    customer: Object,
    product: Object,
});

const feedbackForm = useForm({
    feedback: null,
});

const showSummary = computed(() => {
    return props.order.meta.steps.length === 5;
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
        iconColor: 'bg-sky-500',
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
        iconColor: 'bg-blue-300',
        icon: DocumentMagnifyingGlassIcon,
    },
    {
        name: 'Verbrauchsdaten',
        description: 'Daten zum bisherigen Verbauch des Gebäudes.',
        tag: 'consumption',
        href: route('certificate.show', {
            signature: route().params.signature,
            order: props.order.slug,
            page: 'consumption',
        }),
        iconColor: 'bg-blue-300',
        icon: ChartBarIcon,
    },
];

const items = computed(() => {
    return allItems.filter((item) => {
        return !props.order.meta.steps.includes(item.tag);
    });
});
</script>

<template>
    <guest-layout>
        <stepper-wrapper>
            <div>
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Zusammenfassung
                </h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">
                    Überprüfen Sie die Bestellung und nutzen Sie das
                    Feedback-Feld für Informationen die Sie uns mitteilen
                    möchten
                </p>
            </div>
            <div v-if="showSummary" class="mt-5 border-t border-gray-200">
                <div class="divide-y divide-gray-200">
                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">
                            Allgemein
                        </dt>
                        <dd
                            class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                            <div class="flex-grow">
                                <div class="flex flex-col">
                                    <span
                                        class="font-medium text-xs text-gray-400"
                                        >Auftraggeber</span
                                    >
                                    <span>{{ order.customer.name }}</span>
                                    <span>{{ order.customer.email }}</span>
                                    <span v-if="order.customer.phone">{{
                                        order.customer.phone
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
                                <button
                                    type="button"
                                    class="rounded-md bg-white font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Bearbeiten
                                </button>
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
                                    <span
                                        class="font-medium text-xs text-gray-400"
                                        >Gebäude</span
                                    >
                                    <span
                                        >Baujahr (Heizung):
                                        {{
                                            order.certificate.construction_year
                                        }}
                                        ({{
                                            order.certificate
                                                .construction_year_heating
                                        }})</span
                                    >
                                    <span
                                        >{{
                                            order.certificate.housing_units
                                        }}
                                        Wohneinheit/en</span
                                    >
                                    <span
                                        >{{
                                            order.certificate.floor_area
                                        }}
                                        m²</span
                                    >
                                    <span
                                        >{{ order.certificate.ventilation }},
                                        Keller:
                                        {{
                                            order.certificate.cellar.type
                                        }}</span
                                    >

                                    <span
                                        v-if="order.certificate.cooling"
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
                                <button
                                    type="button"
                                    class="rounded-md bg-white font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Bearbeiten
                                </button>
                            </Link>
                        </dd>
                    </div>

                    <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                        <dt class="text-sm font-medium text-gray-500">
                            Feedback
                        </dt>
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
                                    Datenerfassung vollständig abgeschlossen
                                    haben, bevor Sie fortfahren. Es wurden die
                                    untenstehende Punkte noch nicht ausgefüllt.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <ul role="list" class="divide-y divide-gray-200">
                    <li v-for="(item, itemIdx) in items" :key="itemIdx">
                        <div
                            class="group relative flex items-start space-x-3 py-4">
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
                    <bz-button
                        v-if="showSummary"
                        as="link"
                        type="primary"
                        :href="route('checkout.show', order.id)">
                        Bestellung abschließen
                    </bz-button>
                    <bz-button v-else type="primary" disabled @click="">
                        Bestellung abschließen
                    </bz-button>
                </div>
            </div>
        </stepper-wrapper>
    </guest-layout>
</template>
