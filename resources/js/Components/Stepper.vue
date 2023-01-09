<script setup>
import {CheckIcon, EyeIcon} from '@heroicons/vue/24/outline';
import {usePage, Link} from '@inertiajs/inertia-vue3';

const props = usePage().props.value;

const steps = [
    {
        key: 'general',
        name: 'Allgemein',
        description: 'Auftragserfassung und allgemeine Daten',
        status: 'upcoming',
    },
    {
        key: 'details',
        name: 'Gebäudedetails',
        description: 'Spezifische Daten zum Gebäude',
        status: 'upcoming',
    },
    {
        key: 'consumption',
        name: 'Verbrauchsdaten ',
        description: 'Daten zum bisherigen Verbrauch des Gebäudes',
        status: 'upcoming',
    },
    {
        key: 'summary',
        name: 'Abschluss',
        description: 'Prüfen und schließen Sie den Auftrag ab',
        status: 'upcoming',
    },
];

</script>

<template>
    <nav aria-label="Steps" class="pt-12">
        <ol role="list" class="overflow-hidden">
            <li v-for="(step, stepIdx) in steps" :key="step.name"
                :class="[stepIdx !== steps.length - 1 ? 'pb-10' : '', 'relative']">
                <template v-if="props.order">
                    <template v-if="props.order.meta.completed.includes(step.key) && step.key === props.step">
                        <div v-if="stepIdx !== steps.length - 1"
                             class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-blue-600" aria-hidden="true" />
                        <Link :href="route(`${props.context}.${step.key}`, props.order.id)"
                              class="group relative flex items-start">
                            <span class="flex h-9 items-center">
                                <span
                                    class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800">
                                    <EyeIcon class="h-4 w-4 text-white" aria-hidden="true" />
                                </span>
                            </span>
                            <span class="ml-4 flex min-w-0 flex-col">
                                <span class="text-sm font-medium text-blue-600">{{ step.name }}</span>
                                <span class="text-sm text-gray-500">{{ step.description }}</span>
                            </span>
                        </Link>
                    </template>

                    <template v-else-if="props.order.meta.completed.includes(step.key)">
                        <div v-if="stepIdx !== steps.length - 1"
                             class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-blue-600" aria-hidden="true" />
                        <Link :href="route(`${props.context}.${step.key}`, props.order.id)"
                              class="group relative flex items-start">
                            <span class="flex h-9 items-center">
                                <span
                                    class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800">
                                    <CheckIcon class="h-4 w-4 text-white" aria-hidden="true" />
                                </span>
                            </span>
                            <span class="ml-4 flex min-w-0 flex-col">
                                <span class="text-sm font-medium">{{ step.name }}</span>
                                <span class="text-sm text-gray-500">{{ step.description }}</span>
                            </span>
                        </Link>
                    </template>

                    <template v-else-if="step.key === props.step">
                        <div v-if="stepIdx !== steps.length - 1"
                             class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true" />
                        <Link :href="route(`${props.context}.${step.key}`, props.order.id)"
                              class="group relative flex items-start" aria-current="step">
                            <span class="flex h-9 items-center" aria-hidden="true">
                                <span
                                    class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-blue-600 bg-white">
                                    <span class="h-2.5 w-2.5 rounded-full bg-blue-600" />
                                </span>
                            </span>
                            <span class="ml-4 flex min-w-0 flex-col">
                                <span class="text-sm font-medium text-blue-600">{{ step.name }}</span>
                                <span class="text-sm text-gray-500">{{ step.description }}</span>
                            </span>
                        </Link>
                    </template>

                    <template v-else>
                        <div v-if="stepIdx !== steps.length - 1"
                             class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true" />
                        <Link :href="route(`${props.context}.${step.key}`, props.order.id)"
                              class="group relative flex items-start">
                            <span class="flex h-9 items-center" aria-hidden="true">
                                <span
                                    class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
                                    <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300" />
                                </span>
                            </span>
                            <span class="ml-4 flex min-w-0 flex-col">
                                <span class="text-sm font-medium text-gray-500">{{ step.name }}</span>
                                <span class="text-sm text-gray-500">{{ step.description }}</span>
                            </span>
                        </Link>
                    </template>
                </template>


                <template v-else>
                    <template v-if="stepIdx === 0">
                        <div v-if="stepIdx !== steps.length - 1"
                             class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true" />
                        <a href="#"
                              class="group relative flex items-start" aria-current="step">
                            <span class="flex h-9 items-center" aria-hidden="true">
                                <span
                                    class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-blue-600 bg-white">
                                    <span class="h-2.5 w-2.5 rounded-full bg-blue-600" />
                                </span>
                            </span>
                            <span class="ml-4 flex min-w-0 flex-col">
                                <span class="text-sm font-medium text-blue-600">{{ step.name }}</span>
                                <span class="text-sm text-gray-500">{{ step.description }}</span>
                            </span>
                        </a>
                    </template>
                    <template v-else>
                        <div v-if="stepIdx !== steps.length - 1"
                             class="absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300" aria-hidden="true" />
                        <a href="#"
                              class="group relative flex items-start">
                            <span class="flex h-9 items-center" aria-hidden="true">
                                <span
                                    class="relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400">
                                    <span class="h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300" />
                                </span>
                            </span>
                            <span class="ml-4 flex min-w-0 flex-col">
                                <span class="text-sm font-medium text-gray-500">{{ step.name }}</span>
                                <span class="text-sm text-gray-500">{{ step.description }}</span>
                            </span>
                        </a>
                    </template>
                </template>
            </li>
        </ol>
    </nav>
</template>
