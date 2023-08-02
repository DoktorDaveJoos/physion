<script setup>
import BlinkingWrapper from './Components/BlinkingWrapper.vue';

defineProps({
    result: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <blinking-wrapper>
        <div
            class="bg-white py-16 px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
            <div class="mx-auto max-w-lg lg:max-w-none">
                <div><h1 class="font-bold">Erledigt!</h1></div>
                <p class="mt-6">
                    Wir haben dir eine E-Mail mit dem Link zum Auftrag
                    zugeschickt.
                </p>
            </div>
        </div>
    </blinking-wrapper>
</template>
