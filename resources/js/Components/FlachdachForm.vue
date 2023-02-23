<script setup>

import { onMounted, ref } from 'vue';

const safe = () => {
  alert('Flachdach');
};

const showButton = ref(false);

onMounted(() => {
  showButton.value = true;
})

</script>


<template>


  <Teleport v-if='showButton' to='#roof-button-container'>

    <el-button size='large' type='primary' @click='safe'>Speichern</el-button>

  </Teleport>

</template>
