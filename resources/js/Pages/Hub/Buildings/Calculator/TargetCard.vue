<script setup>
import {
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue';
import { computed, ref, watch } from 'vue';
import BzButton from '../../../../Components/BzButton.vue';
import { InformationCircleIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    building: Object,
    targetKnown: Boolean,
});

const emits = defineEmits(['update:targetKnown', 'target']);

const targetOptions = [
    { label: 'Bekannt', value: true },
    { label: 'Nicht bekannt', value: false },
];

const target = ref(null);

const _targetKnown = computed({
    get() {
        return props.targetKnown;
    },
    set(value) {
        emits('update:targetKnown', value);
    },
});

const existingTarget = computed(() => {
    if (props.building.data.products.isfp?.target) {
        return props.building.data.products.isfp?.target;
    }

    return false;
});

if (props.targetKnown === null) {
    _targetKnown.value = existingTarget.value
        ? targetOptions[0]
        : targetOptions[1];
}

watch(_targetKnown, (value) => {
    if (!value?.value) {
        emits('target', null);
    }
});

watch(target, (value) => {
    emits('target', value);
});
</script>

<template>
    <div class="rounded-lg bg-gray-100 p-4 flex flex-col">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium leading-6 text-gray-900">
                    Gebäude Zielzustand
                </h2>
            </div>

            <RadioGroup v-model="_targetKnown" class="mt-2">
                <div class="w-full grid grid-cols-2 gap-4">
                    <RadioGroupOption
                        as="template"
                        v-for="option in targetOptions"
                        :key="option.label"
                        :value="option"
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

        <div
            class="flex flex-col flex-1 items-center"
            v-if="_targetKnown?.value && !existingTarget">
            <div class="flex flex-col my-4">
                <div class="flex justify-center items-center">
                    <span class="uppercase text-xs font-semibold text-gray-500"
                        >Zielzustand</span
                    >
                </div>
                <el-select
                    v-model="target"
                    class="!w-full"
                    placeholder="Bitte auswählen">
                    <el-option
                        v-for="item in [
                            'EH 40',
                            'EH 40 EE',
                            'EH 55',
                            'EH 55 EE',
                            'EH 70',
                            'EH 70 EE',
                            'EH 85',
                            'EH 85 EE',
                            'EH Denkmal',
                            'EH Denkmal EE',
                        ]"
                        :label="item"
                        :value="item" />
                </el-select>
            </div>
        </div>

        <div
            v-else-if="_targetKnown?.value && existingTarget"
            class="rounded-lg mt-4 bg-white flex justify-center items-center py-4 px-6 border-2 border-primary">
            <span class="text-xs text-gray-700 font-bold uppercase"
                >Zielzustand {{ existingTarget }}</span
            >
        </div>

        <div
            class="flex-1 flex flex-col items-center justify-end text-xs text-gray-500 pb-4">
            <span v-if="existingTarget">
                *Die Energieausweisklasse wurde direkt durch das System
                übernommen.
            </span>
            <span v-else-if="_targetKnown?.value">
                *Bitte geben Sie den Zielzustand an. Sie erfahren diesen durch
                den iSFP, den Energieberater, Bausachverständigen oder
                Architekten. Erstellen Sie jetzt einen iSFP
                <Link
                    class="text-primary font-bold"
                    :href="
                        route('buildings.products.ecert.show', building.data.id)
                    "
                    >hier</Link
                >.
            </span>
            <div v-else>
                <bz-button
                    class="w-full"
                    as="link"
                    :href="
                        route('buildings.products.isfp.show', building.data.id)
                    "
                    >Jetzt iSFP erstellen</bz-button
                >
                <span class="leading-6">
                    Bis zu <span class="font-bold">20% Zuschuss</span> mehr mit
                    einem bekanntem Zielzustand.
                </span>
            </div>
        </div>
    </div>
</template>
