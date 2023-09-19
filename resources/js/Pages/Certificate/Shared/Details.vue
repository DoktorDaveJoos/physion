<script setup>
import BuildingDetail from '../../../Components/BuildingDetail.vue';
import PageWrapper from '../../../Wrappers/PageWrapper.vue';

defineProps({
    order: {
        type: Object,
    },
});
</script>

<template>
    <page-wrapper>
        <building-detail :order="order" />
    </page-wrapper>
</template>
