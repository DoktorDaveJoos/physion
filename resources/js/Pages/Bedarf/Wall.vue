<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import WallForm from '../../Components/WallForm.vue';
import RoofForm from '../../Components/RoofForm.vue';
import CellarForm from '../../Components/CellarForm.vue';
import FormHeader from '../../Components/FormHeader.vue';
import { CheckCircleIcon, ExclamationTriangleIcon } from '@heroicons/vue/20/solid';

defineProps({
  order: Object,
});

</script>


<template>
  <GuestLayout>
    <StepperWrapper>
      <div class='pb-12'>
        <FormHeader subtitle='Angaben zur Außenwand, Dach und dem Keller' title='Thermische Hülle' />
        <el-collapse accordion>
          <el-collapse-item>
            <template #title>
              <CheckCircleIcon v-if='order.product.wall?.id' class='h-5 w-5 text-emerald-500 mr-4' />
              <ExclamationTriangleIcon v-else class='h-5 w-5 text-orange-400 mr-4' />
              Außenwand
            </template>
            <wall-form :order='order' />
          </el-collapse-item>
          <el-collapse-item>
            <template #title>
              <CheckCircleIcon v-if='order.product.roof?.id' class='h-5 w-5 text-emerald-500 mr-4' />
              <ExclamationTriangleIcon v-else class='h-5 w-5 text-orange-400 mr-4' />
              Dach
            </template>
            <roof-form :order='order' />
          </el-collapse-item>
          <el-collapse-item>
            <template #title>
              <CheckCircleIcon v-if='order.product.cellar?.id' class='h-5 w-5 text-emerald-500 mr-4' />
              <ExclamationTriangleIcon v-else class='h-5 w-5 text-orange-400 mr-4' />
              Keller
            </template>
            <cellar-form />
          </el-collapse-item>

        </el-collapse>

      </div>
    </StepperWrapper>
  </GuestLayout>
</template>

<style scoped>
.el-input-number {
  width: 100%;
}
</style>
