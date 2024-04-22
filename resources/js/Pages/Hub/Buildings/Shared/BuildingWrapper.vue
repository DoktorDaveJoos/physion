<script setup>
import SidebarLayout from '../../../../Layouts/SidebarLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    building: Object,
    subTabsActive: {
        type: Boolean,
        default: false,
    },
    subTabsProductsActive: {
        type: Boolean,
        default: false,
    },
});

const tabs = [
    {
        name: 'Gebäudedaten',
        active: route().current('buildings.show*'),
        route: route('buildings.show', route().params?.building),
    },
    {
        name: 'Dokumente',
        active: route().current('buildings.attachments.show'),
        route: route('buildings.attachments.show', route().params?.building),
    },
    {
        name: 'produkte',
        active: route().current('buildings.products*'),
        route: route('buildings.products.ecert.show', route().params?.building),
    },
    /**{
        name: 'förderrechner',
        active: route().current('buildings.calculator.show'),
        route: route('buildings.calculator.show', route().params?.building),
    },
    {
        name: 'exposé',
        active: route().current('buildings.expose.show'),
        route: route('buildings.expose.show', route().params?.building),
    },*/
];

const subTabs = [
    {
        name: 'Übersicht',
        active: route().current('buildings.show'),
        route: route('buildings.show', route().params?.building),
    },
    {
        name: 'Allgemein',
        active: route().current('buildings.general.show'),
        route: route('buildings.general.show', route().params?.building),
    },
    {
        name: 'Lage & Position',
        active: route().current('buildings.position.show'),
        route: route('buildings.position.show', route().params?.building),
    },
    {
        name: 'Thermische Hülle',
        active: route().current('buildings.thermal.show'),
        route: route('buildings.thermal.show', route().params?.building),
    },
    {
        name: 'Energieträger',
        active: route().current('buildings.energy.show'),
        route: route('buildings.energy.show', route().params?.building),
    },
    {
        name: 'Verbrauch',
        active: route().current('buildings.consumptions.show'),
        route: route('buildings.consumptions.show', route().params?.building),
    },
];

const subTabsProducts = [
    {
        name: 'Energieausweis',
        active: route().current('buildings.products.ecert.show'),
        route: route('buildings.products.ecert.show', route().params?.building),
    },
    {
        name: 'isfp',
        active: route().current('buildings.products.isfp.show'),
        route: route('buildings.products.isfp.show', route().params?.building),
    },
    // {
    //     name: 'bza',
    //     active: route().current('buildings.products.bza.show'),
    //     route: route('buildings.products.bza.show', route().params?.building),
    // },
];
</script>

<template>
    <sidebar-layout>
        <div
            class="rounded-lg shadow bg-white px-6 py-4 flex items-center justify-between">
            <div class="flex space-x-2 items-baseline">
                <h3 class="text-lg font-bold text-gray-700">
                    {{ building.data.address }}
                </h3>
                <p class="text-sm text-gray-500">
                    {{ building.data.postal_code }} {{ building.data.city }}
                </p>
            </div>
            <div>
                <div class="sm:hidden">
                    <label class="sr-only" for="tabs">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select
                        id="tabs"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        name="tabs">
                        <option
                            v-for="tab in tabs"
                            :key="tab.name"
                            :selected="tab.active">
                            {{ tab.name }}
                        </option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav aria-label="Tabs" class="flex space-x-4">
                        <Link
                            v-for="tab in tabs"
                            :key="tab.name"
                            :href="tab.route"
                            :aria-current="tab.active ? 'page' : undefined"
                            :class="[
                                tab.active
                                    ? 'bg-primary-50 text-primary-600'
                                    : 'text-gray-500 hover:text-gray-700',
                                'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',
                            ]">
                            {{ tab.name }}
                        </Link>
                    </nav>
                </div>
            </div>
        </div>

        <div
            v-if="subTabsActive"
            class="rounded-lg mt-4 shadow bg-white px-6 py-3 flex items-center justify-center">
            <div>
                <div class="sm:hidden">
                    <label class="sr-only" for="tabs">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select
                        id="tabs"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        name="tabs">
                        <option
                            v-for="tab in subTabs"
                            :key="tab.name"
                            :selected="tab.active">
                            {{ tab.name }}
                        </option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav aria-label="Tabs" class="flex space-x-4">
                        <Link
                            v-for="tab in subTabs"
                            :key="tab.name"
                            :href="tab.route"
                            :aria-current="tab.active ? 'page' : undefined"
                            :class="[
                                tab.active
                                    ? 'bg-gray-100 text-gray-700'
                                    : 'text-gray-500 hover:text-gray-700',
                                'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',
                            ]">
                            {{ tab.name }}
                        </Link>
                    </nav>
                </div>
            </div>
        </div>

        <div
            v-if="subTabsProductsActive"
            class="rounded-lg mt-4 shadow bg-white px-6 py-3 flex items-center justify-center">
            <div>
                <div class="sm:hidden">
                    <label class="sr-only" for="tabs">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select
                        id="tabs"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        name="tabs">
                        <option
                            v-for="tab in subTabsProducts"
                            :key="tab.name"
                            :selected="tab.active">
                            {{ tab.name }}
                        </option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav aria-label="Tabs" class="flex space-x-4">
                        <Link
                            v-for="tab in subTabsProducts"
                            :key="tab.name"
                            :href="tab.route"
                            :aria-current="tab.active ? 'page' : undefined"
                            :class="[
                                tab.active
                                    ? 'bg-gray-100 text-gray-700'
                                    : 'text-gray-500 hover:text-gray-700',
                                'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',
                            ]">
                            {{ tab.name }}
                        </Link>
                    </nav>
                </div>
            </div>
        </div>

        <slot />
    </sidebar-layout>
</template>
