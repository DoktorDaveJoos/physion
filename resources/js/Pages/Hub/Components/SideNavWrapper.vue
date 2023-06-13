<script setup>
import AppLayout from '../../../Layouts/AppLayout.vue';
import { InertiaLink } from '@inertiajs/inertia-vue3';

import {
    CalendarIcon,
    ChartBarIcon,
    FolderIcon,
    HomeIcon,
    InboxIcon,
    UsersIcon,
    PencilSquareIcon,
    AdjustmentsHorizontalIcon,
    LightBulbIcon,
} from '@heroicons/vue/24/outline';

const props = defineProps({
    user: Object,
    title: String,
    subtitle: String,
});

const navigation = [
    { name: 'Dashboard', href: '#', icon: HomeIcon, current: true },
    {
        name: 'Nova',
        href: route('nova.pages.home'),
        icon: AdjustmentsHorizontalIcon,
        current: false,
    },
    {
        name: 'Telescope',
        href: route('telescope'),
        icon: LightBulbIcon,
        current: false,
    },
    // { name: 'Team', href: '#', icon: UsersIcon, current: false },
    // { name: 'Projects', href: '#', icon: FolderIcon, current: false },
    // { name: 'Calendar', href: '#', icon: CalendarIcon, current: false },
    // { name: 'Documents', href: '#', icon: InboxIcon, current: false },
    // { name: 'Reports', href: '#', icon: ChartBarIcon, current: false },
];
</script>
<template>
    <app-layout :title="title" :subtitle="subtitle">
        <div class="grid grid-cols-6 gap-10">
            <nav class="space-y-1 col-span-1" aria-label="Sidebar">
                <InertiaLink
                    v-for="item in navigation"
                    :key="item.name"
                    :href="item.href"
                    :class="[
                        item.current
                            ? 'bg-gray-100 text-gray-900'
                            : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900',
                        'group flex items-center px-3 py-2 text-sm font-medium rounded-md',
                    ]"
                    :aria-current="item.current ? 'page' : undefined">
                    <component
                        :is="item.icon"
                        :class="[
                            item.current
                                ? 'text-gray-500'
                                : 'text-gray-400 group-hover:text-gray-500',
                            'h-4 w-4 mr-2',
                        ]"
                        aria-hidden="true" />
                    <span class="truncate">{{ item.name }}</span>
                </InertiaLink>
            </nav>

            <div class="col-span-5">
                <slot></slot>
            </div>
        </div>
    </app-layout>
</template>
