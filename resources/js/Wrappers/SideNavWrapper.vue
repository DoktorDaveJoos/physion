<template>
    <div class="sm:grid sm:grid-cols-12 sm:gap-x-5">
        <aside class="py-6 px-2 sm:px-6 sm:col-span-2 lg:py-0 lg:px-0">
            <nav class="space-y-1">
                <a v-for="item in navigation" :key="item.name" :href="item.href" :class="[item.current ? 'bg-gray-50 text-blue-700 hover:text-blue-700' : 'text-gray-900 hover:text-gray-900 hover:bg-gray-50', 'group hover:bg-white rounded-md px-3 py-2 flex items-center text-sm font-medium']" :aria-current="item.current ? 'page' : undefined">
                    <component :is="item.icon" :class="[item.current ? 'text-blue-500 group-hover:text-blue-500' : 'text-gray-400 group-hover:text-gray-500', 'flex-shrink-0 -ml-1 mr-3 h-6 w-6']" aria-hidden="true" />
                    <span class="truncate">{{ item.name }}</span>
                </a>
            </nav>
        </aside>
        <div class="py-2  sm:col-span-10">
            <slot />
        </div>
    </div>
</template>

<script setup>
import { SunIcon, AdjustmentsHorizontalIcon, HomeIcon, WrenchScrewdriverIcon, Square3Stack3DIcon } from '@heroicons/vue/24/outline'

const navigation = [
    { name: 'Allgemein', href: route('bedarf.index'), icon: AdjustmentsHorizontalIcon, current: route().current('bedarf.index') },
    { name: 'Keller', href: route('bedarf.cellar'), icon: WrenchScrewdriverIcon, current: route().current('bedarf.cellar') },
    { name: 'Wand', href: route('bedarf.wall'), icon: Square3Stack3DIcon, current: route().current('bedarf.wall') },
    { name: 'Fenster', href: route('bedarf.window'), icon: SunIcon, current: route().current('bedarf.window') },
    { name: 'Dach', href: route('bedarf.roof'), icon: HomeIcon, current: route().current('bedarf.roof') },
]
</script>
