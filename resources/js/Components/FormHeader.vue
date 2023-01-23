<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
  title: String,
  subtitle: String,
  switcher: {
    type: Boolean,
    default: undefined,
  },
});

const value = ref(props.switcher);
const emit = defineEmits(['update:switcher']);

watch(
  value,
  (value) => {
    emit('update:switcher', value);
  },
  { immediate: true },
);

</script>

<template>
  <div class='sm:col-span-2 mb-6'>
    <div class='flex items-center'>
      <h3 class='text-lg font-medium leading-6 text-gray-900'>
        {{ title }}
      </h3>
      <template v-if='switcher !== undefined'>
        <el-switch v-model='value' class='ml-2' size='default' />
      </template>

    </div>
    <p class='mt-1 text-sm text-gray-500'>
      {{ subtitle }}
    </p>
  </div>

</template>
