<script setup>
import Footer from './Components/Footer.vue';
import Menu from './Components/Menu.vue';

defineProps({
    showMenu: {
        type: Boolean,
        required: false,
        default: true,
    },
});
</script>

<template>
    <div id="argh" class="min-h-screen flex flex-col font-sansguest">
        <Menu :show-menu="showMenu" />
        <main class="px-4 md:px-0 flex-1 overflow-x-hidden relative">
            <slot />
        </main>
        <Footer />
    </div>
</template>
