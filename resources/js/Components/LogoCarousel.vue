<template>
    <!--    <el-carousel :interval="5000" arrow="never" type="card" height="150px">-->
    <!--        <el-carousel-item v-for="item in brandLogos" :key="item">-->
    <!--            <img class="h-16" :src="item.imgSrc" :alt="item.alt" />-->
    <!--        </el-carousel-item>-->
    <!--    </el-carousel>-->
    <div class="bg-white py-24 sm:py-10">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <!--            <h2-->
            <!--                class="text-center text-lg font-semibold leading-8 text-gray-900">-->
            <!--                Unsere Zertifikate -->
            <!--            </h2>-->
            <div
                class="mx-auto grid max-w-lg grid-cols-4 items-center gap-x-8 gap-y-10 sm:max-w-xl sm:grid-cols-6 sm:gap-x-10 lg:mx-0 lg:max-w-none lg:grid-cols-6">
                <img
                    v-for="logo in brandLogos"
                    :key="logo.alt"
                    class="col-span-4 sm:col-span-2 max-h-12 w-full object-contain lg:col-span-1"
                    :src="logo.imgSrc"
                    :alt="logo.alt"
                    width="158"
                    height="48" />
            </div>
        </div>
    </div>
</template>

<script setup>
const brandLogos = [
    {
        imgSrc: '/logos/sanierungsfahrplan-logo.jpeg',
        alt: 'Sanierungsfahrplan Logo',
    },
    {
        imgSrc: '/logos/eee-logo.jpeg',
        alt: 'Energieeffizienzhaus Logo',
    },
    {
        imgSrc: '/logos/kfw-logo.svg',
        alt: 'KFW Logo',
    },
    {
        imgSrc: '/logos/bafa-logo.webp',
        alt: 'Bafa Logo',
    },
    {
        imgSrc: '/logos/kfw-eh-logo.gif',
        alt: 'KFW Energiehaus Logo',
    },
    {
        imgSrc: '/logos/qng-logo.jpeg',
        alt: 'QNQ Logo',
    },
];
</script>
