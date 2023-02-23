<script setup>
import FormHeader from './FormHeader.vue';
import { ref, watch } from 'vue';
import { RadioGroup, RadioGroupDescription, RadioGroupLabel, RadioGroupOption } from '@headlessui/vue';
import { CheckCircleIcon } from '@heroicons/vue/20/solid';
import SatteldachWarmForm from './SatteldachWarmForm.vue';
import { useForm, usePage } from '@inertiajs/inertia-vue3';

const { roof } = usePage().props.value;

const value = ref([]);

watch(
  () => value.value,
  (newValue) => {
    console.log(newValue);
  },
  { deep: true },
);

const options = {
  'satteldach': [
    {
      value: 'kalt',
      label: 'Kalt',
      children: [
        {
          value: 'massiv',
          label: 'Zwischendecke Massiv',
          id: 100,
        },
        {
          value: 'holzbalken',
          label: 'Zwischendecke Holzbalkendecke',
          id: 101,
        },
        {
          value: 'vollholz',
          label: 'Zwischendecke Vollholz',
          id: 102,
        },
      ],
    },
    {
      value: 'beheizt',
      label: 'Beheizt',
      children: [
        {
          value: 'holz',
          label: 'Holz Dachstuhl',
          id: 103,
        },
      ],
    },
  ],
  'flachdach': [
    {
      value: 'beheizt',
      label: 'Beheizt',
      children: [
        {
          value: 'massiv',
          label: 'Decke Massiv',
          id: 200,
        },
        {
          value: 'vollholz',
          label: 'Decke Vollholz',
          id: 201,
        },
      ],
    },
  ],
  'pultdach': [
    {
      value: 'beheizt',
      label: 'Beheizt',
      children: [
        {
          value: 'massiv',
          label: 'Decke Massiv',
          id: 300,
        },
        {
          value: 'vollholz',
          label: 'Decke Vollholz',
          id: 301,
        },
      ],
    },
  ],
};

const props = {
  expandTrigger: 'hover',
};

const handleChange = () => console.log('changed');

const roofForms = [
  {
    id: 1,
    title: 'Satteldach',
    description: 'Inklusive (Krüppel-)Walmdach, Mansardendach & Zeltdach',
    image: '/satteldach.svg',
  },
  {
    id: 2,
    title: 'Flachdach',
    description: 'Auch für andere Dachformen mit Kaltdach geeignet.',
    image: '/flachdach.svg',
  },
  {
    id: 3,
    title: 'Pultdach',
    description: 'Gängig bei Bürogebäuden, Industrie- und Gewerbebauten.',
    image: '/pultdach.svg',
  },
];

const form = useForm({
  u_wert: null,
  beheizt: null,
  dachform: null,
  daemmung: null,
  bauweise: null,
  kniestock: null,
  dachneigung: null,
  zwischendecke: null,
  gedachdaemmung: null,
  ...roof
});

</script>

<template>
  <form-header subtitle='Angaben zum Dachaufbau' title='Dach' />
  <el-card :body-style="{ padding: '0px' }">
    <template #header>
      <div class='flex justify-between items-center'>
        <div><span class='text-blue-600 font-semibold'>Dach</span>
          <span> | </span>
          <span class='text-sm'>Eingabe</span>
        </div>
      </div>
    </template>

    <div class='flex p-4'>

      <RadioGroup v-model='form.bauweise' class='w-full'>
        <div class='grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4'>

          <RadioGroupOption
            v-for='roof in roofForms'
            :key='roof.id'
            v-slot='{ checked, active }'
            :value='roof'
            as='template'>
            <div
              :class="[checked ? 'border-transparent'
                                  : 'border-gray-300',
                              active
                                  ? 'border-blue-500 ring-2 ring-blue-500'
                                  : '',
                              'relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none',
                          ]">
              <span class='flex flex-1'>
                <span class='flex flex-col'>
                  <RadioGroupLabel
                    as='span'
                    class='block text-sm font-medium text-gray-900'>
                    {{ roof.title }}
                  </RadioGroupLabel>
                  <RadioGroupDescription
                    as='span'
                    class='mt-1 flex items-center text-xs text-gray-500'>
                    {{ roof.description }}
                  </RadioGroupDescription>
                  <RadioGroupDescription
                    as='div'
                    class='mt-6 flex text-sm font-medium text-gray-900'>
                    <img :alt='roof.title' :src='roof.image' class='h-8 w-8' />
                  </RadioGroupDescription>
                </span>
              </span>
              <CheckCircleIcon
                :class="[!checked ? 'invisible' : '','h-5 w-5 text-blue-600']"
                aria-hidden='true' />
              <span
                :class="[active ? 'border' : 'border-2',
                  checked ? 'border-blue-500'
                          : 'border-transparent',
                      'pointer-events-none absolute -inset-px rounded-lg',
                  ]"
                aria-hidden='true' />
            </div>
          </RadioGroupOption>
        </div>
      </RadioGroup>
    </div>

    <template v-if='form.bauweise'>

      <!--   Homemade divider   -->
      <div class='border-t border-gray-300 flex mb-5'></div>

      <el-form class='grid sm:grid-cols-2 gap-4 px-4' label-position='top' size='large'>

        <el-form-item label='Dachstock' required>
          <el-cascader
            v-model='value'
            :options='options[form.bauweise.title.toLowerCase()]'
            :props='props'
            class='w-full'
            placeholder='Bitte wählen Sie eine Option aus'
            @change='handleChange'
          />
        </el-form-item>

      </el-form>


      <satteldach-warm-form v-if='value.join(".") === "beheizt.holz"' />


    </template>

    <!--    <flachdach-form v-else />-->


    <div id='roof-button-container' class='w-full flex justify-end p-5 border-t border-gray-200'>

    </div>
  </el-card>
</template>

<style scoped>
.el-input-number {
  width: 100%;
}
</style>
