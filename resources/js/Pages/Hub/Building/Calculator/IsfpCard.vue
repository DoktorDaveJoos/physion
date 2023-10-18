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
import Badge from '../../../../Components/Badge.vue';

const props = defineProps({
    building: Object,
    isfp: Boolean,
});

const emits = defineEmits(['update:isfp']);

const targetOptions = [
    { label: 'Vorhanden', value: true },
    { label: 'Nicht vorhanden', value: false },
];

const _isfpExisting = computed({
    get() {
        return props.isfp;
    },
    set(value) {
        emits('update:isfp', value);
    },
});
</script>

<template>
    <div
        v-show="!building.data.products.isfp?.id"
        class="rounded-lg min-h-[250px] bg-gray-100 p-4 flex flex-col">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium leading-6 text-gray-900">
                    Sanierungsfahrplan (iSFP)
                </h2>
            </div>

            <RadioGroup v-model="_isfpExisting" class="mt-2">
                <div class="w-full grid grid-cols-2 gap-4">
                    <RadioGroupOption
                        as="template"
                        v-for="option in targetOptions"
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

        <div
            class="flex-1 flex flex-col items-center justify-end text-xs text-gray-500 pb-4">
            <span v-if="_isfpExisting && !!building.data.products.isfp?.id">
                *Der Sanierungsfahrplan ist vorhanden und wurde bei
                Bauzertifikate.de erstellt.
            </span>
            <span v-else-if="_isfpExisting">
                *Der Sanierungsfahrplan wurde nicht bei Bauzertifikate.de
                erstellt.
                <span class="font-bold"
                    >Für die Validität des iSFP übernimmt Bauzertifikate.de
                    keine Haftung</span
                >
            </span>
            <div v-else>
                <bz-button
                    class="w-full"
                    as="link"
                    :href="
                        route('hub.products.buildings.isfp', building.data.id)
                    "
                    >Jetzt iSFP erstellen</bz-button
                >
                <span class="leading-6">
                    Bis zu <span class="font-bold">5% Zuschuss</span> auf jede
                    Maßnahme extra
                </span>
            </div>
        </div>
    </div>
</template>
