<script>
import AppLayout from '@/Layouts/AppLayout.vue';

import { CalendarIcon, ChartBarIcon, FolderIcon, HomeIcon, InboxIcon, UsersIcon, PencilSquareIcon } from '@heroicons/vue/24/outline'

export default {
    layout: [AppLayout],
    components: {
        CalendarIcon,
        ChartBarIcon,
        FolderIcon,
        HomeIcon,
        InboxIcon,
        UsersIcon,
    },

    props: {
        user: Object,
    },

    setup(props) {

        const navigation = [
            { name: 'Blog', href: route('hub.admin.blog'), icon: PencilSquareIcon, current: true },
            // { name: 'Dashboard', href: '#', icon: HomeIcon, current: true },
            // { name: 'Team', href: '#', icon: UsersIcon, current: false },
            // { name: 'Projects', href: '#', icon: FolderIcon, current: false },
            // { name: 'Calendar', href: '#', icon: CalendarIcon, current: false },
            // { name: 'Documents', href: '#', icon: InboxIcon, current: false },
            // { name: 'Reports', href: '#', icon: ChartBarIcon, current: false },
        ]

        return {
            user: props.user,
            navigation
        }
    }
}
</script>
<template>

    <div class="grid grid-cols-6 gap-10">

        <nav class="space-y-1 col-span-1" aria-label="Sidebar">
            <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-100 text-gray-900' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900', 'group flex items-center px-3 py-2 text-sm font-medium rounded-md']" :aria-current="item.current ? 'page' : undefined">
                <component :is="item.icon" :class="[item.current ? 'text-gray-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
                <span class="truncate">{{ item.name }}</span>
            </a>
        </nav>

        <div class="col-span-5">
            <slot></slot>
        </div>

    </div>
</template>
