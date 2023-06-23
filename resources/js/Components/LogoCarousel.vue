<template>
    <el-carousel :interval="5000" arrow="never" type="card" height="150px">
        <el-carousel-item v-for="item in brandLogos" :key="item">
            <img class="h-16" :src="item.imgSrc" :alt="item.alt" />
        </el-carousel-item>
    </el-carousel>
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
];
</script>

<style>
.el-carousel__item {
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 10px;
}
</style>
