<script setup>
import SidebarLayout from '../../Layouts/SidebarLayout.vue';
import { ChevronRightIcon } from '@heroicons/vue/20/solid';

defineProps({
    products: Array,
});

const stats = [
    { name: 'Offene Bestellungen', stat: '1' },
    { name: 'Abgeschlossene Bestellungen', stat: '432' },
    { name: 'Mitarbeiter', stat: '3' },
];
</script>

<template>
    <SidebarLayout>
        <div>
            <h3 class="text-base font-semibold leading-6 text-gray-900">
                Team Übersicht
            </h3>
            <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div
                    v-for="item in stats"
                    :key="item.name"
                    class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                    <dt class="truncate text-sm font-medium text-gray-500">
                        {{ item.name }}
                    </dt>
                    <dd
                        class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                        {{ item.stat }}
                    </dd>
                </div>
            </dl>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="border-b border-gray-200 px-4 py-5 sm:px-6 mt-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Verfügbare Produkte
                </h3>
            </div>

            <ul
                role="list"
                class="divide-y divide-gray-100 overflow-hidden rounded-b-lg">
                <li
                    v-for="product in products"
                    :key="product.id"
                    class="relative flex justify-between gap-x-6 px-4 py-5 hover:bg-gray-50 sm:px-6">
                    <div class="flex gap-x-4">
                        <div
                            class="h-12 w-12 rounded flex items-center justify-center bg-blue-500">
                            <span class="text-white font-bold">{{
                                product.name.charAt(0)
                            }}</span>
                        </div>
                        <div class="min-w-0 flex-auto">
                            <p
                                class="text-sm font-semibold leading-6 text-gray-900">
                                <a href="#">
                                    <span
                                        class="absolute inset-x-0 -top-px bottom-0" />
                                    {{ product.name }}
                                </a>
                            </p>
                            <p
                                class="mt-1 flex text-xs leading-5 text-gray-500">
                                {{ product.description }}
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-x-4">
                        <div class="hidden sm:flex sm:flex-col sm:items-end">
                            <p class="text-sm leading-6 text-gray-900">
                                {{ product.price.replace('.', ',') }} €
                            </p>
                            <!--                            <p-->
                            <!--                                v-if="person.lastSeen"-->
                            <!--                                class="mt-1 text-xs leading-5 text-gray-500">-->
                            <!--                                Last seen-->
                            <!--                                <time :datetime="person.lastSeenDateTime">{{-->
                            <!--                                    person.lastSeen-->
                            <!--                                }}</time>-->
                            <!--                            </p>-->
                            <!--                            <div-->
                            <!--                                v-else-->
                            <!--                                class="mt-1 flex items-center gap-x-1.5">-->
                            <!--                                <div-->
                            <!--                                    class="flex-none rounded-full bg-emerald-500/20 p-1">-->
                            <!--                                    <div-->
                            <!--                                        class="h-1.5 w-1.5 rounded-full bg-emerald-500" />-->
                            <!--                                </div>-->
                            <!--                                <p class="text-xs leading-5 text-gray-500">-->
                            <!--                                    Online-->
                            <!--                                </p>-->
                            <!--                            </div>-->
                        </div>
                        <ChevronRightIcon
                            class="h-5 w-5 flex-none text-gray-400"
                            aria-hidden="true" />
                    </div>
                </li>
            </ul>
        </div>
    </SidebarLayout>
</template>
