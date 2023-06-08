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
});

const getClass = computed(() => {
    const classes = [
        'rounded',
        'text-white',
        'inline-flex',
        'items-center',
        'font-medium',
    ];

    if (props.plain) {
        classes.push(
            'bg-transparent',
            'hover:bg-transparent',
            'text-blue-600',
            'hover:text-blue-500'
        );
    }

    if (!props.plain) {
        classes.push(
            'py-2',
            'px-5',
            'bg-blue-600',
            'hover:bg-blue-500',
            'text-white'
        );
    }

    classes.push(props.class);

    return classes.join(' ');
});
</script>

<template>
    <Link v-if="as === 'link'" :class="getClass" :href="href">
        <slot />
    </Link>

    <el-button
        v-else-if="as === 'button'"
        :link="plain"
        :type="type"
        size="large">
        <slot />
    </el-button>

    <a v-if="as === 'a'" :class="getClass" :href="href">
        <slot />
    </a>
</template>
