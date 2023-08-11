<script setup>
defineProps({
    type: {
        type: String,
        default: 'button',
    },
});
</script>

<template>
    <button
        :type="type"
        class="uppercase text-xs tracking-wider font-bold inline-flex items-center justify-center px-5 rounded-md bg-gray-100 hover:text-gray-900 text-gray-600 cursor-pointer py-2.5">
        <slot />
    </button>
</template>
