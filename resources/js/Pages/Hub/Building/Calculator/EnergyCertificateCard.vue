<script setup>
import {
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue';
import { computed, ref, watch } from 'vue';
import { Link } from '@inertiajs/vue3';
import BzButton from '../../../../Components/BzButton.vue';

const props = defineProps({
    building: Object,
    hasEnergyCertificate: Boolean,
});

const emits = defineEmits(['update:hasEnergyCertificate', 'energyClass']);

const energyCertificateOptions = [
    {
        label: 'Vorhanden',
        value: true,
    },
    {
        label: 'Nicht vorhanden',
        value: false,
    },
];

const energyCertificate = ref(null);

const _hasEnergyCertificate = computed({
    get() {
        return props.hasEnergyCertificate;
    },
    set(value) {
        emits('update:hasEnergyCertificate', value);
    },
});

const existingEnergyCertificate = computed(() => {
    if (props.building.data.products.vrbr?.rating) {
        return props.building.data.products.vrbr?.rating;
    }

    if (props.building.data.products.bdrf?.rating) {
        return props.building.data.products.bdrf?.rating;
    }

    return false;
});

if (props.hasEnergyCertificate === null) {
    _hasEnergyCertificate.value = existingEnergyCertificate.value
        ? energyCertificateOptions[0]
        : energyCertificateOptions[1];

    if (existingEnergyCertificate.value) {
        emits('energyClass', existingEnergyCertificate.value);
        energyCertificate.value = existingEnergyCertificate.value;
    }
}

watch(_hasEnergyCertificate, (value) => {
    if (!value.value) {
        emits('energyClass', null);
    }
});

watch(energyCertificate, (value) => {
    emits('energyClass', value);
});
</script>

<template>
    <div class="rounded-lg bg-gray-100 p-4 flex flex-col">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium leading-6 text-gray-900">
                    Energieausweis
                </h2>
            </div>

            <RadioGroup v-model="_hasEnergyCertificate" class="mt-2">
                <div class="w-full grid grid-cols-2 gap-4">
                    <RadioGroupOption
                        as="template"
                        v-for="option in energyCertificateOptions"
                        :key="option"
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
            v-if="_hasEnergyCertificate?.value && !existingEnergyCertificate">
            <div class="flex flex-col my-4">
                <div class="flex justify-center items-center">
                    <span class="uppercase text-xs font-semibold text-gray-500"
                        >Energieausweisklasse</span
                    >
                </div>
                <el-select
                    v-model="energyCertificate"
                    size="default"
                    placeholder="Bitte auswählen">
                    <el-option
                        v-for="item in [
                            'A+',
                            'A',
                            'B',
                            'C',
                            'D',
                            'E',
                            'F',
                            'G',
                            'H',
                        ]"
                        :label="item"
                        :value="item" />
                </el-select>
            </div>
        </div>

        <div
            v-else-if="
                _hasEnergyCertificate?.value && existingEnergyCertificate
            "
            class="rounded-lg mt-4 bg-white flex justify-center items-center py-4 px-6 border-2 border-primary">
            <span class="text-xs text-gray-700 font-bold uppercase"
                >Energieausweisklasse {{ existingEnergyCertificate }}</span
            >
        </div>

        <div
            class="flex-1 flex flex-col items-center justify-end text-xs text-gray-500 pb-4">
            <span v-if="existingEnergyCertificate">
                *Die Energieausweisklasse wurde direkt durch das System
                übernommen.
            </span>
            <span v-else-if="_hasEnergyCertificate?.value">
                *Bitte geben Sie die Energieausweisklasse an. Sie finden diese
                auf dem Energieausweis. Oder erstellen Sie einen Energieausweis
                über Bauzertifikate.de
                <Link
                    class="text-primary font-bold"
                    :href="
                        route(
                            'hub.products.buildings.energieausweis',
                            building.data.id
                        )
                    "
                    >hier</Link
                >.
            </span>
            <div v-else>
                <bz-button
                    class="w-full"
                    as="link"
                    :href="
                        route(
                            'hub.products.buildings.energieausweis',
                            building.data.id
                        )
                    "
                    >Jetzt erstellen</bz-button
                >

                <span class="leading-6">
                    Bis zu <span class="font-bold">10% Zuschuss</span> mehr mit
                    einem Energieausweis.
                </span>
            </div>
        </div>
    </div>
</template>
