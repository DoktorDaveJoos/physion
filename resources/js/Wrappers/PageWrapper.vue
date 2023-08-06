<script setup>
import GuestLayout from '../Layouts/GuestLayout.vue';
import StepperWrapper from './StepperWrapper.vue';
import SidebarLayout from '../Layouts/SidebarLayout.vue';
import StepperWrapperHub from './StepperWrapperHub.vue';

defineProps({
    order: {
        type: Object,
    },
});

import { ChevronRightIcon, HomeIcon } from '@heroicons/vue/20/solid';

const pages = [
    { name: 'Projects', href: '#', current: false },
    { name: 'Project Nero', href: '#', current: true },
];
</script>

<template>
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
