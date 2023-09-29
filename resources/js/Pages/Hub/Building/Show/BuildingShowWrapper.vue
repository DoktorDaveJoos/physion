<script setup>
import SidebarLayout from '../../../../Layouts/SidebarLayout.vue';
import { Link } from '@inertiajs/vue3';

defineProps({
    building: Object,
});

const tabs = [
    {
        name: 'Gebäudedaten',
        active: route().current('hub.buildings.show.index'),
        route: route('hub.buildings.show.index', route().params?.building),
    },
    {
        name: 'Dokumente',
        active: route().current('hub.buildings.show.docs'),
        route: route('hub.buildings.show.docs', route().params?.building),
    },
    {
        name: 'Energieausweis',
        active: route().current('hub.buildings.show.energieausweis'),
        route: route(
            'hub.buildings.show.energieausweis',
            route().params?.building
        ),
    },
    {
        name: 'isfp',
        active: route().current('hub.buildings.show.isfp'),
        route: route('hub.buildings.show.isfp', route().params?.building),
    },
    {
        name: 'bza',
        active: route().current('hub.buildings.show.bza'),
        route: route('hub.buildings.show.bza', route().params?.building),
    },
];
</script>

<template>
    <sidebar-layout>
        <div
            class="rounded-lg shadow bg-white px-6 py-4 flex items-center justify-between mb-6">
            <div class="flex space-x-2">
                <h3
                    class="text-lg font-display font-semibold leading-6 text-gray-900">
                    {{ building.data.address }}
                </h3>
                <p class="mt-1 text-sm text-gray-500">
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
                                    ? 'bg-blue-100 text-blue-700'
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
