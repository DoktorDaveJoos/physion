<script setup>
import FormHeader from './FormHeader.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue';

const form = useForm({
  beheizt: null,
  u_wert: null,
  keller: null,
  bauweise: null,
  material: null,
  gefuellt: false,
  fuellung: null,
  wandstaerke: null,
  daemmung: null,
});

const state = reactive({
  uWert: true,
  bauweise: ['Massiv', 'Holzbalkendecke', 'Vollholz'],
});

</script>

<template>
  <form-header subtitle='Angaben zum Keller' title='Keller' />
  <el-card shadow='never'>

    <template #header>
      <div class='flex justify-between items-center'>
        <span>Keller | {{ state.uWert ? 'U-Wert' : 'Manuelle' }} Eingabe</span>
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

      <el-form-item label='Keller' required>
        <el-select v-model='form.dachstock' class='w-full' placeholder='Bitte wählen'>
          <el-option label='Beheizt' value='beheizt'></el-option>
          <el-option label='Kalt' value='kalt'></el-option>
        </el-select>
      </el-form-item>

      <div class='hidden sm:block'></div>

      <template v-if='form.keller === "kalt"'>
        <template v-if='state.uWert'>
          <el-form-item label='U-Wert' required>
            <el-input-number v-model='form.u_wert' :max='10' :min='0.05' :step='0.01'
                             placeholder='0,18'></el-input-number>
          </el-form-item>
        </template>
        <template v-else>
          <el-form-item class='' label='Bauweise' required>
            <el-select v-model='form.bauweise' class='w-full' placeholder='Bitte wählen'>
              <el-option label='Massiv' value='massiv'></el-option>
              <el-option label='Holzbalkendecke' value='gefach'></el-option>
              <el-option label='Vollholz' value='vollholz'></el-option>
            </el-select>
          </el-form-item>

          <div class='hidden sm:block'></div>

          <template v-if='form.bauweise === "massiv" || form.bauweise === "vollholz"'>
            <el-form-item label='Stärke Decke'>
              <el-input-number v-model='form.wandstaerke' :max='100' :min='10' :step='1'
                               placeholder='20'></el-input-number>
            </el-form-item>
            <el-form-item label='Stärke Dämmung'>
              <el-input-number v-model='form.daemmung' :max='100' :min='1' :step='1'
                               placeholder='10'></el-input-number>
            </el-form-item>
            <el-alert class='sm:col-span-2' show-icon title='Hinweis' type='info'>
              <span>Falls die jeweiligen Stärken weder bekannt, noch messbar sind - dann lassen Sie die Felder leer. Es
                wird dann mit Pauschalwerten gerechnet.</span>
            </el-alert>
          </template>

          <template v-else-if='form.bauweise === "gefach"'>
            <el-form-item label='Gefach'>
              <el-checkbox v-model='form.gefuellt' border class='w-full'>Befüllt</el-checkbox>
            </el-form-item>
            <template v-if='form.gefuellt'>
              <el-form-item label='Füllhöhe - Schätzwert in %'>
                <el-input-number v-model='form.fuellung' :max='100' :min='0' :step='1'
                                 placeholder='0'></el-input-number>
              </el-form-item>
            </template>
          </template>
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
