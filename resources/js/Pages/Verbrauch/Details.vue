<script setup>
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import BuildingDetail from '../../Components/BuildingDetail.vue';

const props = defineProps({
    context: {
        type: String,
        required: true,
    },
    order: {
        type: Object,
    },
});
</script>

<template>
    <guest-layout>
        <stepper-wrapper>
            <building-detail :context="context" :order="order" renewables />
        </stepper-wrapper>
    </guest-layout>
</template>
