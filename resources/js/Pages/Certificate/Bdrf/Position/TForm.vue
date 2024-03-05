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
                <div class="flex w-24 justify-center">
                    <div class="h-8 w-10 bg-blue-100"></div>
                </div>
                <div
                    class="h-8 w-24 bg-blue-100 border-b-2 border-red-400"></div>

                <div class="flex w-24 justify-between">
                    <span>&#8592;</span>
                    <span>A</span>
                    <span>&#8594;</span>
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
            <div class="flex">
                <div class="flex flex-col">
                    <div class="flex w-24 justify-center">
                        <div class="h-8 w-10 bg-blue-100"></div>
                    </div>
                    <div
                        class="h-8 w-24 bg-blue-100 border-r-2 border-red-400"></div>
                </div>

                <div
                    class="flex flex-col self-center h-8 overflow-hidden items-end ml-1">
                    <span class="-my-1">&#8593;</span>

                    <span class="-my-1">&#8595;</span>
                </div>
                <div
                    class="flex flex-col h-8 self-center overflow-hidden items-center justify-center ml-1">
                    B
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
            <div class="flex">
                <div class="flex flex-col">
                    <div class="flex w-24 justify-center">
                        <div
                            class="h-8 w-10 bg-blue-100 border-r-2 border-red-400"></div>
                    </div>
                    <div class="h-8 w-24 bg-blue-100"></div>
                </div>

                <div class="flex flex-col h-8 overflow-hidden items-end ml-1">
                    <span class="-my-1">&#8593;</span>

                    <span class="-my-1">&#8595;</span>
                </div>
                <div
                    class="flex flex-col h-8 overflow-hidden items-center justify-center ml-1">
                    C
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
            <div class="flex flex-col w-24">
                <div class="flex w-10 self-center justify-between">
                    <span>&#8592;</span>
                    <span>D</span>
                    <span>&#8594;</span>
                </div>
                <div class="flex w-24 justify-center">
                    <div
                        class="h-8 w-10 bg-blue-100 border-t-2 border-red-400"></div>
                </div>
                <div class="h-8 w-24 bg-blue-100"></div>
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
