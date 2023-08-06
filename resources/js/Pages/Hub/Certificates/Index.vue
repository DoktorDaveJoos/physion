<script setup>
import SidebarLayout from '../../../Layouts/SidebarLayout.vue';

import BzButton from '../../../Components/BzButton.vue';
import { PlusIcon } from '@heroicons/vue/24/outline';
import Badge from '../../../Components/Badge.vue';
import { router } from '@inertiajs/vue3';

defineProps({
    orders: Array,
});

const tabs = [
    { name: 'Alle', filter: null },
    { name: 'Offen', filter: 'open' },
    { name: 'Abgeschlossen', filter: 'shipped' },
];

const handleFilter = (filter) => {
    if (filter) {
        router.get(route('hub.certificates'), { filter: filter });
    } else {
        router.get(route('hub.certificates'));
    }
};

const mapper = {
    'App\\Models\\Bdrf': 'Bedarfsausweis',
    'App\\Models\\Vrbr': 'Verbrauchsausweis',
};
</script>

<template>
    <sidebar-layout>
        <div
            class="rounded-lg shadow bg-white px-6 py-4 flex items-center justify-between">
            <div>
                <div class="sm:hidden">
                    <label for="tabs" class="sr-only">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select
                        id="tabs"
                        name="tabs"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                        <option
                            v-for="tab in tabs"
                            :key="tab.name"
                            :selected="tab.current">
                            {{ tab.name }}
                        </option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <button
                            v-for="tab in tabs"
                            :key="tab.name"
                            type="button"
                            @click="handleFilter(tab.filter)"
                            :class="[
                                (route().params?.filter ?? null) === tab.filter
                                    ? 'bg-blue-100 text-blue-700'
                                    : 'text-gray-500 hover:text-gray-700',
                                'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',
                            ]"
                            :aria-current="tab.current ? 'page' : undefined">
                            {{ tab.name }}
                        </button>
                    </nav>
                </div>
            </div>
            <div class="flex items-center space-x-4">
                <bz-button
                    type="secondary"
                    as="link"
                    :href="route('hub.orders.create', { category: 'vrbr' })">
                    <plus-icon class="w-4 h-4 mr-1 -ml-1" />
                    Verbrauchsausweis
                </bz-button>
                <bz-button
                    type="secondary"
                    as="link"
                    :href="route('hub.orders.create', { category: 'bdrf' })">
                    <plus-icon class="w-4 h-4 mr-1 -ml-1" />
                    Bedarfsausweis
                </bz-button>
            </div>
        </div>

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div
                    class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-white">
                                <tr>
                                    <th
                                        scope="col"
                                        class="py-3.5 pl-4 pr-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wide text-gray-900 sm:pl-6">
                                        Objekt
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-xs font-bold text-gray-800 font-bold uppercase tracking-wide text-gray-900">
                                        Typ
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-xs font-bold text-gray-800 font-bold uppercase tracking-wide text-gray-900">
                                        Erstellt von
                                    </th>
                                    <th
                                        scope="col"
                                        class="px-3 py-3.5 text-left text-xs font-bold text-gray-800 font-bold uppercase tracking-wide text-gray-900">
                                        Status
                                    </th>
                                    <th
                                        scope="col"
                                        class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                        <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <tr
                                    v-for="order in orders.data"
                                    :key="order.id">
                                    <td
                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                        <p class="font-bold text-gray-500">
                                            {{
                                                order.certificate.street_address
                                            }}
                                        </p>
                                        <p class="font-bold text-gray-500">
                                            {{ order.certificate.zip }}
                                            {{ order.certificate.city }}
                                        </p>
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ mapper[order.certificate_type] }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        {{ order.owner.name }}
                                    </td>
                                    <td
                                        class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                        <Badge
                                            :label="order.status"
                                            size="sm" />
                                    </td>
                                    <td
                                        class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </sidebar-layout>
</template>

<style scoped></style>
