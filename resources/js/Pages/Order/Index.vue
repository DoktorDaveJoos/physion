<!--
  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/aspect-ratio'),
    ],
  }
  ```
-->
<template>
    <div class="bg-gray-50">
        <div class="mx-auto max-w-2xl pt-16 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
            <div class="space-y-2 px-4 sm:flex sm:items-baseline sm:justify-between sm:space-y-0 sm:px-0">
                <div class="flex sm:items-baseline sm:space-x-4">
                    <div class="flex items-center">
                        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Order</h1>
                        <span
                            class="inline-flex ml-4 items-center rounded-md bg-blue-100 px-2.5 py-0.5 font-medium text-blue-800">
                            <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            {{ order.id }}
                        </span>

                        <a href="#"
                           class="hidden ml-4 pb-1 text-sm font-medium text-blue-600 hover:text-blue-500 sm:block self-end">
                            Service beanspruchen
                            <span aria-hidden="true"> &rarr;</span>
                        </a>
                    </div>
                </div>
                <p class="text-sm text-gray-600">Beantragt im
                    <time datetime="2021-03-22" class="font-medium text-gray-900">{{
                            dayjs(order.created_at).
                                locale('de').
                                format('MMM YYYY')
                        }}
                    </time>
                </p>
                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-500 sm:hidden">
                    View invoice
                    <span aria-hidden="true"> &rarr;</span>
                </a>
            </div>

            <!-- Products -->
            <div class="mt-6">

                <div class="space-y-8">
                    <div class="border-t border-b border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border">
                        <div class="py-6 px-4 sm:px-6 lg:grid lg:grid-cols-12 lg:gap-x-8 lg:p-8">
                            <div class="sm:flex lg:col-span-7">
                                <div
                                    class="aspect-w-1 aspect-h-1 w-full flex-shrink-0 overflow-hidden rounded-lg sm:aspect-none sm:h-40 sm:w-40">
                                    <div
                                        class="flex h-40 w-40 flex-shrink-0 items-center justify-center rounded-md text-white sm:h-40 sm:w-40"
                                        :class="map[order.type].theme">
                                        <component :is="map[order.type].icon" class="h-12 w-12" aria-hidden="true" />
                                    </div>
                                </div>

                                <div class="mt-6 sm:mt-0 sm:ml-6">
                                    <h3 class="text-base font-medium text-gray-900">
                                        <a href="#">{{ order.type[0].toUpperCase() + order.type.slice(1) }}</a>
                                    </h3>
                                    <p class="mt-2 text-sm font-medium text-gray-900">€{{ product.price }}</p>
                                    <p class="mt-3 text-sm text-gray-500">{{ product.type }}</p>
                                    <p class="text-sm text-gray-500">{{ product.zip }} {{ product.city }}</p>
                                </div>
                            </div>

                            <div class="mt-6 lg:col-span-5 lg:mt-0">
                                <dl class="grid grid-cols-2 gap-x-6 text-sm">
                                    <div>
                                        <dt class="font-medium text-gray-900">Rechtsgültigkeit</dt>
                                        <dd class="mt-3 text-gray-500">
                                            <span class="block">
                                                <CheckIcon class="inline-block mr-1 w-5 h-5 text-emerald-500"
                                                           aria-hidden="true" />
                                                Bis {{
                                                    dayjs(order.created_at).
                                                        add(10, 'year').
                                                        locale('de').
                                                        format('MMM YYYY')
                                                }}</span>
                                            <div class="flex items-center">
                                                <div class="items-center">
                                                    <CheckIcon class="inline-block mr-1 w-5 h-5 text-emerald-500"
                                                               aria-hidden="true" />
                                                    EnEV
                                                </div>
                                                <el-tooltip
                                                    content="In Deutschland basiert die Rechtsgültigkeit eines Energieausweises auf der Energieeinsparverordnung (EnEV). Die EnEV ist eine Verordnung, die das Bundesministerium für Wirtschaft und Energie erlassen hat und die die Anforderungen an den Wärmeschutz von Gebäuden und die Erstellung von Energieausweisen regelt">
                                                    <QuestionMarkCircleIcon
                                                        class="inline-block ml-1 w-4 h-4 text-gray-400"
                                                        aria-hidden="true" />

                                                </el-tooltip>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="items-center">
                                                    <CheckIcon class="inline-block mr-1 w-5 h-5 text-emerald-500"
                                                               aria-hidden="true" />
                                                    GEG Konform
                                                </div>
                                                <el-tooltip
                                                    content="Im Zusammenhang mit Energieausweisen in Deutschland ist das Gebäudeenergiegesetz (GEG) von Belang. Das GEG ist ein Gesetz, das die Energieeffizienz von Gebäuden und die Erstellung von Energieausweisen regelt und das die EnEV (Energieeinsparverordnung) ergänzt und/oder ersetzt.">
                                                    <QuestionMarkCircleIcon
                                                        class="inline-block ml-1 w-4 h-4 text-gray-400"
                                                        aria-hidden="true" />

                                                </el-tooltip>
                                            </div>
                                            <div class="flex items-center">
                                                <div class="items-center">
                                                    <CheckIcon class="inline-block mr-1 w-5 h-5 text-emerald-500"
                                                               aria-hidden="true" />
                                                    DIBt registriert
                                                </div>
                                                <el-tooltip
                                                    content="Das Deutsche Institut für Bautechnik (DIBt) ist eine deutsche Bundesoberbehörde, die im Zusammenhang mit Energieausweisen in Deutschland eine wichtige Rolle spielt.
                                                DIBt sind für die Anerkennung von prüfenden und zertifizierenden Stellen sowie die Überwachung der Einhaltung der Anforderungen der Energieeinsparverordnung (EnEV) und des Gebäudeenergiegesetzes (GEG) zuständig.">
                                                    <QuestionMarkCircleIcon
                                                        class="inline-block ml-1 w-4 h-4 text-gray-400"
                                                        aria-hidden="true" />

                                                </el-tooltip>
                                            </div>

                                            <!--                                            <span class="block">{{ product.address[2] }}</span>-->
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="font-medium text-gray-900">Gebuchte Services</dt>
                                        <dd class="mt-3 flex flex-col space-y-3 text-gray-500">
                                            <span v-for="upsell in order.upsells">
                                                <ShieldCheckIcon class="inline-block mr-1 w-5 h-5 text-gray-500"
                                                                 aria-hidden="true" />
                                                {{ upsell.name }}</span>
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <template v-if="mapStatus.step !== 3">

                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6 lg:p-8">
                                <h4 class="sr-only">Status</h4>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ mapStatus.name }} seit dem
                                    <time>{{ dayjs(order.updated_at).locale('de').format('DD.MM.YYYY') }}</time>
                                </p>
                                <div class="mt-6" aria-hidden="true">
                                    <div class="overflow-hidden rounded-full bg-gray-200">
                                        <div class="h-2 rounded-full bg-blue-600"
                                             :style="{ width: `calc((${mapStatus.step} * 2 + 1) / 8 * 100%)` }" />
                                    </div>
                                    <div class="mt-6 hidden grid-cols-4 text-sm font-medium text-gray-600 sm:grid">
                                        <div class="text-blue-600">Beantragt</div>
                                        <div :class="[mapStatus.step > 0 ? 'text-blue-600' : '', 'text-center']">
                                            Bearbeitung
                                        </div>
                                        <div :class="[mapStatus.step > 1 ? 'text-blue-600' : '', 'text-center']">Prüfung
                                        </div>
                                        <div :class="[mapStatus.step > 2 ? 'text-blue-600' : '', 'text-right']">
                                            Abgeschlossen
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else>
                            <div class="border-t border-gray-200 py-6 px-4 sm:px-6 lg:p-8 text-right">
                                <a :href="route('order.download', order.id)"
                                   class="inline-flex items-center rounded-md border border-transparent bg-blue-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Energieausweis
                                    herunterladen</a>
                            </div>
                        </template>

                    </div>
                </div>
            </div>
            <div class="">
                <div class="mx-auto max-w-2xl py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
                    <div class="flex items-center justify-between space-x-4">
                        <h2 class="text-lg font-medium text-gray-900">Kunden kauften auch</h2>
                    </div>
                    <div class="mt-6 grid grid-cols-1 gap-x-8 gap-y-8 sm:grid-cols-2 sm:gap-y-10 lg:grid-cols-4">
                        <div v-for="product in products" :key="product.id" class="group relative">
                            <div class="aspect-w-4 aspect-h-3 overflow-hidden rounded-lg bg-gray-100">
                                <div
                                    class="flex h-48 w-58 flex-shrink-0 items-center justify-center text-white opacity-50 group-hover:opacity-100"
                                    :class="product.theme">
                                    <component :is="product.icon" class="h-12 w-12" aria-hidden="true" />
                                </div>
                                <div class="flex items-end p-4 " aria-hidden="true">
                                    <div
                                        class="w-full rounded-md bg-white bg-opacity-75 py-2 px-4 text-center text-sm font-medium text-gray-900 backdrop-blur backdrop-filter">
                                        Produkt anschauen
                                    </div>
                                </div>
                            </div>
                            <div
                                class="mt-4 flex items-center justify-between space-x-8 text-base font-medium text-gray-900">
                                <h3>
                                    <a href="#">
                                        <span aria-hidden="true" class="absolute inset-0" />
                                        {{ product.name }}
                                    </a>
                                </h3>
                                <p>{{ product.price }}</p>
                            </div>
                            <p class="mt-1 text-sm text-gray-500">{{ product.category }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import {CalculatorIcon, FireIcon, ShieldCheckIcon, CheckIcon, CurrencyEuroIcon} from '@heroicons/vue/24/outline';
import {QuestionMarkCircleIcon} from '@heroicons/vue/20/solid';
import dayjs from 'dayjs';
import {computed} from 'vue';
import {Inertia} from '@inertiajs/inertia';

export default {
    methods: {
        dayjs: dayjs,
    },
    components: {
        GuestLayout,
        CalculatorIcon,
        FireIcon,
        ShieldCheckIcon,
        QuestionMarkCircleIcon,
        CheckIcon,
        CurrencyEuroIcon,
    },
    layout: [GuestLayout],
    props: {
        order: {
            type: Object,
            required: true,
        },
        product: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
        const map = {
            'verbrauchsausweis': {
                name: 'Verbrauchsausweis',
                description: 'Energieausweis, der die Energieeffizienz eines Gebäudes über den Energieverbrauch ermittelt.',
                href: '#',
                icon: FireIcon,
                theme: 'bg-sky-500',
                active: true,
                availableFrom: null,
            },
            'bedarfsausweis': {
                name: 'Bedarfsausweis',
                description: 'Energieausweis, der die Energieeffizienz eines Gebäudes rechnerisch ermittelt.',
                href: '#',
                icon: CalculatorIcon,
                theme: 'bg-sky-500',
                active: true,
                availableFrom: null,
            },
        };

        const mapStatus = computed(() => {
            if (props.order.status === 'open') {
                return {
                    step: 1,
                    name: 'In Bearbeitung',
                };
            }

            if (props.order.status === 'in_clarification') {
                return {
                    step: 2,
                    name: 'Prüfung',
                };
            }

            if (props.order.status === 'done') {
                return {
                    step: 3,
                    name: 'Abgeschlossen',
                };
            }

            return {
                step: 0,
                name: 'Unbekannt',
            };
        });

        const products = [
            {
                id: 1,
                name: 'Verbrauchsausweis',
                category: 'Zertifikat',
                href: '#',
                theme: 'bg-sky-500',
                price: '€ 149,00',
                icon: CalculatorIcon,

            },
            {
                id: 2,
                name: 'Förderung von A-Z',
                category: 'Ratgeber',
                href: '#',
                theme: 'bg-purple-500',
                price: '€ 49,00',
                icon: CurrencyEuroIcon,
            },
            // More products...
        ];

        const download = () => {
            Inertia.get(route('order.download', props.order.id));
        };

        return {
            map, mapStatus, products,
        };
    },
};
</script>
