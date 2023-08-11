<script setup>
import { computed } from 'vue';
import SidebarLayout from '../../../../Layouts/SidebarLayout.vue';
import OrderBaseDataHub from '../../../../Components/OrderBaseDataHub.vue';
import StepperWrapperHub from '../../../../Wrappers/StepperWrapperHub.vue';
import PageWrapper from '../../../../Wrappers/PageWrapper.vue';

const props = defineProps(['category']);

const certificate = computed(() => {
    switch (props.category) {
        case 'bdrf':
            return 'Bedarfsausweis';
        case 'vrbr':
            return 'Verbrauchsausweis';
        default:
            return 'Energieausweis';
    }
});
</script>

<template>
    <page-wrapper>
        <Suspense>
            <order-base-data-hub :category="category" />
        </Suspense>
    </page-wrapper>
</template>
