<script setup>
import GuestLayout from '../../../Layouts/GuestLayout.vue';
import StepperWrapper from '../../../Wrappers/StepperWrapper.vue';
import BuildingDetail from '../../../Components/BuildingDetail.vue';
import SidebarLayout from '../../../Layouts/SidebarLayout.vue';
import StepperWrapperHub from '../../../Wrappers/StepperWrapperHub.vue';
import PageWrapper from '../../../Wrappers/PageWrapper.vue';

defineProps({
    order: {
        type: Object,
    },
});
</script>

<template>
    <page-wrapper>
        <building-detail :order="order" />
    </page-wrapper>
</template>
