<script setup>
import {
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue';
import { computed } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
    building: Object,
    reason: Object,
});

const emits = defineEmits(['update:reason']);

const plans = [
    {
        name: 'Neubau',
        description:
            props.building.data.construction_year < dayjs().year()
                ? 'Kann nicht angewählt werden, da das Baujahr in der Vergangenheit liegt'
                : 'Kann angewählt werden, weil das Baujahr im aktuellen Jahr oder in der Zukunft liegt',
        active: props.building.data.construction_year >= dayjs().year(),
    },
    {
        name: 'Sanierung',
        description:
            props.building.data.construction_year <= dayjs().year()
                ? 'Kann angewählt werden, weil das Baujahr in diesem oder den Jahren zuvor liegt'
                : 'Kann angewählt werden, da das Baujahr in der Zukunft liegt',
        active: props.building.data.construction_year <= dayjs().year(),
    },
];

const _reason = computed({
    get() {
        return props.reason;
    },
    set(value) {
        emits('update:reason', value);
    },
});

if (props.reason === null) {
    _reason.value =
        props.building.data.construction_year < dayjs().year()
            ? plans[1]
            : plans[0];
}
</script>

<template>
    <div class="rounded-lg p-4 bg-gray-100">
        <RadioGroup v-model="_reason">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium leading-6 text-gray-900">
                    Fördergrund
                </h2>
            </div>
            <div class="space-y-4 mt-2">
                <RadioGroupOption
                    as="template"
                    v-for="plan in plans"
                    :disabled="!plan.active"
                    :key="plan.name"
                    :value="plan"
                    v-slot="{ active, checked, disabled }">
                    <div
                        :class="[
                            active
                                ? 'border-blue-600 ring-2 ring-blue-600'
                                : 'border-gray-300',
                            disabled
                                ? 'cursor-not-allowed opacity-70'
                                : 'cursor-pointer',
                            'relative block rounded-lg  bg-white px-6 py-4 focus:outline-none sm:flex sm:justify-between',
                        ]">
                        <span class="flex items-center">
                            <span class="flex flex-col text-sm">
                                <RadioGroupLabel
                                    as="span"
                                    class="font-medium text-gray-900"
                                    >{{ plan.name }}</RadioGroupLabel
                                >
                                <RadioGroupDescription
                                    as="span"
                                    class="text-gray-500">
                                    <span class="block sm:inline">{{
                                        plan.description
                                    }}</span>
                                </RadioGroupDescription>
                            </span>
                        </span>

                        <span
                            :class="[
                                active ? 'border' : 'border-2',
                                checked
                                    ? 'border-blue-600'
                                    : 'border-transparent',
                                'pointer-events-none absolute -inset-px rounded-lg',
                            ]"
                            aria-hidden="true" />
                    </div>
                </RadioGroupOption>
            </div>
        </RadioGroup>
    </div>
</template>
