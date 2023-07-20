<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import {
    CheckIcon,
    ClockIcon,
    QuestionMarkCircleIcon,
    XMarkIcon,
} from '@heroicons/vue/20/solid';
import PaypalButton from '../../Components/PaypalButton.vue';
import {
    CalculatorIcon,
    FireIcon,
    ShieldCheckIcon,
    LockClosedIcon,
} from '@heroicons/vue/24/outline';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import { EllipsisVerticalIcon } from '@heroicons/vue/24/outline';
import { CheckCircleIcon } from '@heroicons/vue/20/solid';
import { Inertia } from '@inertiajs/inertia';
import { computed } from 'vue';
import BzButton from '../../Components/BzButton.vue';
import axios from 'axios';

const props = defineProps({
    order: Object,
    upsells: {
        type: Array,
        default: () => [],
    },
    addedUpsells: {
        type: Array,
        default: () => [],
    },
});

// const products = [props.product];

const nameMap = {
    'App\\Models\\Bdrf': 'Bedarfsausweis',
    'App\\Models\\Vrbr': 'Verbrauchsausweis',
};

const map = {
    verbrauchsausweis: {
        name: 'Verbrauchsausweis',
        short: 'vrbr',
        description:
            'Energieausweis, der die Energieeffizienz eines Gebäudes über den Energieverbrauch ermittelt.',
        href: '#',
        icon: FireIcon,
        theme: 'bg-sky-500',
        active: true,
        availableFrom: null,
    },
    bedarfsausweis: {
        name: 'Bedarfsausweis',
        short: 'bdrf',
        description:
            'Energieausweis, der die Energieeffizienz eines Gebäudes rechnerisch ermittelt.',
        href: '#',
        icon: CalculatorIcon,
        theme: 'bg-sky-500',
        active: true,
        availableFrom: null,
    },
};

const addUpsell = (upsell) => {
    Inertia.post(
        route('checkout.upsell.add', {
            order: props.order.id,
            upsell: upsell,
        })
    );
};

const removeUpsell = (upsell) => {
    Inertia.delete(
        route('checkout.upsell.delete', {
            order: props.order.id,
            upsell: upsell,
        })
    );
};

const startPayment = () => {
    axios.get(route('checkout.session', { order: props.order.id }));

    // Inertia.get(route('checkout.session', { order: props.order.id }));
};

// Total price
const total = computed(() => {
    return props.order.products
        .reduce((total, upsell) => {
            return total + parseFloat(upsell.price);
        }, 0)
        .toFixed(2);
});
</script>

<template>
    <guest-layout>
        <div class="bg-white">
            <div
                class="mx-auto max-w-2xl px-4 pt-16 pb-24 sm:px-6 lg:max-w-7xl lg:px-8">
                <div class="flex items-center">
                    <h1
                        class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Warenkorb
                    </h1>
                    <span
                        class="inline-flex ml-4 items-center rounded-md bg-blue-100 px-2.5 py-0.5 text-lg font-medium text-blue-800"
                        >{{ order.slug }}</span
                    >
                </div>
                <div
                    class="mt-12 lg:grid lg:grid-cols-12 lg:items-start lg:gap-x-12 xl:gap-x-16">
                    <section
                        aria-labelledby="cart-heading"
                        class="lg:col-span-7">
                        <h2 id="cart-heading" class="sr-only">
                            Items in your shopping cart
                        </h2>

                        <ul
                            role="list"
                            class="divide-y divide-gray-200 border-t border-b border-gray-200">
                            <li
                                v-for="(
                                    product, productIdx
                                ) in order.products.filter(
                                    (product) => product.type === 'certificate'
                                )"
                                :key="product.id"
                                class="flex py-6 sm:py-10">
                                <div
                                    class="ml-4 flex flex-1 flex-col justify-between sm:ml-6">
                                    <div
                                        class="relative pr-9 flex items-center">
                                        <div
                                            class="flex h-14 w-14 bg-slate-100 flex-shrink-0 items-center justify-center rounded-md text-white sm:h-14 sm:w-14">
                                            <fire-icon
                                                class="h-5 w-5 text-slate-900"
                                                aria-hidden="true" />
                                        </div>

                                        <div class="flex flex-col ml-4">
                                            <h3>
                                                <span
                                                    class="font-medium text-gray-700 hover:text-gray-800"
                                                    >{{ product.name }}</span
                                                >
                                            </h3>
                                            <p
                                                class="text-sm font-medium text-gray-900">
                                                {{
                                                    product.price
                                                        .toString()
                                                        .replace('.', ',')
                                                }}
                                                €
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li
                                v-for="addedUpsell in addedUpsells"
                                :key="addedUpsell.id"
                                class="flex py-6 sm:py-10">
                                <div class="w-full grid sm:grid-cols-3">
                                    <div
                                        class="ml-4 flex flex-1 flex-col justify-between sm:ml-6 sm:col-span-2">
                                        <div
                                            class="relative pr-9 flex items-center">
                                            <div
                                                class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-md text-white sm:h-14 sm:w-14 bg-slate-200">
                                                <ShieldCheckIcon
                                                    class="h-5 w-5 text-slate-800"
                                                    aria-hidden="true" />
                                            </div>

                                            <div class="flex flex-col ml-4">
                                                <h3>
                                                    <span
                                                        class="font-medium text-gray-700 hover:text-gray-800"
                                                        >{{
                                                            addedUpsell.name
                                                        }}</span
                                                    >
                                                </h3>

                                                <p
                                                    class="text-sm font-medium text-gray-900">
                                                    {{ addedUpsell.price }} €
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex justify-end">
                                        <el-button
                                            text
                                            type="default"
                                            @click="
                                                removeUpsell(addedUpsell.id)
                                            ">
                                            <XMarkIcon
                                                class="h-5 w-5 text-gray-400 hover:text-gray-400 cursor-pointer"
                                                aria-hidden="true" />
                                        </el-button>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <div class="bg-white">
                            <div class="py-10">
                                <div class="mx-auto max-w-7xl">
                                    <div
                                        class="mx-auto max-w-2xl px-4 lg:max-w-4xl lg:px-0">
                                        <h1
                                            class="text-2xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                                            Empfehlungen
                                        </h1>
                                        <p class="mt-2 text-sm text-gray-500">
                                            Schützen Sie Ihre Investition in den
                                            Energieausweis und versichern Sie
                                            sich gegen eventuelle Fehleingaben.
                                        </p>
                                    </div>
                                </div>

                                <div class="mt-4">
                                    <div class="mx-auto max-w-7xl">
                                        <div
                                            class="mx-auto max-w-2xl space-y-4 sm:px-4 lg:max-w-4xl lg:px-0">
                                            <div
                                                v-for="upsell in upsells"
                                                :key="upsell.id"
                                                class="border-t border-b border-gray-200 bg-white shadow-sm sm:rounded-lg sm:border">
                                                <!-- Products -->
                                                <h4 class="sr-only">Items</h4>
                                                <ul
                                                    role="list"
                                                    class="divide-y divide-gray-200">
                                                    <li class="p-4 sm:p-6">
                                                        <div
                                                            class="flex items-center sm:items-start">
                                                            <div
                                                                class="h-24 w-24 flex-shrink-0 flex items-center justify-center overflow-hidden rounded-lg bg-slate-200">
                                                                <ShieldCheckIcon
                                                                    class="h-8 w-8 text-slate-800"
                                                                    aria-hidden="true" />
                                                            </div>
                                                            <div
                                                                class="ml-6 flex-1 text-sm">
                                                                <div
                                                                    class="font-medium text-gray-900 sm:flex sm:justify-between">
                                                                    <div
                                                                        class="flex items-center">
                                                                        <h5>
                                                                            {{
                                                                                upsell.name
                                                                            }}
                                                                        </h5>
                                                                        <!--                                                                        <span-->
                                                                        <!--                                                                            v-if="-->
                                                                        <!--                                                                                true-->
                                                                        <!--                                                                            "-->
                                                                        <!--                                                                            class="inline-flex ml-2 items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800"-->
                                                                        <!--                                                                            >Empfehlung</span-->
                                                                        <!--                                                                        >-->
                                                                    </div>
                                                                    <p
                                                                        class="mt-2 sm:mt-0">
                                                                        {{
                                                                            upsell.price
                                                                                .toString()
                                                                                .replace(
                                                                                    '.',
                                                                                    ','
                                                                                )
                                                                        }}
                                                                        €
                                                                    </p>
                                                                </div>
                                                                <p
                                                                    class="hidden text-gray-500 sm:mt-2 sm:block">
                                                                    {{
                                                                        upsell.description
                                                                    }}
                                                                </p>
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="mt-2 sm:flex sm:justify-between">
                                                            <div></div>

                                                            <div
                                                                class="mt-2 flex items-center space-x-4 divide-x divide-gray-200 border-t border-gray-200 pt-4 text-sm font-medium sm:mt-0 sm:ml-4 sm:border-none sm:pt-0">
                                                                <div
                                                                    class="flex flex-1 justify-center">
                                                                    <el-button
                                                                        text
                                                                        type="primary"
                                                                        @click="
                                                                            addUpsell(
                                                                                upsell.id
                                                                            )
                                                                        "
                                                                        class="whitespace-nowrap text-indigo-600 hover:text-indigo-500">
                                                                        Hinzufügen
                                                                    </el-button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Order summary -->
                    <section
                        aria-labelledby="summary-heading"
                        class="mt-16 rounded-lg bg-gray-50 px-4 py-6 sm:p-6 lg:col-span-5 lg:mt-0 lg:p-8">
                        <h2
                            id="summary-heading"
                            class="text-lg font-medium text-gray-900">
                            Bestellübersicht
                        </h2>

                        <dl class="mt-6 space-y-4">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm text-gray-600">
                                    {{ order.products[0].name }}
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{
                                        order.products
                                            .find(
                                                (product) =>
                                                    product.type ===
                                                    'certificate'
                                            )
                                            .price.toString()
                                            .replace('.', ',')
                                    }}
                                    €
                                </dd>
                            </div>
                            <div
                                class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt
                                    class="flex items-center text-sm text-gray-600">
                                    <span>DIBt Registriernummer</span>
                                    <el-tooltip
                                        class="box-item"
                                        effect="dark"
                                        content="Die Registriernummer ist eine eindeutige Nummer, die Ihren Energieausweis identifiziert. Sie wird von der DIBt vergeben und ist für die Beantragung von Fördermitteln notwendig."
                                        placement="top-start">
                                        <a
                                            href="#"
                                            class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                            <QuestionMarkCircleIcon
                                                class="h-5 w-5"
                                                aria-hidden="true" />
                                        </a>
                                    </el-tooltip>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    0,00 €
                                </dd>
                            </div>
                            <div
                                class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="flex text-sm text-gray-600">
                                    <span>Empfohlene Versicherung</span>
                                    <el-tooltip
                                        class="box-item"
                                        effect="dark"
                                        content="Mit der Versicherung schützen Sie sich gegen eventuelle Fehleingaben und können diese im Nachhinein korrigieren."
                                        placement="top-start">
                                        <a
                                            href="#"
                                            class="ml-2 flex-shrink-0 text-gray-400 hover:text-gray-500">
                                            <QuestionMarkCircleIcon
                                                class="h-5 w-5"
                                                aria-hidden="true" />
                                        </a>
                                    </el-tooltip>
                                </dt>
                                <dd class="text-sm font-medium text-gray-900">
                                    {{
                                        addedUpsells
                                            .reduce(
                                                (prev, cur) =>
                                                    prev +
                                                    parseFloat(cur.price),
                                                0
                                            )
                                            .toFixed(2)
                                            .toString()
                                            .replace('.', ',')
                                    }}
                                    €
                                </dd>
                            </div>
                            <div
                                class="flex items-center justify-between border-t border-gray-200 pt-4">
                                <dt class="text-base font-medium text-gray-900">
                                    Gesamt
                                </dt>
                                <dd class="text-base font-medium text-gray-900">
                                    {{ total.toString().replace('.', ',') }} €
                                </dd>
                            </div>
                        </dl>

                        <div class="mt-6">
                            <div class="grid">
                                <bz-button
                                    as="a"
                                    :href="
                                        route('checkout.session', {
                                            order: props.order.id,
                                        })
                                    "
                                    class="w-full justify-center"
                                    @click="startPayment">
                                    <lock-closed-icon class="h-4 w-4 mr-1" />
                                    Bezahlen und abschließen
                                </bz-button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </guest-layout>
</template>
