<script setup>

import { onMounted, reactive, ref } from 'vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { PlusIcon } from '@heroicons/vue/24/outline';

const props = defineProps({
  roof: Object,
});

const { product } = usePage().props.value;
console.log(product);

const showButton = ref(false);

onMounted(() => {
  showButton.value = true;
});

const form = useForm({
  'kniestock': null,
  'dachneigung': null,
  'aufdachdaemmung': null,
  'gefachdaemmung': null,
  ...props.roof,
});

const dachfensterForm = useForm({
  'count': null,
  'height': null,
  'width': null,
  'verglasung': null,
});

const state = reactive({
  'dachfenster': false,
  'gauben': false,
});

const safe = () => {
  form.put(route('bedarf.roof.update', product.id), {
    onSuccess: () => {
      console.log('lul')
    },
  });
};

const addDachfenster = () => {

  if (!props.roof) {

    form.put(route('bedarf.roof.update', product.id), {
      onSuccess: () => {

      },
    });

  }

  //
  // dachfensterForm.post(route('dachfenster.store'), {
  //   onSuccess: () => {
  //     dachfensterForm.reset();
  //     state.dachfenster = false;
  //   },
  // });
};

</script>


<template>


  <el-form class='grid sm:grid-cols-2 gap-x-4 px-4' label-position='top' size='large'>

    <el-form-item label='Dachneigung in Grad (Schätzung reicht)' required>
      <el-input-number v-model='form.dachneigung' :max='90' :min='0' :step='5' placeholder='0'></el-input-number>
    </el-form-item>

    <el-form-item label='Kniestockhöhe in cm'>
      <el-input-number v-model='form.kniestock' :max='250' :min='0' placeholder='0'></el-input-number>
    </el-form-item>

    <el-form-item label='Aufdachdämmung Stärke in cm'>
      <el-input-number v-model='form.aufdachdaemmung' :max='250' :min='0' placeholder='0'></el-input-number>
    </el-form-item>

    <el-form-item label='Gefachdämmung Stärke in cm'>
      <el-input-number v-model='form.gefachdaemmung' :max='250' :min='0' placeholder='0'></el-input-number>
    </el-form-item>

    <el-alert class='sm:col-span-2'
              show-icon
              title='Bitte geben Sie die bekannten oder messbaren Werte an. Sofern diese nicht vorliegen, lassen Sie die entsprechenden Felder bitte leer. In diesem Fall wird der Energieausweis auf Basis von Pauschalwerten berechnet.' />
  </el-form>

  <div class='px-4 py-4 mt-4 flex justify-end border-t border-gray-200'>

    <el-button bg size='large' text @click='state.dachfenster = true'>
      <plus-icon class='h-4 w-4 mr-1' />
      Dachfenster hinzufügen
    </el-button>
    <el-button bg size='large' text>
      <plus-icon class='h-4 w-4 mr-1' />
      Gaube hinzufügen
    </el-button>

  </div>

  <el-drawer v-model='state.dachfenster'>
    <template #header>
      <h2>Dachfenster hinzufügen</h2>
    </template>

    <el-form label-position='top' size='large'>

      <el-form-item label='Anzahl'>
        <el-input-number v-model='dachfensterForm.count' :max='20' :min='0' :step='1' placeholder='0'></el-input-number>
      </el-form-item>

      <el-form-item label='Höhe in cm'>
        <el-input-number v-model='dachfensterForm.height' :max='500' :min='0' :step='1'
                         placeholder='0'></el-input-number>
      </el-form-item>

      <el-form-item label='Breite in cm'>
        <el-input-number v-model='dachfensterForm.width' :max='500' :min='0' :step='1'
                         placeholder='0'></el-input-number>
      </el-form-item>

      <el-form-item label='Verglasung'>
        <el-select v-model='dachfensterForm.verglasung' class='w-full' placeholder='Bitte auswählen'>
          <el-option label='Nicht bekannt' value='nicht bekannt'></el-option>
          <el-option label='Einfach verglast' value='einfach verglast'></el-option>
          <el-option label='Doppelt verglast' value='doppelt verglast'></el-option>
          <el-option label='Dreifach verglast' value='dreifach verglast'></el-option>
        </el-select>
      </el-form-item>

      <div class='flex justify-end mt-5'>
        <el-button type='primary' @click='addDachfenster'>Hinzufügen</el-button>
      </div>
    </el-form>

  </el-drawer>


  <Teleport v-if='showButton' to='#roof-button-container'>
    <el-button size='large' type='primary' @click='safe'>Speichern</el-button>
  </Teleport>

</template>

<style scoped>
.el-input-number {
  width: 100%;
}
</style>
