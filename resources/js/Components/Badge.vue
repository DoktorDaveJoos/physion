<script setup>

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  type: {
    type: String,
    default: 'default',
  },
  dot: {
    type: Boolean,
    default: false,
  },
});

const types = {
  default: {
    bg: 'bg-blue-100',
    text: 'text-blue-800',
    icon: 'text-blue-400',
  },
  success: {
    bg: 'bg-green-100',
    text: 'text-green-800',
    icon: 'text-green-400',
  },
  error: {
    bg: 'bg-red-100',
    text: 'text-red-800',
    icon: 'text-red-400',
  },
  warning: {
    bg: 'bg-yellow-100',
    text: 'text-yellow-800',
    icon: 'text-yellow-400',
  },
};

</script>

<template>
  <div :class='[ types[type].bg, types[type].text ]'
        class='inline-flex justify-between items-center rounded-md px-2.5 py-0.5 text-sm font-medium'>
    <svg v-if='dot' :class='types[type].icon' class='-ml-0.5 mr-1.5 h-2 w-2 text-blue-400' fill='currentColor'
         viewBox='0 0 8 8'>
      <circle cx='4' cy='4' r='3' />
    </svg>
    <div class='flex-1'>
      <slot name='prepend'></slot>
      {{ label }}
    </div>
    <slot name='append'></slot>
  </div>
</template>
