<script setup>

import FormHeader from './FormHeader.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue';

const form = useForm({
  u_wert: null,
  bauweise: null,
  material: null,
  wandstaerke: null,
  daemmung: null,
});

const state = reactive({
  uWert: true,
  bauweise: {
    'massiv': ['Ziegel', 'Bimsstein', 'Beton'],
    'holzrahmenbau': [
      'Holzständer',
      'Vollholzwand',
      'Fachwerk mit Lehmziegelausfachung',
      'Fachwerk mit Vollziegelausfachung',
      'Sonstige Holzkonstruktion'],
    'vollholz': ['Vollholz'],
  },
});


</script>
<template>
  <form-header subtitle='Angaben zum Wandaufbau' title='Wand' />
  <el-card shadow='never'>

    <template #header>
      <div class='flex justify-between items-center'>
        <span>Wand | {{ state.uWert ? 'U-Wert' : 'Manuelle' }} Eingabe</span>
        <el-button size='large' @click='state.uWert = !state.uWert'>{{ state.uWert ?
          'Manuelle' :
          'U-Wert' }} Eingabe
        </el-button>

      </div>
    </template>

    <el-form :model='form'
             class='grid sm:grid-cols-2 sm:gap-x-8 w-full'
             label-position='top'
             size='large'>

      <template v-if='state.uWert'>
        <el-form-item label='U-Wert' required>
          <el-input-number v-model='form.u_wert' :max='10' :min='0.05' :step='0.01'
                           placeholder='0,18'></el-input-number>
        </el-form-item>
      </template>

      <template v-else>
        <el-form-item label='Bauweise' required>
          <el-select v-model='form.bauweise' class='w-full' placeholder='Bitte wählen'>
            <el-option label='Massiv' value='massiv'></el-option>
            <el-option label='Holzrahmenbau' value='holzrahmenbau'></el-option>
            <el-option label='Vollholz' value='vollholz'></el-option>
          </el-select>
        </el-form-item>

        <div class='hidden sm:block'></div>
        <template v-if='form.bauweise !== null'>
          <el-form-item label='Wandaufbau/Material' required>
            <el-select v-model='form.material' class='w-full' placeholder='Bitte wählen'>
              <el-option v-for='option in state.bauweise[form.bauweise]' :label='option'
                         :value='option'></el-option>
            </el-select>
          </el-form-item>
          <el-form-item label='Wandstärke' required>
            <el-input-number v-model='form.wandstaerke' :max='100' :min='15' :step='1'
                             placeholder='30'></el-input-number>
          </el-form-item>
          <el-form-item label='Dämmstärke'>
            <el-input-number v-model='form.daemmung' :max='100' :min='1' :step='1'
                             placeholder='20'></el-input-number>
          </el-form-item>
        </template>
      </template>
    </el-form>
  </el-card>
</template>


<style scoped>
.el-input-number {
  width: 100%;
}
</style>
