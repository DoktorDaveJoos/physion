<template>
    <template v-if="step === 0">
        <RadioGroup v-model="selectedYear">
            <RadioGroupLabel class="font-semibold mb-1">
                Baujahr des Gebäudes</RadioGroupLabel
            >
            <div class="-space-y-px rounded-md bg-white">
                <RadioGroupOption
                    as="template"
                    v-for="(setting, settingIdx) in settingsConstructionYear"
                    :key="setting.name"
                    :value="setting"
                    v-slot="{ checked, active }">
                    <div
                        :class="[
                            settingIdx === 0
                                ? 'rounded-tl-md rounded-tr-md'
                                : '',
                            settingIdx === settingsConstructionYear.length - 1
                                ? 'rounded-bl-md rounded-br-md'
                                : '',
                            checked
                                ? 'bg-blue-50 border-blue-200 z-10'
                                : 'border-gray-200',
                            'relative border p-4 flex cursor-pointer focus:outline-none',
                        ]">
                        <span
                            :class="[
                                checked
                                    ? 'bg-primary border-transparent'
                                    : 'bg-white border-gray-300',
                                active
                                    ? 'ring-2 ring-offset-2 ring-blue-500'
                                    : '',
                                'mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded-full border flex items-center justify-center',
                            ]"
                            aria-hidden="true">
                            <span class="rounded-full bg-white w-1.5 h-1.5" />
                        </span>
                        <span class="ml-3 flex flex-col">
                            <RadioGroupLabel
                                as="span"
                                :class="[
                                    checked ? 'text-blue-900' : 'text-gray-900',
                                    'block text-sm font-medium',
                                ]">
                                {{ setting.name }}
                            </RadioGroupLabel>
                            <RadioGroupDescription
                                as="span"
                                :class="[
                                    checked ? 'text-blue-700' : 'text-gray-500',
                                    'block text-sm',
                                ]">
                                {{ setting.description }}
                            </RadioGroupDescription>
                        </span>
                    </div>
                </RadioGroupOption>
            </div>
        </RadioGroup>

        <RadioGroup v-model="selectedHousingUnits" class="mt-6">
            <RadioGroupLabel class="font-semibold mb-1">
                Wohneinheiten</RadioGroupLabel
            >
            <div class="-space-y-px rounded-md bg-white">
                <RadioGroupOption
                    as="template"
                    v-for="(setting, settingIdx) in settingsHousingUnits"
                    :key="setting.name"
                    :value="setting"
                    v-slot="{ checked, active }">
                    <div
                        :class="[
                            settingIdx === 0
                                ? 'rounded-tl-md rounded-tr-md'
                                : '',
                            settingIdx === settingsHousingUnits.length - 1
                                ? 'rounded-bl-md rounded-br-md'
                                : '',
                            checked
                                ? 'bg-blue-50 border-blue-200 z-10'
                                : 'border-gray-200',
                            'relative border p-4 flex cursor-pointer focus:outline-none',
                        ]">
                        <span
                            :class="[
                                checked
                                    ? 'bg-primary border-transparent'
                                    : 'bg-white border-gray-300',
                                active
                                    ? 'ring-2 ring-offset-2 ring-blue-500'
                                    : '',
                                'mt-0.5 h-4 w-4 shrink-0 cursor-pointer rounded-full border flex items-center justify-center',
                            ]"
                            aria-hidden="true">
                            <span class="rounded-full bg-white w-1.5 h-1.5" />
                        </span>
                        <span class="ml-3 flex flex-col">
                            <RadioGroupLabel
                                as="span"
                                :class="[
                                    checked ? 'text-blue-900' : 'text-gray-900',
                                    'block text-sm font-medium',
                                ]">
                                {{ setting.name }}
                            </RadioGroupLabel>
                            <RadioGroupDescription
                                as="span"
                                :class="[
                                    checked ? 'text-blue-700' : 'text-gray-500',
                                    'block text-sm',
                                ]">
                                {{ setting.description }}
                            </RadioGroupDescription>
                        </span>
                    </div>
                </RadioGroupOption>
            </div>
        </RadioGroup>

        <el-divider />

        <div class="flex justify-end">
            <el-button type="default" size="large" @click="$emit('close')"
                >Abbrechen</el-button
            >
            <el-button type="primary" size="large" @click="nextStep"
                >Prüfen</el-button
            >
        </div>
    </template>
    <template v-else>
        <div
            class="overflow-hidden rounded-lg sm:grid sm:grid-cols-2 sm:gap-2 sm:divide-y-0">
            <div
                v-for="(action, actionIdx) in actions"
                :key="action.title"
                class="relative group bg-gray-50 hover:bg-gray-100 rounded-lg p-6">
                <div>
                    <span
                        :class="[
                            action.iconBackground,
                            action.iconForeground,
                            'rounded-lg inline-flex p-3 ring-4 ring-white group-hover:ring-blue-500 transition duration-150',
                        ]">
                        <component
                            :is="action.icon"
                            class="h-6 w-6"
                            aria-hidden="true" />
                    </span>
                </div>
                <div class="mt-8">
                    <h3 class="text-lg font-medium">
                        <Link :href="action.href" class="focus:outline-none">
                            <!-- Extend touch target to entire panel -->
                            <span
                                class="absolute inset-0 hover:text-blue-500"
                                aria-hidden="true" />
                            {{ action.title }}
                        </Link>
                    </h3>
                    <p class="mt-2 text-sm text-gray-500 text-wrap">
                        {{ action.description }}
                    </p>
                </div>
                <span
                    class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-blue-500 transition duration-150"
                    aria-hidden="true">
                    <svg
                        class="h-6 w-6"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24">
                        <path
                            d="M20 4h1a1 1 0 00-1-1v1zm-1 12a1 1 0 102 0h-2zM8 3a1 1 0 000 2V3zM3.293 19.293a1 1 0 101.414 1.414l-1.414-1.414zM19 4v12h2V4h-2zm1-1H8v2h12V3zm-.707.293l-16 16 1.414 1.414 16-16-1.414-1.414z" />
                    </svg>
                </span>
            </div>
        </div>
        <el-divider />
        <div class="flex justify-end">
            <el-button
                type="default"
                size="large"
                @click="
                    step = 0;
                    $emit('close');
                "
                >Beenden</el-button
            >
            <el-button type="primary" size="large" @click="previousStep"
                >Zurück</el-button
            >
        </div>
    </template>
</template>

<script setup>
import { computed, ref } from 'vue';
import {
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue';
import { FireIcon, CalculatorIcon } from '@heroicons/vue/24/outline';
import { Link } from '@inertiajs/vue3';

const settingsConstructionYear = [
    {
        name: 'Nach 1978',
        description:
            'Das Gebäude wurde 1978 oder später erbaut oder grundlegend saniert',
    },
    {
        name: 'Vor 1978',
        description:
            'Das Gebäude wurde vor 1978 erbaut und nicht mehr grundlegend saniert',
    },
];

const settingsHousingUnits = [
    {
        name: '1 bis 4',
        description: 'Das Gebäude hat 1 bis maximal 4 Wohneinheiten',
    },
    {
        name: '5 und mehr',
        description: 'Das Gebäude hat mindestens fünf Wohneinheiten',
    },
];

const selectedYear = ref(settingsConstructionYear[0]);
const selectedHousingUnits = ref(settingsHousingUnits[0]);

const actions = computed(() => {
    const bedarf = {
        title: 'Bedarfsausweis',
        description:
            ' Ein Bedarfsausweis bezieht sich auf den theoretischen Energiebedarf des Gebäudes und wird auf Basis von Berechnungen und Simulationen erstellt.',
        href: route('order.create', { category: 'bdrf' }),
        icon: CalculatorIcon,
        iconForeground: 'text-sky-700',
        iconBackground: 'bg-sky-50',
    };

    const verbrauch = {
        title: 'Verbrauchsausweis',
        description:
            'Ein Verbrauchsausweis bezieht sich auf den tatsächlichen Energieverbrauch des Gebäudes und wird auf Basis von Messwerten erstellt.',
        href: route('order.create', { category: 'vrbr' }),
        icon: FireIcon,
        iconForeground: 'text-sky-700',
        iconBackground: 'bg-sky-50',
    };

    const result = [bedarf];

    if (
        selectedYear.value.name === 'Nach 1978' &&
        selectedHousingUnits.value.name === '1 bis 4'
    ) {
        result.push(verbrauch);
    }

    return result;
});
const step = ref(0);

const nextStep = () => {
    step.value++;
};

const previousStep = () => {
    step.value--;
};
</script>
