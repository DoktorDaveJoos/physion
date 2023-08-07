<script setup>
import SidebarLayout from '../../Layouts/SidebarLayout.vue';
import { ChevronRightIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';

defineProps({
    products: Array,
    stats: Object,
});
</script>

<template>
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
            <div>
                <h3 class="text-base font-semibold leading-6 text-gray-900">
                    Team Übersicht
                </h3>
                <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
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
                    <h3 class="text-base font-bold leading-6 text-gray-900">
                        Verfügbare Produkte
                    </h3>
                </div>

                <ul
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
                        class="relative flex justify-between gap-x-6 p-3 hover:bg-gray-50">
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
            </div>
        </template>
    </SidebarLayout>
</template>
