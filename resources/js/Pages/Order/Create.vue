<script setup>
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import OrderBaseData from '../../Components/OrderBaseData.vue';
import { computed } from 'vue';

const props = defineProps(['category'])

const certificate = computed(() => {
  switch (props.category) {
    case 'bdrf':
      return 'Bedarfsausweis'
    case 'vrbr':
      return 'Verbrauchsausweis'
    default:
      return 'Energieausweis'
  }
})

</script>

<template>
  <guest-layout>
    <stepper-wrapper>
      <div class='flex flex-col items-center'>
        <h2
          class='text-3xl font-bold tracking-tight text-center text-gray-800 sm:text-3xl'>
          {{ certificate }} erstellen
        </h2>
        <span
          class='mt-1 inline-flex items-center rounded-md bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-800'
        >Energieausweis</span>
        <p class='mt-10 text-lg leading-6 text-center text-gray-600'>
          Erstellen Sie mit unserem
          <span class='font-semibold'>innovativen</span> und
          technologisch führenden Service Ihren Bedarfsausweis
          bequem online. Nutzen Sie dabei die Möglichkeit, den
          Bearbeitungsstatus zu
          <span class='font-semibold'>pausieren</span> und nach
          Abschluss jederzeit zu verfolgen.
        </p>
      </div>

      <Suspense>
        <order-base-data :category='category' />
      </Suspense>

    </stepper-wrapper>
  </guest-layout>
</template>
