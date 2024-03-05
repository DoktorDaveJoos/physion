<script setup>
import { Link } from '@inertiajs/vue3';
import { ChevronRightIcon } from '@heroicons/vue/20/solid';

defineProps({
    steps: Array,
});
</script>

<template>
    <div class="flex items-center space-x-2">
        <template v-for="(step, index) in steps">
            <Link
                v-if="index + 1 !== steps.length"
                :href="step.route"
                class="text-gray-500 semibold text-sm"
                >{{ step.name }}</Link
            >
            <span v-else class="text-gray-500 semibold text-sm">{{
                step.name
            }}</span>
            <chevron-right-icon
                v-if="index + 2 <= steps.length"
                class="h-5 w-5 text-gray-400" />
        </template>
    </div>
</template>
