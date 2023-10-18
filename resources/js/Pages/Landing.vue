<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {
    RocketLaunchIcon,
    FireIcon,
    CalculatorIcon,
    CursorArrowRaysIcon,
    PresentationChartLineIcon,
} from '@heroicons/vue/24/outline';
import Features from '../Components/Features.vue';
import Prices from '../Components/Prices.vue';
import { ref } from 'vue';
import EnergieausweisCheck from '../Components/EnergieausweisCheck.vue';

import { Link, Head } from '@inertiajs/vue3';
import Faq from '../Components/Faq.vue';
import LogoCarousel from '../Components/LogoCarousel.vue';

// const checkTool = ref(false);
</script>

<template>
    <GuestLayout>
        <Head>
            <title>Startseite</title>
        </Head>

        <div class="w-full">
            <div class="grid grid-cols-2">
                <div class="flex flex-col items-center justify-center">
                    <span class="text-primary text-lg">
                        bauzertifikate.de
                    </span>
                </div>
                <div class="min-h-screen bg-primary w-full" />
            </div>
        </div>
    </GuestLayout>
</template>
