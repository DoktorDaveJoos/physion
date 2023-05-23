<script setup>
import StepperWrapper from '../../../Wrappers/StepperWrapper.vue';
import GuestLayout from '../../../Layouts/GuestLayout.vue';
import OrderBaseData from '../../../Components/OrderBaseData.vue';
import InformationBox from '../../../Components/InformationBox.vue';
import Badge from '../../../Components/Badge.vue';
import { ClipboardIcon } from '@heroicons/vue/24/outline';
import { ElMessage } from 'element-plus';
import { computed } from 'vue';

const props = defineProps({
  order: {
    type: Object,
  },
});

const copyId = () => {
  navigator.clipboard.writeText(props.order.id);
  ElMessage({ message: 'Kopiert', type: 'success' });
};

const saferEmailAddress = computed(() => {
  const email = props.order.customer.email;
  const [first, last] = email.split('@');
  const firstPart = first.slice(0, 2);
  const lastPart = first.slice(-2);
  const middlePart = first.slice(2, -2).replace(/./g, '*');
  return `${firstPart}${middlePart}${lastPart}@${last}`;
});

</script>

<template>
  <guest-layout>
    <stepper-wrapper>
      <information-box to='#infobox'>
        <div class='flex flex-col'>
          <span class='text-gray-500 text-xs mb-1'>Ihre Bestellnummer</span>
          <Badge :dot='true' :label='order.slug'>
            <template #append>
              <button class='flex items-center group' @click='copyId'>
                <span class='text-xs text-blue-600 font-light mr-0.5 group-hover:text-blue-800'>copy</span>
                <ClipboardIcon class='h-4 w-4 text-blue-600 group-hover:text-blue-800' />
              </button>
            </template>
          </Badge>
          <p class='text-xs text-gray-500 mt-2'>Mit der vorliegenden Bestellnummer haben Sie jederzeit die Möglichkeit,
            Ihren Ausweis wiederzufinden, die Bestellung abzuschließen oder nach Abschluss den Ausweis
            herunterzuladen.</p>
          <p class='text-xs text-gray-500 mt-2'>Bitte beachten Sie, dass die Bestellnummer auch per Email an die von
            Ihnen angegebene Adresse: {{ saferEmailAddress }} gesendet
            wurde.</p>
        </div>
      </information-box>
      <Suspense>
        <order-base-data :order='order' />
      </Suspense>
    </stepper-wrapper>
  </guest-layout>
</template>
