<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BuildingShowWrapper from './Shared/BuildingShowWrapper.vue';
import BzCard from '../../Components/BzCard.vue';
import BzDropzone from '../../../../Components/BzDropzone.vue';
import BzButton from '../../../../Components/BzButton.vue';
import {
    ArrowDownTrayIcon,
    XMarkIcon,
    PaperClipIcon,
    TrashIcon,
    CheckIcon,
} from '@heroicons/vue/24/outline';
import { InformationCircleIcon } from '@heroicons/vue/20/solid';
import { computed, ref } from 'vue';
import dayjs from 'dayjs';

const props = defineProps({
    building: Object,
});
</script>

<template>
    <Head>
        <title>Wertgutachten</title>
    </Head>

    <building-show-wrapper :building="building" sub-tabs-products-active>
        <el-empty description="Noch nicht Verfügbar" />
    </building-show-wrapper>
</template>
