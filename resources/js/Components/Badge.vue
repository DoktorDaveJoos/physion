<script setup>
const props = defineProps({
    label: {
        type: String,
        required: true,
    },
    type: {
        type: String,
        default: 'default',
    },
    dot: {
        type: Boolean,
        default: false,
    },
    size: {
        type: String,
        default: 'md',
        options: ['sm', 'md', 'lg'],
    },
});

const types = {
    default: {
        bg: 'bg-primary-100',
        text: 'text-primary-800',
        icon: 'text-primary-400',
    },
    success: {
        bg: 'bg-green-100',
        text: 'text-green-800',
        icon: 'text-green-400',
    },
    error: {
        bg: 'bg-red-100',
        text: 'text-red-800',
        icon: 'text-red-400',
    },
    warning: {
        bg: 'bg-yellow-100',
        text: 'text-yellow-800',
        icon: 'text-yellow-400',
    },
    info: {
        bg: 'bg-gray-100',
        text: 'text-gray-800',
        icon: 'text-gray-400',
    },
};
</script>

<template>
    <div
        :class="[
            types[type].bg,
            types[type].text,
            size === 'lg'
                ? 'px-3 py-1.5'
                : size === 'md'
                ? 'px-2.5 py-0.5'
                : 'px-2',
        ]"
        class="inline-flex justify-between items-center rounded-md font-medium">
        <svg
            v-if="dot"
            :class="types[type].icon"
            class="-ml-0.5 mr-1.5 h-2 w-2 text-primary"
            fill="currentColor"
            viewBox="0 0 8 8">
            <circle cx="4" cy="4" r="3" />
        </svg>
        <div class="flex-1 flex items-center py-1">
            <slot name="prepend"></slot>
            <span
                :class="[
                    size === 'lg'
                        ? 'text-sm'
                        : size === 'md'
                        ? 'text-xs'
                        : 'text-[11px]',
                    'font-bold tracking-wider leading-tight uppercase font-sans mt-0.5',
                ]"
                >{{ label }}</span
            >
        </div>
        <slot name="append"></slot>
    </div>
</template>
