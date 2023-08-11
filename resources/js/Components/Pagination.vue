<template>
    <nav
        class="flex items-center justify-between px-4 py-3 sm:px-6"
        aria-label="Pagination">
        <div class="hidden sm:block">
            <p class="text-sm text-gray-700">
                Zeige
                {{ ' ' }}
                <span class="font-medium">{{ meta.from ?? 0 }}</span>
                {{ ' ' }} bis
                <span class="font-medium">{{ meta.to ?? 0 }}</span>
                {{ ' ' }}
                von
                {{ ' ' }}
                <span class="font-bold">{{ meta.total }}</span>
                {{ ' ' }}
                Bestellungen
            </p>
        </div>
        <div class="flex flex-1 justify-between sm:justify-end space-x-2">
            <bz-button
                plain
                as="link"
                :disabled="!links.prev"
                type="secondary"
                :href="links.prev"
                ><chevron-left-icon class="h-4 w-4"
            /></bz-button>
            <bz-button
                plain
                as="link"
                :disabled="!links.next"
                type="secondary"
                :href="links.next">
                <chevron-right-icon class="h-4 w-4" />
            </bz-button>
        </div>
    </nav>
</template>

<script setup>
import BzButton from './BzButton.vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/24/solid';

defineProps({
    meta: Object,
    links: Object,
});
</script>
