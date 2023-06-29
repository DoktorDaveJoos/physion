<script setup>
import { Link } from '@inertiajs/inertia-vue3';
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

const getClass = computed(() => {
    const classes = [
        'font-medium',
        'inline-flex',
        'items-center',
        'justify-center',
    ];

    classes.push(props.class);

    if (props.type === 'primary') {
        if (props.plain) {
            classes.push(
                'bg-transparent',
                'hover:bg-transparent',
                'text-blue-600',
                'hover:text-blue-500'
            );

            return classes.join(' ');
        }

        classes.push(
            'rounded',
            'text-sm',
            'h-[40px]',
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
                'hover:bg-transparent',
                'text-gray-600',
                'hover:text-gray-500'
            );

            return classes.join(' ');
        }

        classes.push(
            'text-sm',
            'h-[40px]',
            'px-5',
            'rounded',
            'border',
            'border-gray-300',
            'hover:text-gray-900',
            'hover:bg-blue-100',
            'hover:border-blue-200',
            'hover:text-blue-600',
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

    <el-button
        v-else-if="as === 'button'"
        :link="plain"
        :type="type"
        :class="getClass"
        :disabled="disabled"
        size="large">
        <slot />
    </el-button>

    <a v-else-if="as === 'a'" :class="getClass" :href="href">
        <slot />
    </a>
</template>
