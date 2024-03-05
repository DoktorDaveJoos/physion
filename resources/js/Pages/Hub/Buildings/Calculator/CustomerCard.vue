<script setup>
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue';
import { computed } from 'vue';

const props = defineProps({
    building: Object,
    hasBuilding: Boolean,
    salary: Number,
    kids: Number,
});

const emits = defineEmits([
    'update:hasBuilding',
    'update:salary',
    'update:kids',
]);

const _hasBuilding = computed({
    get() {
        return props.hasBuilding;
    },
    set(value) {
        emits('update:hasBuilding', value);
    },
});

const _salary = computed({
    get() {
        return props.salary;
    },
    set(value) {
        emits('update:salary', parseInt(value));
    },
});

const _kids = computed({
    get() {
        return props.kids;
    },
    set(value) {
        emits('update:kids', parseInt(value));
    },
});

const owningOptions = [
    { label: 'Eigentümer*in', value: true },
    { label: 'Nicht Eigentümer*in', value: false },
];
</script>

<template>
    <div class="rounded-lg bg-gray-100 p-4 flex flex-col">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium leading-6 text-gray-900">
                    Antragsstellende Person
                </h2>
            </div>

            <RadioGroup v-model="_hasBuilding" class="mt-2">
                <div class="w-full grid grid-cols-2 gap-4">
                    <RadioGroupOption
                        as="template"
                        v-for="option in owningOptions"
                        :key="option.label"
                        :value="option.value"
                        v-slot="{ active, checked }">
                        <div
                            :class="[
                                active ? '' : '',
                                checked
                                    ? 'bg-white border-2 border-primary'
                                    : 'bg-white text-gray-900 hover:bg-gray-50',
                                'flex items-center cursor-pointer justify-center rounded-lg py-3 px-3 text-sm font-semibold uppercase sm:flex-1',
                            ]">
                            <RadioGroupLabel as="span" class="text-xs">{{
                                option.label
                            }}</RadioGroupLabel>
                        </div>
                    </RadioGroupOption>
                </div>
            </RadioGroup>
        </div>

        <div class="pt-4" v-if="!hasBuilding">
            <div class="flex w-full items-center">
                <el-form label-position="top" class="w-full">
                    <el-form-item
                        label="Bruttojahreseinkommen Haushalt"
                        required>
                        <el-select
                            v-model="_salary"
                            class="!w-full"
                            placeholder="90.000€">
                            <template #prefix>
                                <span
                                    class="text-gray-500 text-sm font-semibold"
                                    >bis</span
                                >
                            </template>
                            <el-option
                                v-for="item in [
                                    90_000, 100_000, 110_000, 120_000, 130_000,
                                    140_000, 150_000, 160_000, 180_000, 190_000,
                                ]"
                                :key="item"
                                :label="
                                    item.toLocaleString('de-DE') + ' €/Jahr'
                                "
                                :value="item">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
            </div>
            <div class="flex w-full items-center">
                <el-form label-position="top" class="w-full">
                    <el-form-item label="Kinder unter 18 im Haushalt" required>
                        <el-select
                            v-model="_kids"
                            class="!w-full"
                            placeholder="Bitte auswählen">
                            <el-option
                                v-for="item in [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]"
                                :key="item"
                                :label="item"
                                :value="item">
                            </el-option>
                        </el-select>
                    </el-form-item>
                </el-form>
            </div>
        </div>
        <div v-if="hasBuilding" class="flex flex-1 flex-col justify-end pb-4">
            <span class="text-gray-500 text-xs">
                *Gewisse Kredite gelten nur für den Ersterwerb.
            </span>
        </div>
    </div>
</template>
