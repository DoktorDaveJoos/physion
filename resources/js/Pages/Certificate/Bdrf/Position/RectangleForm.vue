<script setup>
import { computed } from 'vue';

const props = defineProps({
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
    <div class="flex flex-col">
        <div class="grid grid-cols-2">
            <div class="flex flex-col">
                <div class="flex w-24 justify-between">
                    <span>&#8592;</span>
                    <span>A</span>
                    <span>&#8594;</span>
                </div>
                <div
                    class="w-24 h-16 bg-blue-100 border-t-2 border-red-400"></div>
            </div>

            <el-form-item
                :error="_form.errors.side_a"
                :required="true"
                class="flex-1"
                label="Länge A in Meter">
                <el-input-number
                    v-model="_form.side_a"
                    :precision="2"
                    placeholder="Länge"></el-input-number>
            </el-form-item>
        </div>

        <div class="grid grid-cols-2">
            <div class="flex self-end">
                <div
                    class="w-24 h-16 bg-blue-100 border-r-2 border-red-400 mr-1"></div>
                <div class="flex flex-col h-16 items-center justify-center">
                    <span>&#8593;</span>
                    <span>B</span>
                    <span>&#8595;</span>
                </div>
            </div>

            <el-form-item
                :error="_form.errors.side_b"
                :required="true"
                class="flex-1"
                label="Länge B in Meter">
                <el-input-number
                    v-model="_form.side_b"
                    :precision="2"
                    placeholder="Länge"></el-input-number>
            </el-form-item>
        </div>
    </div>
</template>

<style scoped></style>
