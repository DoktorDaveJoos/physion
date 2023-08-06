<script setup>
import SideNavStepper from '../Components/SideNavStepper.vue';
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';

const mapper = {
    bdrf: 'Bedarfsausweis',
    vrbr: 'Verbrauchsausweis',
};
</script>

<template>
    <div class="mb-10">
        <div>
            <nav class="sm:hidden" aria-label="Back">
                <Link
                    :href="route('hub.certificates')"
                    class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700">
                    <ChevronLeftIcon
                        class="-ml-1 mr-1 h-5 w-5 flex-shrink-0 text-gray-400"
                        aria-hidden="true" />
                    Back
                </Link>
            </nav>
            <nav class="hidden sm:flex" aria-label="Breadcrumb">
                <ol role="list" class="flex items-center space-x-4">
                    <li>
                        <div class="flex items-center">
                            <Link
                                :href="route('hub.certificates')"
                                class="text-sm font-medium text-gray-500 hover:text-gray-700"
                                >Bestellungen</Link
                            >
                        </div>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <ChevronRightIcon
                                class="h-5 w-5 flex-shrink-0 text-gray-400"
                                aria-hidden="true" />
                            <a
                                href="#"
                                aria-current="page"
                                class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700"
                                >Erstelle {{ mapper[$page.props.category] }}</a
                            >
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="flex justify-center">
        <div
            id="stepper-container"
            class="w-full md:grid md:grid-cols-11 gap-10">
            <side-nav-stepper class="md:col-span-2" />
            <div class="md:col-span-7 bg-white rounded-lg shadow p-6">
                <slot />
            </div>
            <div id="infobox" class="md:col-span-2">
                <!--    Container for Teleport    -->
            </div>
        </div>
    </div>
</template>
