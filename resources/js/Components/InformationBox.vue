<script setup>
import { onMounted, ref } from 'vue';

defineProps({
  to: {
    type: String,
    required: true,
  },
})

const mounted = ref(false);

onMounted(() => {
  mounted.value = true;
});

</script>

<template>
  <template v-if='mounted'>
    <Teleport :to='to'>
      <slot></slot>
    </Teleport>
  </template>
</template>
