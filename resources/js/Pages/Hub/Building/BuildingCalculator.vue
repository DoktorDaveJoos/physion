<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BuildingShowWrapper from './Show/BuildingShowWrapper.vue';
import BzCard from '../Components/BzCard.vue';
import BzDropzone from '../../../Components/BzDropzone.vue';
import BzButton from '../../../Components/BzButton.vue';
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
        <title>Förderung & Zuschuss</title>
    </Head>

    <building-show-wrapper :building="building">
        <bz-card>
            <template #title>KFW</template>
            <template #subtitle>Mögliche Förderkredite der KFW Bank</template>
            <template #content>
                <div class="px-6 py-4">test</div>
            </template>
        </bz-card>
    </building-show-wrapper>
</template>
