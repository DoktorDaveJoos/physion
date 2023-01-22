<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import BuildingDetail from '../../Components/BuildingDetail.vue';

defineProps({
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
      <building-detail :context='context' :order='order' />
    </stepper-wrapper>
  </guest-layout>

</template>

