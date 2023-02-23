<script setup>

const props = defineProps({
  headerText: {
    type: String,
    default: null,
  },
  optionalText: {
    type: String,
    default: 'Optional',
  },

});

const emit = defineEmits(['optional']);

</script>

<template>
  <el-card class='w-full'>
    <template v-if='headerText' #header>
      <div class='card-header'>
        <span>{{ headerText }}</span>
      </div>
    </template>
    <div class='sm:grid sm:grid-cols-2'>
      <slot></slot>
    </div>
    <el-divider content-position='left'>ODER</el-divider>
    <div class='py-4'>
      <el-button size='large' @click='$emit("optional")'>
        {{ optionalText }}
      </el-button>
    </div>
  </el-card>
</template>
