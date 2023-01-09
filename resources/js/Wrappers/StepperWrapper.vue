<template>
    <div class="flex justify-center p-4 sm:p-0">
        <div class="max-w-[90rem] md:grid md:grid-cols-11 gap-10 sm:px-6 lg:px-8">
            <Stepper class="md:col-span-2" />
            <div class="md:col-span-7 pt-12">
                <slot />
            </div>
            <div class="md:col-span-2 pt-12">
                <div class="flex flex-col bg-slate-50 rounded p-4">
                   Infobox
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Stepper from '@/Components/Stepper.vue';

</script>




