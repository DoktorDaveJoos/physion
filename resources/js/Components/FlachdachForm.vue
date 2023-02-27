<script setup>

const props = defineProps({
  form: Object,
});

</script>


<template>
  <el-form class='p-4 grid sm:grid-cols-2 gap-4' label-position='top' size='large'>
    <el-form-item
      :label='`Stärke ${ form.dachform.title === "Satteldach" ? "Zwischendecke" : "Decke/Flachdach" } (falls bekannt)`'>
      <el-input-number v-model='form.zwischendecke' :max='200' :min='0' :step='1' placeholder='0' />
    </el-form-item>
  </el-form>
</template>


<style scoped>
.el-input-number {
  width: 100%;
}
</style>
