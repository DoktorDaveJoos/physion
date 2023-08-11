<script setup>
import GuestLayout from '../Layouts/GuestLayout.vue';
import StepperWrapper from './StepperWrapper.vue';
import SidebarLayout from '../Layouts/SidebarLayout.vue';
import StepperWrapperHub from './StepperWrapperHub.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    order: {
        type: Object,
    },
});

const pages = [
    { name: 'Projects', href: '#', current: false },
    { name: 'Project Nero', href: '#', current: true },
];
</script>

<template>
    <Head title="Erstellen" />
    <template v-if="$page.props.user">
        <sidebar-layout>
            <stepper-wrapper-hub>
                <slot />
            </stepper-wrapper-hub>
        </sidebar-layout>
    </template>
    <template v-else>
        <guest-layout>
            <stepper-wrapper>
                <slot />
            </stepper-wrapper>
        </guest-layout>
    </template>
</template>
