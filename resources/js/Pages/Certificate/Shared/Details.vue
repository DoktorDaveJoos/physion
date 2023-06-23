<script setup>
import GuestLayout from '../../../Layouts/GuestLayout.vue';
import StepperWrapper from '../../../Wrappers/StepperWrapper.vue';
import BuildingDetail from '../../../Components/BuildingDetail.vue';

defineProps({
    order: {
        type: Object,
    },
});
</script>

<template>
    <guest-layout>
        <stepper-wrapper>
            <building-detail :order="order" />
        </stepper-wrapper>
    </guest-layout>
</template>
