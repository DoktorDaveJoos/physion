<script setup>
import { Popover, PopoverButton, PopoverPanel } from '@headlessui/vue';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import { Link } from '@inertiajs/vue3';

defineProps({
    title: String,
    items: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Popover class="relative" v-slot="{ open }">
        <PopoverButton
            :class="[
                open ? 'text-gray-900 bg-blue-50' : 'text-gray-500',
                'group inline-flex items-center px-2 rounded-md bg-white text-base font-medium hover:text-gray-900 focus:outline-none',
            ]">
            <span>{{ title }}</span>
            <ChevronDownIcon
                :class="[
                    open ? 'text-gray-600' : 'text-gray-400',
                    'ml-2 h-5 w-5 group-hover:text-gray-500',
                ]"
                aria-hidden="true" />
        </PopoverButton>

        <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 translate-y-1"
            enter-to-class="opacity-100 translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 translate-y-0"
            leave-to-class="opacity-0 translate-y-1">
            <PopoverPanel
                class="absolute z-10 -ml-4 mt-3 w-screen max-w-md transform lg:left-1/2 lg:ml-0 lg:max-w-3xl lg:-translate-x-1/2">
                <div
                    class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                    <div class="relative bg-white flex flex-col px-3 divide-y">
                        <div
                            v-for="(category, idx) in items"
                            :key="idx"
                            class="lg:col-span-2 grid gap-6 lg:grid-cols-2 divide border-gray-100">
                            <template v-for="solution in category">
                                <template v-if="solution.active">
                                    <Link
                                        :key="solution.name"
                                        :href="solution.href"
                                        class="flex items-start p-3 my-3 rounded-lg hover:bg-gray-50">
                                        <div
                                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-md text-white sm:h-12 sm:w-12"
                                            :class="solution.theme">
                                            <component
                                                :is="solution.icon"
                                                class="h-6 w-6"
                                                aria-hidden="true" />
                                        </div>
                                        <div class="ml-4">
                                            <p
                                                class="text-base font-medium text-gray-900">
                                                {{ solution.name }}
                                            </p>
                                            <p
                                                class="mt-1 text-sm text-gray-500">
                                                {{ solution.description }}
                                            </p>
                                        </div>
                                    </Link>
                                </template>
                                <template v-else>
                                    <div
                                        class="flex items-start p-3 my-3 rounded-lg hover:bg-gray-50 opacity-40 cursor-not-allowed">
                                        <div
                                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-md text-white sm:h-12 sm:w-12"
                                            :class="solution.theme">
                                            <component
                                                :is="solution.icon"
                                                class="h-6 w-6"
                                                aria-hidden="true" />
                                        </div>
                                        <div class="ml-4">
                                            <p
                                                class="text-base font-medium text-gray-900">
                                                {{ solution.name }}
                                            </p>
                                            <p
                                                class="mt-1 text-sm text-gray-500">
                                                {{ solution.description }}
                                            </p>
                                            <span class="text-xs">
                                                Verfügbar ab
                                                {{ solution.availableFrom }}
                                            </span>
                                        </div>
                                    </div>
                                </template>
                            </template>
                        </div>
                    </div>
                    <div class="bg-gray-50 p-5 sm:p-8">
                        <Link
                            :href="route('energiehub')"
                            class="-m-3 flow-root rounded-md p-3 hover:bg-gray-100">
                            <div class="flex items-center">
                                <div
                                    class="text-base font-medium text-gray-900">
                                    EnergieHub
                                </div>
                                <span
                                    class="ml-3 inline-flex items-center rounded-full bg-indigo-100 px-3 py-0.5 text-xs font-medium leading-5 text-indigo-800"
                                    >Demnächst Verfügbar</span
                                >
                            </div>
                            <p class="mt-1 text-sm text-gray-500">
                                Optimieren Sie den Energiebedarf und -verbrauch
                                von Gebäuden mit unserer leistungsstarken
                                Energieberater Software und sparen Sie Energie
                                und Geld.
                            </p>
                        </Link>
                    </div>
                </div>
            </PopoverPanel>
        </transition>
    </Popover>
</template>
