<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import WallForm from '../../Components/WallForm.vue';
import RoofForm from '../../Components/RoofForm.vue';
import CellarForm from '../../Components/CellarForm.vue';</script>

<template>
  <GuestLayout>
    <StepperWrapper>
      <div class='pb-12'>
        <wall-form />
        <el-divider />
        <roof-form />
        <el-divider />
        <cellar-form />
      </div>
    </StepperWrapper>
  </GuestLayout>
</template>

<style scoped>
.el-input-number {
  width: 100%;
}
</style>
