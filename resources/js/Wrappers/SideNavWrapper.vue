<template>
    <div class="lg:flex lg:items-center lg:justify-between">
        <div class="min-w-0 flex-1">
            <nav class="flex" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <a
                                href="#"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700"
                                >Bedarfsausweis</a
                            >
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <ChevronRightIcon
                                class="h-5 w-5 flex-shrink-0 text-gray-400"
                                aria-hidden="true" />
                            <a
                                href="#"
                                class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                                >Allgemein</a
                            >
                        </div>
                    </li>
                </ol>
            </nav>
            <h2
                class="mt-2 text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                {{ product.street_address }}
            </h2>
            <span class="text-gray-500"
                >{{ product.zip }}, {{ product.city }}</span
            >
            <div
                class="mt-4 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <BriefcaseIcon
                        class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                        aria-hidden="true" />
                    Full-time
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <MapPinIcon
                        class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                        aria-hidden="true" />
                    Remote
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <CurrencyDollarIcon
                        class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                        aria-hidden="true" />
                    $120k &ndash; $140k
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <CalendarIcon
                        class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400"
                        aria-hidden="true" />
                    Closing on January 9, 2020
                </div>
            </div>
        </div>
        <div class="mt-5 flex lg:mt-0 lg:ml-4">
            <span class="hidden sm:block">
                <button
                    type="button"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <PencilIcon
                        class="-ml-1 mr-2 h-5 w-5 text-gray-500"
                        aria-hidden="true" />
                    Edit
                </button>
            </span>

            <span class="ml-3 hidden sm:block">
                <button
                    type="button"
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <LinkIcon
                        class="-ml-1 mr-2 h-5 w-5 text-gray-500"
                        aria-hidden="true" />
                    View
                </button>
            </span>

            <span class="sm:ml-3">
                <button
                    type="button"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    <CheckIcon class="-ml-1 mr-2 h-5 w-5" aria-hidden="true" />
                    Publish
                </button>
            </span>

            <!-- Dropdown -->
            <Menu as="div" class="relative ml-3 sm:hidden">
                <MenuButton
                    class="inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    More
                    <ChevronDownIcon
                        class="-mr-1 ml-2 h-5 w-5 text-gray-500"
                        aria-hidden="true" />
                </MenuButton>

                <transition
                    enter-active-class="transition ease-out duration-200"
                    enter-from-class="transform opacity-0 scale-95"
                    enter-to-class="transform opacity-100 scale-100"
                    leave-active-class="transition ease-in duration-75"
                    leave-from-class="transform opacity-100 scale-100"
                    leave-to-class="transform opacity-0 scale-95">
                    <MenuItems
                        class="absolute right-0 z-10 mt-2 -mr-1 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                        <MenuItem v-slot="{ active }">
                            <a
                                href="#"
                                :class="[
                                    active ? 'bg-gray-100' : '',
                                    'block px-4 py-2 text-sm text-gray-700',
                                ]"
                                >Edit</a
                            >
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                            <a
                                href="#"
                                :class="[
                                    active ? 'bg-gray-100' : '',
                                    'block px-4 py-2 text-sm text-gray-700',
                                ]"
                                >View</a
                            >
                        </MenuItem>
                    </MenuItems>
                </transition>
            </Menu>
        </div>
    </div>

    <div class="sm:grid sm:grid-cols-12 sm:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 sm:col-span-2 lg:py-0 lg:px-0">
            <nav class="space-y-1">
                <a
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        item.current
                            ? 'bg-gray-50 text-blue-700 hover:text-blue-700'
                            : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50',
                        'group hover:bg-white rounded-md px-3 py-2 flex items-center text-sm font-medium',
                    ]"
                    :aria-current="item.current ? 'page' : undefined">
                    <component
                        :is="item.icon"
                        :class="[
                            item.current
                                ? 'text-blue-500 group-hover:text-blue-500'
                                : 'text-gray-400 group-hover:text-gray-500',
                            'flex-shrink-0 -ml-1 mr-3 h-6 w-6',
                        ]"
                        aria-hidden="true" />
                    <span class="truncate">{{ item.name }}</span>
                </a>
            </nav>
        </aside>

        <div class="py-2 sm:col-span-10">
            <slot />
        </div>
    </div>
</template>

<script>
import {
    BriefcaseIcon,
    CalendarIcon,
    CheckIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    CurrencyDollarIcon,
    LinkIcon,
    MapPinIcon,
    PencilIcon,
    SunIcon,
    AdjustmentsHorizontalIcon,
    HomeIcon,
    WrenchScrewdriverIcon,
    Square3Stack3DIcon,
} from '@heroicons/vue/24/outline';

import { usePage } from '@inertiajs/vue3';
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';

export default {
    components: {
        BriefcaseIcon,
        CalendarIcon,
        CheckIcon,
        ChevronDownIcon,
        ChevronRightIcon,
        CurrencyDollarIcon,
        LinkIcon,
        MapPinIcon,
        PencilIcon,
        SunIcon,
        AdjustmentsHorizontalIcon,
        HomeIcon,
        WrenchScrewdriverIcon,
        Square3Stack3DIcon,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
    },
    setup() {
        const { order } = usePage().props.;
        const { product } = usePage().props.;

        const navigation = [
            {
                name: 'Allgemein',
                href: route('order.bedarf.general', order.id),
                icon: AdjustmentsHorizontalIcon,
                current: route().current('order.bedarf.general', order.id),
            },
            {
                name: 'Keller',
                href: route('order.bedarf.cellar', order.id),
                icon: WrenchScrewdriverIcon,
                current: route().current('order.bedarf.cellar', order.id),
            },
            {
                name: 'Wand',
                href: route('order.bedarf.wall', order.id),
                icon: Square3Stack3DIcon,
                current: route().current('order.bedarf.wall', order.id),
            },
            {
                name: 'Fenster',
                href: route('order.bedarf.window', order.id),
                icon: SunIcon,
                current: route().current('order.bedarf.window', order.id),
            },
            {
                name: 'Dach',
                href: route('order.bedarf.roof', order.id),
                icon: HomeIcon,
                current: route().current('order.bedarf.roof', order.id),
            },
        ];

        return {
            navigation,
            order,
            product,
        };
    },
};
</script>
