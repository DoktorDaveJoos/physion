<script setup>
import RectangleForm from './RectangleForm.vue';
import TForm from './TForm.vue';
import LForm from './LForm.vue';
import { computed } from 'vue';

const props = defineProps({
    type: {
        type: String,
        required: true,
    },
    form: {
        type: Object,
        required: true,
    },
});

defineEmits(['update:form']);

const _form = computed({
    get() {
        return props.form;
    },
    set(value) {
        emit('update:form', value);
    },
});
</script>

<template>
    <template v-if="type === 'rectangle'">
        <RectangleForm v-model:form="_form" />
    </template>

    <template v-else-if="type === 't'">
        <TForm v-model:form="_form" />
    </template>

    <template v-else-if="type === 'l'">
        <LForm v-model:form="_form" />
    </template>
</template>
