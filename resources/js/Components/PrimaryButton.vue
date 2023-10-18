<script setup>
defineProps({
    type: {
        type: String,
        default: 'submit',
    },
});
</script>

<template>
    <button
        :type="type"
        class="uppercase text-xs tracking-wider font-bold inline-flex items-center justify-center rounded-md px-5 bg-primary hover:bg-blue-500 text-white py-2.5">
        <slot />
    </button>
</template>
