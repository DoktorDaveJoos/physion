<script setup>
import SidebarLayout from '../../Layouts/SidebarLayout.vue';
import { ChevronRightIcon, XMarkIcon } from '@heroicons/vue/20/solid';
import { Link, Head } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    products: Array,
    stats: Object,
});

const showWarning = ref(true);
</script>

<template>
    <Head title="Dashboard" />
    <SidebarLayout>
        <template v-if="!$page.props.user?.current_team_id">
            <el-empty
                description="Sie müssen zuerst einem Team beitreten!"></el-empty>

            <div class="flex justify-center">
                <div class="max-w-lg text-sm text-gray-500">
                    Schau in der Navigation links unter
                    <span class="font-bold">"Deine Teams"</span> ob du dort ein
                    Team findest. Wende Dich sonst gerne an das Bauzertifikate
                    Team. Danke! Und schön, dass Du bei Uns bist!
                </div>
            </div>
        </template>
        <template v-else>
            <div
                v-if="!stats.subscription && showWarning"
                class="pointer-events-none inset-x-0 mb-6">
                <div
                    class="pointer-events-auto flex items-center justify-between gap-x-6 bg-red-500 rounded-lg px-6 py-2.5 sm:py-3 sm:pl-4 sm:pr-3.5">
                    <p class="text-sm leading-6 text-white">
                        <strong class="font-semibold">Subscription</strong
                        ><svg
                            viewBox="0 0 2 2"
                            class="mx-2 inline h-0.5 w-0.5 fill-current"
                            aria-hidden="true">
                            <circle cx="1" cy="1" r="1" /></svg
                        >Keine aktive Subscription gefunden. Wende Dich bitte an
                        das Bauzertifikate Team.
                    </p>
                    <button
                        @click="showWarning = false"
                        type="button"
                        class="-m-3 flex-none p-3 focus-visible:outline-offset-[-4px]">
                        <span class="sr-only">Dismiss</span>
                        <XMarkIcon
                            class="h-5 w-5 text-white"
                            aria-hidden="true" />
                    </button>
                </div>
            </div>
            <div>
                <h3
                    class="text-lg font-display font-semibold leading-6 text-gray-900">
                    Team Übersicht
                </h3>
                <dl class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">
                            Offene Bestellungen
                        </dt>
                        <dd
                            class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                            {{ stats.orders.open }}
                        </dd>
                    </div>
                    <div
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">
                            Gesamt Bestellungen
                        </dt>
                        <dd
                            class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                            {{ stats.orders.all }}
                        </dd>
                    </div>
                    <div
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">
                            Mitarbeiter
                        </dt>
                        <dd
                            class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">
                            {{ stats.team.members }}
                        </dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white rounded-lg shadow">
                <div class="border-b border-gray-200 px-4 py-5 sm:px-6 mt-6">
                    <h3 class="text-sm font-bold leading-6 text-gray-900">
                        Verfügbare Produkte
                    </h3>
                </div>

                <ul
                    v-if="products.length > 0"
                    class="divide-y divide-gray-100 overflow-hidden rounded-b-lg"
                    role="list">
                    <Link
                        v-for="product in products"
                        :key="product.id"
                        :href="
                            route('hub.orders.create', {
                                category: product.short_name,
                            })
                        "
                        class="relative flex justify-between gap-x-6 p-4 hover:bg-gray-50">
                        <div class="flex gap-x-4">
                            <div
                                class="h-12 w-12 rounded flex items-center justify-center bg-blue-100">
                                <span
                                    class="text-blue-500 uppercase font-bold"
                                    >{{ product.name.slice(0, 2) }}</span
                                >
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
                                <p class="flex text-xs leading-5 text-gray-500">
                                    {{ product.description }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center gap-x-4">
                            <div
                                class="hidden sm:flex sm:flex-col sm:items-end">
                                <p
                                    class="text-sm leading-6 text-gray-800 font-bold">
                                    € {{ product.price.replace('.', ',') }}
                                </p>
                            </div>
                            <ChevronRightIcon
                                aria-hidden="true"
                                class="h-5 w-5 flex-none text-gray-400" />
                        </div>
                    </Link>
                </ul>
                <el-empty
                    v-else
                    description="Es sind keine Produkte verfügbar."></el-empty>
            </div>

            <div>
                <dl class="mt-6 grid grid-cols-1 gap-5 sm:grid-cols-3">
                    <div
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">
                            Fachlicher Ansprechpartner
                        </dt>
                        <dd
                            class="mt-1 text-base font-semibold tracking-tight text-gray-900">
                            <p>Hannes Jungert</p>
                            <p class="">+49 152 23021307</p>
                        </dd>
                    </div>
                    <div
                        class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">
                            Technischer Ansprechpartner
                        </dt>
                        <dd
                            class="mt-1 text-base font-semibold tracking-tight text-gray-900">
                            <p>David Joos</p>
                            <p class="text-base">+49 152 2541810</p>
                        </dd>
                    </div>
                    <div
                        class="overflow-hidden rounded-lg bg-white px-4 py-4 shadow sm:p-6">
                        <dt class="truncate text-sm font-medium text-gray-500">
                            Subscription
                        </dt>
                        <dd
                            class="mt-1 text-xl font-semibold tracking-tight text-gray-900"
                            :class="
                                stats.subscription
                                    ? 'text-green-500'
                                    : 'text-red-500'
                            ">
                            {{ stats.subscription ? 'Aktiv' : 'Inaktiv' }}
                        </dd>
                    </div>
                </dl>
            </div>
        </template>
    </SidebarLayout>
</template>
