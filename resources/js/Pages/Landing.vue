<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import {
    CheckIcon,
    RocketLaunchIcon,
    FireIcon,
    CalculatorIcon,
    CursorArrowRaysIcon,
} from '@heroicons/vue/24/outline';
import Features from '../Components/Features.vue';
import Prices from '../Components/Prices.vue';
import { ref } from 'vue';
import EnergieausweisCheck from '../Components/EnergieausweisCheck.vue';
import { InertiaLink } from '@inertiajs/inertia-vue3';
import Blog from '../Components/Blog.vue';
import Faq from '../Components/Faq.vue';

const checkTool = ref(false);
</script>

<template>
    <GuestLayout>
        <el-dialog v-model="checkTool" title="Energieausweis Check">
            <EnergieausweisCheck @close="() => (checkTool = false)" />
        </el-dialog>

        <div class="flex justify-center relative">
            <img
                src="/modern-sustainable.svg"
                alt="sustainable-modern-abstract"
                style="z-index: -9999"
                class="absolute overflow-x-hidden opacity-30 right-0 top-0 h-[60rem] -mt-40 -mr-40 w-auto" />

            <div class="mx-auto relative max-w-7xl sm:px-6 lg:px-8">
                <div class="flex justify-center">
                    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                        <div
                            class="py-12 md:py-20 lg:py-28 items-center sm:overflow-hidden">
                            <div class="relative px-6 lg:px-8">
                                <h1
                                    class="text-center text-4xl font-bold tracking-tight sm:text-5xl lg:text-6xl">
                                    <span class="block text-black"
                                        >Energieeffizienz von A-Z</span
                                    >
                                    <span class="block text-blue-600"
                                        >mit bauzertifikate.de</span
                                    >
                                </h1>
                                <p
                                    class="mx-auto mt-6 max-w-lg text-center text-xl text-slate-700 sm:max-w-3xl">
                                    Wir bei bauzertifikate.de sind Ihr
                                    Ansprechpartner für alle Fragen rund um
                                    Energieeffizienz und nachhaltiges Bauen und
                                    deren Nachweise.
                                </p>
                            </div>
                            <div class="flex justify-center my-16">
                                <div class="inline-flex rounded-md shadow">
                                    <InertiaLink
                                        href="#prices"
                                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-5 py-3 text-base font-medium text-white hover:bg-blue-700">
                                        Jetzt loslegen!
                                    </InertiaLink>
                                </div>
                                <div class="ml-3 inline-flex">
                                    <InertiaLink
                                        href="#features"
                                        class="inline-flex items-center justify-center rounded-md border border-transparent bg-blue-100 px-5 py-3 text-base font-medium text-blue-700 hover:bg-blue-200">
                                        Mehr erfahren
                                    </InertiaLink>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-2">
                                <div class="flex justify-center">
                                    <CursorArrowRaysIcon
                                        class="h-6 w-6 text-gray-500" />
                                </div>
                                <div class="flex justify-center">
                                    <a
                                        @click="checkTool = true"
                                        type="button"
                                        class="bg-slate-100 w-full max-w-sm flex items-center rounded-lg px-4 py-1 hover:bg-slate-200 cursor-pointer">
                                        <RocketLaunchIcon
                                            class="h-6 w-6 mx-1 text-gray-900"
                                            aria-hidden="true" />
                                        <div class="block ml-4">
                                            <p
                                                class="text-sm font-medium text-gray-900">
                                                Energieausweis
                                            </p>
                                            <p class="text-sm text-gray-800">
                                                Welchen Energieausweis brauche
                                                ich?
                                            </p>
                                        </div>
                                    </a>
                                </div>

                                <div class="flex justify-center">
                                    <InertiaLink
                                        :href="
                                            route('order.create', {
                                                category: 'vrbr',
                                            })
                                        "
                                        class="bg-slate-100 w-full max-w-sm flex items-center rounded-lg px-4 py-1 hover:bg-slate-200 cursor-pointer">
                                        <FireIcon
                                            class="h-6 w-6 mx-1 text-gray-900"
                                            aria-hidden="true" />
                                        <div class="block ml-4">
                                            <p
                                                class="text-sm font-medium text-gray-900">
                                                Verbrauchsausweis
                                            </p>
                                            <p class="text-sm text-gray-800">
                                                Jetzt Verbrauchsausweis
                                                erstellen
                                            </p>
                                        </div>
                                    </InertiaLink>
                                </div>

                                <div class="flex justify-center">
                                    <InertiaLink
                                        :href="
                                            route('order.create', {
                                                category: 'bdrf',
                                            })
                                        "
                                        class="bg-slate-100 w-full max-w-sm flex items-center rounded-lg px-4 py-1 hover:bg-slate-200 cursor-pointer">
                                        <CalculatorIcon
                                            class="h-6 w-6 mx-1 text-gray-900"
                                            aria-hidden="true" />
                                        <div class="block ml-4">
                                            <p
                                                class="text-sm font-medium text-gray-900">
                                                Energieausweis
                                            </p>
                                            <p class="text-sm text-gray-800">
                                                Jetzt Bedarfsausweis erstellen
                                            </p>
                                        </div>
                                    </InertiaLink>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <Features />
        <Prices />
        <Blog />
        <Faq />
    </GuestLayout>
</template>
