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
        'py-2.5',
    ];

    classes.push(props.class);

    if (props.type === 'primary') {
        if (props.plain) {
            classes.push(
                'bg-transparent',
                'text-sm',
                'hover:bg-transparent',
                'text-blue-600',
                'hover:text-blue-500'
            );

            return classes.join(' ');
        }

        classes.push(
            'rounded-md',
            'text-sm',
            'px-5',
            'bg-blue-600',
            'hover:bg-blue-500',
            'text-white'
        );
        return classes.join(' ');
    }

    if (props.type === 'secondary') {
        if (props.plain) {
            classes.push(
                'bg-transparent',
                'text-gray-600',
                'hover:text-gray-800'
            );

            return classes.join(' ');
        }

        classes.push(
            'text-sm',
            'px-5',
            'rounded-md',
            'bg-gray-100',
            'hover:text-gray-900',
            'text-gray-600',
            'cursor-pointer',
            'disabled:cursor-not-allowed'
        );
        return classes.join(' ');
    }
});
</script>

<template>
    <Link
        v-if="as === 'link'"
        :class="getClass"
        :href="href"
        :disabled="disabled">
        <slot />
    </Link>

    <!--        :link="plain"-->
    <button
        type="button"
        v-else-if="as === 'button'"
        @click="$emit('click')"
        :class="getClass"
        :disabled="disabled"
        size="large">
        <slot />
    </button>

    <a v-else-if="as === 'a'" :class="getClass" :href="href">
        <slot />
    </a>
</template>
