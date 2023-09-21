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
                <div class="flex">
                    <div
                        class="h-16 w-12 bg-blue-100 border-t-2 border-red-400"></div>
                    <div
                        class="h-10 w-12 bg-blue-100 border-t-2 border-red-400"></div>
                </div>
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
            <div class="flex self-center">
                <div
                    class="flex flex-col h-16 items-center justify-between mr-1">
                    <span>&#8593;</span>
                    <span>B</span>
                    <span>&#8595;</span>
                </div>
                <div class="flex">
                    <div
                        class="h-16 w-12 bg-blue-100 border-l-2 border-red-400"></div>
                    <div class="h-10 w-12 bg-blue-100"></div>
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

        <div class="grid grid-cols-2">
            <div class="flex flex-col self-center">
                <div class="flex">
                    <div
                        class="h-16 w-12 bg-blue-100 border-b-2 border-red-400"></div>
                    <div class="h-10 w-12 bg-blue-100"></div>
                </div>
                <div class="flex w-12 justify-between">
                    <span>&#8592;</span>
                    <span>C</span>
                    <span>&#8594;</span>
                </div>
            </div>

            <el-form-item
                :error="_form.errors.side_c"
                :required="true"
                class="flex-1"
                label="Länge C in Meter">
                <el-input-number
                    v-model="_form.side_c"
                    :precision="2"
                    placeholder="Länge"></el-input-number>
            </el-form-item>
        </div>

        <div class="grid grid-cols-2">
            <div class="flex self-center">
                <div class="flex">
                    <div class="h-16 w-12 bg-blue-100"></div>
                    <div
                        class="h-10 w-12 bg-blue-100 border-r-2 border-red-400"></div>
                </div>
                <div
                    class="flex flex-col h-10 overflow-hidden items-center justify-center ml-1">
                    <span>&#8593;</span>

                    <span>&#8595;</span>
                </div>
                <div
                    class="flex flex-col h-10 overflow-hidden items-center justify-center ml-1">
                    D
                </div>
            </div>

            <el-form-item
                :error="_form.errors.side_d"
                :required="true"
                class="flex-1"
                label="Länge D in Meter">
                <el-input-number
                    v-model="_form.side_d"
                    :precision="2"
                    placeholder="Länge"></el-input-number>
            </el-form-item>
        </div>
    </div>
</template>

<style scoped></style>
