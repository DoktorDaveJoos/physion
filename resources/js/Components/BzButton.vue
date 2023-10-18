<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps({
    as: {
        type: String,
        default: 'button',
    },
    href: String,
    type: {
        type: String,
        default: 'primary',
    },
    loading: {
        type: Boolean,
        default: false,
    },
    plain: Boolean,
    class: String,
    disabled: Boolean,
});

defineEmits(['click']);

const getClass = computed(() => {
    const classes = [
        'uppercase',
        'text-xs',
        'tracking-wider',
        'font-bold',
        'inline-flex',
        'items-center',
        'justify-center',
        'font-sans',
    ];

    classes.push(props.class);

    if (props.type === 'primary') {
        if (props.plain) {
            if (props.disabled) {
                classes.push(
                    'bg-transparent',
                    'hover:bg-transparent',
                    'text-blue-400',
                    'hover:text-blue-400'
                );
            } else {
                classes.push(
                    'bg-transparent',
                    'hover:bg-transparent',
                    'text-primary',
                    'hover:text-blue-500'
                );
            }

            return classes.join(' ');
        }

        if (props.disabled) {
            classes.push(
                'opacity-50',
                'bg-blue-200',
                'text-primary',
                'px-5',
                'rounded-md',
                'cursor-not-allowed',
                'hover:bg-blue-200',
                'py-2.5'
            );

            return classes.join(' ');
        }

        classes.push(
            'rounded-md',
            'px-5',
            'bg-primary',
            'hover:bg-blue-500',
            'text-white',
            'py-2.5'
        );
        return classes.join(' ');
    }

    if (props.type === 'secondary') {
        if (props.plain) {
            if (props.disabled) {
                classes.push(
                    'bg-transparent',
                    'hover:bg-transparent',
                    'text-gray-400',
                    'hover:text-gray-400',
                    'cursor-not-allowed'
                );
            } else {
                classes.push(
                    'bg-transparent',
                    'hover:bg-transparent',
                    'text-gray-600',
                    'hover:text-gray-800'
                );
            }

            return classes.join(' ');
        }

        if (props.disabled) {
            classes.push(
                'rounded-md',
                'px-5',
                'bg-gray-100',
                'text-gray-400',
                'cursor-not-allowed',
                'py-2.5'
            );

            return classes.join(' ');
        }
        classes.push(
            'px-5',
            'rounded-md',
            'bg-gray-100',
            'hover:text-gray-900',
            'text-gray-600',
            'cursor-pointer',
            'py-2.5'
        );
        return classes.join(' ');
    }
});
</script>

<template>
    <template v-if="disabled">
        <div :class="getClass" class="">
            <slot />
        </div>
    </template>
    <template v-else>
        <template v-if="!loading">
            <Link
                v-loading="loading"
                v-if="as === 'link'"
                :class="getClass"
                :href="href">
                <slot />
            </Link>

            <button
                v-loading="loading"
                type="button"
                v-else-if="as === 'button'"
                @click="$emit('click')"
                :class="getClass">
                <slot />
            </button>
            <a v-else-if="as === 'a'" :class="getClass" :href="href">
                <slot />
            </a>
        </template>
        <div v-else class="opacity-50" :class="getClass">
            <span class="animate-spin mr-3">
                <svg
                    class="h-3 w-3"
                    :class="[
                        type === 'primary' ? 'text-white' : 'text-gray-600',
                    ]"
                    fill="none"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"></circle>
                    <path
                        class="opacity-75"
                        d="M4 12a8 8 0 018-8v8H4z"
                        fill="currentColor"></path>
                </svg>
            </span>
            <slot />
        </div>
    </template>
</template>
