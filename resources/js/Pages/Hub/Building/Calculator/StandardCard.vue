<script setup>
import { RadioGroup, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue';
import { computed } from 'vue';

const props = defineProps({
    building: Object,
    eh: Boolean,
    la: Boolean,
    qng: Boolean,
});

const emits = defineEmits(['update:eh', 'update:la', 'update:qng']);

const ehOptions = [
    { label: 'EH 40', value: true },
    { label: 'Schlechter', value: false },
];

const laOptions = [
    { label: 'Vorhanden', value: true },
    { label: 'Nicht vorhanden', value: false },
];

const qngOptions = [
    { label: 'Vorhanden', value: true },
    { label: 'Nicht vorhanden', value: false },
];

const _eh = computed({
    get() {
        return props.eh;
    },
    set(value) {
        emits('update:eh', value);
    },
});

const _la = computed({
    get() {
        return props.la;
    },
    set(value) {
        emits('update:la', value);
    },
});

const _qng = computed({
    get() {
        return props.qng;
    },
    set(value) {
        emits('update:qng', value);
    },
});
</script>

<template>
    <div class="rounded-lg bg-gray-100 p-4 flex flex-col">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium leading-6 text-gray-900">
                    Effizienzhaus-Stufe
                </h2>
            </div>

            <RadioGroup v-model="_eh" class="mt-2">
                <div class="w-full grid grid-cols-2 gap-4">
                    <RadioGroupOption
                        as="template"
                        v-for="option in ehOptions"
                        :key="option.label"
                        :value="option.value"
                        v-slot="{ active, checked }">
                        <div
                            :class="[
                                active ? '' : '',
                                checked
                                    ? 'bg-white border-2 border-blue-600'
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

            <template v-if="_eh">
                <div class="flex items-center justify-between mt-4">
                    <h2 class="text-sm font-medium leading-6 text-gray-900">
                        QNG Zertifikat
                    </h2>
                </div>

                <RadioGroup v-model="_qng" class="mt-2">
                    <div class="w-full grid grid-cols-2 gap-4">
                        <RadioGroupOption
                            as="template"
                            v-for="option in qngOptions"
                            :key="option.label"
                            :value="option.value"
                            v-slot="{ active, checked }">
                            <div
                                :class="[
                                    active ? '' : '',
                                    checked
                                        ? 'bg-white border-2 border-blue-600'
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
            </template>

            <template v-if="_eh && !_qng">
                <div class="flex items-center justify-between mt-4">
                    <h2 class="text-sm font-medium leading-6 text-gray-900">
                        Lebenszyklus Analyse
                    </h2>
                </div>

                <RadioGroup v-model="_la" class="mt-2">
                    <div class="w-full grid grid-cols-2 gap-4">
                        <RadioGroupOption
                            as="template"
                            v-for="option in laOptions"
                            :key="option.label"
                            :value="option.value"
                            v-slot="{ active, checked }">
                            <div
                                :class="[
                                    active ? '' : '',
                                    checked
                                        ? 'bg-white border-2 border-blue-600'
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
            </template>
        </div>

        <div v-if="!_eh" class="flex flex-1 flex-col justify-end pb-4">
            <span class="text-gray-500 text-xs">
                *Günstige KFW Kredite werden nur für nachhaltige Gebäude mit
                einer Energieeffizienzhaus-Stufe von 40 oder besser vergeben.
            </span>
        </div>
    </div>
</template>
