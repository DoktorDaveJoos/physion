<script setup>
import { CheckIcon, EyeIcon } from '@heroicons/vue/24/outline';
import { Link, usePage } from '@inertiajs/inertia-vue3';

const props = usePage().props.value;

const steps = {
  verbrauch: [
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
  ],

  bedarf: [
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
      key: 'position',
      name: 'Lage & Grundriss',
      description: 'Angaben zur Bemaßung und Lage des Gebäudes',
      status: 'upcoming',
    },
    {
      key: 'wall',
      name: 'Wände',
      description: 'Component testing',
      status: 'upcoming',
    },
  ],
};
</script>

<template>
  <nav aria-label='Steps' class='z-0'>
    <el-affix :offset='135' target='#stepper-container' class='pb-10'>
      <ol class='overflow-hidden' role='list'>
        <li
          v-for='(step, stepIdx) in steps[props.context]'
          :key='step.name'
          :class="[
                    stepIdx !== steps[props.context].length - 1 ? 'pb-10' : '',
                    'relative',
                ]">
          <template v-if='props.order'>
            <template
              v-if='
                            props.order.meta.completed.includes(step.key) &&
                            step.key === props.step
                        '>
              <div
                v-if='stepIdx !== steps[props.context].length - 1'
                aria-hidden='true'
                class='absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-blue-600' />
              <Link
                :href='
                                route(
                                    `${props.context}.${step.key}`,
                                    props.order.id
                                )
                            '
                class='group relative flex items-start'>
                <span class='flex h-9 items-center'>
                  <span
                    class='relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800'>
                    <EyeIcon
                      aria-hidden='true'
                      class='h-4 w-4 text-white' />
                  </span>
                </span>
                <span class='ml-4 flex min-w-0 flex-col'>
                  <span
                    class='text-sm font-medium text-blue-600'
                  >{{ step.name }}</span
                  >
                  <span class='text-sm text-gray-500'>{{
                      step.description
                    }}</span>
                </span>
              </Link>
            </template>

            <template
              v-else-if='
                            props.order.meta.completed.includes(step.key)
                        '>
              <div
                v-if='stepIdx !== steps[props.context].length - 1'
                aria-hidden='true'
                class='absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-blue-600' />
              <Link
                :href='
                                route(
                                    `${props.context}.${step.key}`,
                                    props.order.id
                                )
                            '
                class='group relative flex items-start'>
                <span class='flex h-9 items-center'>
                  <span
                    class='relative z-10 flex h-8 w-8 items-center justify-center rounded-full bg-blue-600 group-hover:bg-blue-800'>
                    <CheckIcon
                      aria-hidden='true'
                      class='h-4 w-4 text-white' />
                  </span>
                </span>
                <span class='ml-4 flex min-w-0 flex-col'>
                  <span class='text-sm font-medium'>{{
                      step.name
                    }}</span>
                  <span class='text-sm text-gray-500'>{{
                      step.description
                    }}</span>
                </span>
              </Link>
            </template>

            <template v-else-if='step.key === props.step'>
              <div
                v-if='stepIdx !== steps[props.context].length - 1'
                aria-hidden='true'
                class='absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300' />
              <Link
                :href='
                                route(
                                    `${props.context}.${step.key}`,
                                    props.order.id
                                )
                            '
                aria-current='step'
                class='group relative flex items-start'>
                <span
                  aria-hidden='true'
                  class='flex h-9 items-center'>
                  <span
                    class='relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-blue-600 bg-white'>
                    <span
                      class='h-2.5 w-2.5 rounded-full bg-blue-600' />
                  </span>
                </span>
                <span class='ml-4 flex min-w-0 flex-col'>
                  <span
                    class='text-sm font-medium text-blue-600'
                  >{{ step.name }}</span
                  >
                  <span class='text-sm text-gray-500'>{{
                      step.description
                    }}</span>
                </span>
              </Link>
            </template>

            <template v-else>
              <div
                v-if='stepIdx !== steps[props.context].length - 1'
                aria-hidden='true'
                class='absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300' />
              <Link
                :href='
                                route(
                                    `${props.context}.${step.key}`,
                                    props.order.id
                                )
                            '
                class='group relative flex items-start'>
                <span
                  aria-hidden='true'
                  class='flex h-9 items-center'>
                  <span
                    class='relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400'>
                    <span
                      class='h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300' />
                  </span>
                </span>
                <span class='ml-4 flex min-w-0 flex-col'>
                  <span
                    class='text-sm font-medium text-gray-500'
                  >{{ step.name }}</span
                  >
                  <span class='text-sm text-gray-500'>{{
                      step.description
                    }}</span>
                </span>
              </Link>
            </template>
          </template>

          <template v-else>
            <template v-if='stepIdx === 0'>
              <div
                v-if='stepIdx !== steps[props.context].length - 1'
                aria-hidden='true'
                class='absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300' />
              <a
                aria-current='step'
                class='group relative flex items-start'
                href='#'>
                <span
                  aria-hidden='true'
                  class='flex h-9 items-center'>
                  <span
                    class='relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-blue-600 bg-white'>
                    <span
                      class='h-2.5 w-2.5 rounded-full bg-blue-600' />
                  </span>
                </span>
                <span class='ml-4 flex min-w-0 flex-col'>
                  <span
                    class='text-sm font-medium text-blue-600'
                  >{{ step.name }}</span
                  >
                  <span class='text-sm text-gray-500'>{{
                      step.description
                    }}</span>
                </span>
              </a>
            </template>
            <template v-else>
              <div
                v-if='stepIdx !== steps[props.context].length - 1'
                aria-hidden='true'
                class='absolute top-4 left-4 -ml-px mt-0.5 h-full w-0.5 bg-gray-300' />
              <a class='group relative flex items-start' href='#'>
                <span
                  aria-hidden='true'
                  class='flex h-9 items-center'>
                  <span
                    class='relative z-10 flex h-8 w-8 items-center justify-center rounded-full border-2 border-gray-300 bg-white group-hover:border-gray-400'>
                    <span
                      class='h-2.5 w-2.5 rounded-full bg-transparent group-hover:bg-gray-300' />
                  </span>
                </span>
                <span class='ml-4 flex min-w-0 flex-col'>
                  <span
                    class='text-sm font-medium text-gray-500'
                  >{{ step.name }}</span
                  >
                  <span class='text-sm text-gray-500'>{{
                      step.description
                    }}</span>
                </span>
              </a>
            </template>
          </template>
        </li>
      </ol>
    </el-affix>
  </nav>
</template>
