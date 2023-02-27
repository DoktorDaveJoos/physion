<script setup>

defineProps({
  form: Object,
});

</script>


<template>
  <el-form class='p-4 grid sm:grid-cols-2 gap-4' label-position='top' size='large'>
    <el-form-item
      v-if='form.bauweise[1] !== "gefach"'
      :error='form.errors.zwischendecke'
      :label='`Stärke ${ form.dachform.title === "Satteldach" ? "Zwischendecke" : "Decke/Pultdach" } (falls bekannt)`'>
      <el-input-number v-model='form.zwischendecke' :max='200' :min='0' :step='1' placeholder='0' />
    </el-form-item>
    <el-form-item :error='form.errors.kniestock' label='Kniestockhöhe in cm'>
      <el-input-number v-model='form.kniestock' :max='250' :min='0' placeholder='0'></el-input-number>
    </el-form-item>
    <el-form-item :error='form.errors.dachneigung' label='Dachneigung in Grad (Schätzung reicht)' required>
      <el-input-number v-model='form.dachneigung' :max='90' :min='0' :step='5' placeholder='0'></el-input-number>
    </el-form-item>
  </el-form>
</template>


<style scoped>
.el-input-number {
  width: 100%;
}
</style>
