<script setup>
import {Popover, PopoverButton, PopoverGroup, PopoverPanel} from '@headlessui/vue';
import {
    Bars3Icon,
    CalculatorIcon,
    CurrencyEuroIcon,
    DocumentChartBarIcon,
    FireIcon,
    LightBulbIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import {ChevronDownIcon} from '@heroicons/vue/20/solid';
import NavLink from '../Jetstream/NavLink.vue';
import ApplicationMark from '../Jetstream/ApplicationMark.vue';
import DropdownLink from '../Jetstream/DropdownLink.vue';
import Dropdown from '../Jetstream/Dropdown.vue';
import {InertiaLink} from '@inertiajs/inertia-vue3';

const products = [
    [
        {
            name: 'Verbrauchsausweis',
            description: 'Energieausweis, der die Energieeffizienz eines Gebäudes über den Energieverbrauch ermittelt.',
            href: route('verbrauch.create'),
            icon: FireIcon,
            theme: 'bg-sky-500',
            active: true,
            availableFrom: null,
        },
        {
            name: 'Bedarfsausweis',
            description: 'Energieausweis, der die Energieeffizienz eines Gebäudes rechnerisch ermittelt.',
            href: route('bedarf.create'),
            icon: CalculatorIcon,
            theme: 'bg-sky-500',
            active: true,
            availableFrom: null,
        },
    ],
    [
        {
            name: 'BIRN Zertifikat',
            description: 'Bescheinigung über die Einhaltung von Niedrigenergiehaus-Anforderungen.',
            href: '#',
            icon: DocumentChartBarIcon,
            theme: 'bg-teal-500',
            active: false,
            availableFrom: '01.03.2023',
        },
    ],
    [
        {
            name: 'Effiziente Energienutzung',
            description: 'Der Ratgeber für Energieausweis, BIRN Zertifikat und Einsparmöglichkeiten',
            href: '#',
            icon: LightBulbIcon,
            theme: 'bg-violet-500',
            active: false,
            availableFrom: '01.02.2023',
        },
        {
            name: 'Förderung A-Z',
            description: 'Der Leitfaden zum Energie sparen und Förderungen sichern!',
            href: '#',
            icon: CurrencyEuroIcon,
            theme: 'bg-violet-500',
            active: false,
            availableFrom: '01.02.2023',
        },
    ],
];
const resources = [
    {
        name: 'Find my Energieausweis',
        description: 'Link verloren? Finden Sie Ihren Energieausweis mit Ihrer E-Mail Adresse und der Postleitzahl.',
        href: '#',
    },
    {name: 'Über Uns', description: 'Das Team hinter bauzertifikate.de - und was uns antreibt.', href: '#'},
    {name: 'Kontakt', description: 'Sie haben ein unlösbares Problem - melden Sie sich.', href: '#'},
];
</script>

<template>
        <Popover class="relative bg-white z-50 sticky top-0">
            <div class="flex border-b border-gray-100 shadow-sm items-center justify-between px-4 py-6 sm:px-6 md:justify-start md:space-x-10">
                <div class="flex justify-start">
                    <NavLink href="/">
                        <ApplicationMark />
                        <div class="ml-1 hidden lg:flex items-baseline">
                            <span class="text-lg tracking-tight font-light text-gray-800">
                                bauzertifikate
                            </span>
                            <span class="hidden text-lg text-blue-600 font-semibold md:block">
                                .de
                            </span>
                        </div>
                    </NavLink>
                </div>
                <div class="-my-2 -mr-2 md:hidden">
                    <PopoverButton
                        class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                        <span class="sr-only">Open menu</span>
                        <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                    </PopoverButton>
                </div>
                <PopoverGroup as="nav" class="hidden md:flex flex-1 justify-center">
                    <div class="flex items-center space-x-10">


                    <Popover class="relative" v-slot="{ open }">
                        <PopoverButton
                            :class="[open ? 'text-gray-900 bg-blue-50' : 'text-gray-500', 'group inline-flex items-center px-2 rounded-md bg-white text-base font-medium hover:text-gray-900 focus:outline-none']">
                            <span>Produkte</span>
                            <ChevronDownIcon
                                :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']"
                                aria-hidden="true" />
                        </PopoverButton>

                        <transition enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 translate-y-1"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 translate-y-1">
                            <PopoverPanel
                                class="absolute z-10 -ml-4 mt-3 w-screen max-w-md transform lg:left-1/2 lg:ml-0 lg:max-w-3xl lg:-translate-x-1/2">
                                <div class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                    <div class="relative bg-white flex flex-col px-3 divide-y">

                                        <div v-for="(category, idx) in products" :key="idx"
                                             class="lg:col-span-2 grid gap-6 lg:grid-cols-2 divide border-gray-100">
                                            <a v-for="solution in category" :key="solution.name" :href="solution.href"
                                               class="flex items-start p-3 my-3 rounded-lg hover:bg-gray-50"
                                               :class="!solution.active ? 'opacity-40 cursor-not-allowed' : ''">
                                                <div
                                                    class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-md text-white sm:h-12 sm:w-12"
                                                    :class="solution.theme">
                                                    <component :is="solution.icon" class="h-6 w-6" aria-hidden="true" />
                                                </div>
                                                <div class="ml-4">
                                                    <p class="text-base font-medium text-gray-900">{{
                                                            solution.name
                                                        }}</p>
                                                    <p class="mt-1 text-sm text-gray-500">{{ solution.description }}</p>
                                                    <span v-if="!solution.active" class="text-xs">
                                                        Verfügbar ab {{ solution.availableFrom }}
                                                    </span>
                                                </div>
                                            </a>
                                        </div>

                                    </div>
                                    <div class="bg-gray-50 p-5 sm:p-8">
                                        <a :href="route('login')" class="-m-3 flow-root rounded-md p-3 hover:bg-gray-100">
                                            <div class="flex items-center">
                                                <div class="text-base font-medium text-gray-900">EnergieHub</div>
                                                <span
                                                    class="ml-3 inline-flex items-center rounded-full bg-indigo-100 px-3 py-0.5 text-xs font-medium leading-5 text-indigo-800">Demnächst Verfügbar</span>
                                            </div>
                                            <p class="mt-1 text-sm text-gray-500">Optimieren Sie den Energiebedarf und
                                                -verbrauch von Gebäuden mit unserer leistungsstarken Energieberater
                                                Software und sparen Sie Energie und Geld.</p>
                                        </a>
                                    </div>
                                </div>
                            </PopoverPanel>
                        </transition>
                    </Popover>

                    <InertiaLink :href="route('blog.show')" class="text-base px-2 font-medium text-gray-500 hover:text-gray-900">Blog</InertiaLink>
                    <InertiaLink href="#" class="text-base font-medium px-2 text-gray-500 hover:text-gray-900">Docs</InertiaLink>
                    <InertiaLink href="#" class="text-base font-medium px-2 text-gray-500 hover:text-gray-900">FAQ</InertiaLink>

                    <Popover class="relative" v-slot="{ open }">
                        <PopoverButton
                            :class="[open ? 'text-gray-900 bg-blue-50' : 'text-gray-500', 'group inline-flex items-center px-2 rounded-md bg-white text-base font-medium hover:text-gray-900 focus:outline-none']">
                            <span>Mehr</span>
                            <ChevronDownIcon
                                :class="[open ? 'text-gray-600' : 'text-gray-400', 'ml-2 h-5 w-5 group-hover:text-gray-500']"
                                aria-hidden="true" />
                        </PopoverButton>

                        <transition enter-active-class="transition ease-out duration-200"
                                    enter-from-class="opacity-0 translate-y-1"
                                    enter-to-class="opacity-100 translate-y-0"
                                    leave-active-class="transition ease-in duration-150"
                                    leave-from-class="opacity-100 translate-y-0"
                                    leave-to-class="opacity-0 translate-y-1">
                            <PopoverPanel
                                class="absolute left-1/2 z-10 mt-3 w-screen max-w-xs -translate-x-1/2 transform px-2 sm:px-0">
                                <div class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                        <a v-for="resource in resources" :key="resource.name" :href="resource.href"
                                           class="-m-3 block rounded-md p-3 hover:bg-gray-50">
                                            <p class="text-base font-medium text-gray-900">{{ resource.name }}</p>
                                            <p class="mt-1 text-sm text-gray-500">{{ resource.description }}</p>
                                        </a>
                                    </div>
                                </div>
                            </PopoverPanel>
                        </transition>
                    </Popover>
            </div>
                </PopoverGroup>
                <div class="hidden items-center justify-end md:flex">
                    <InertiaLink href="{{ route('login') }}" class="text-xs font-light underline text-gray-500 hover:text-gray-900">EnergieHub Anmeldung</InertiaLink>
                </div>
            </div>

            <transition enter-active-class="duration-200 ease-out" enter-from-class="opacity-0 scale-95"
                        enter-to-class="opacity-100 scale-100" leave-active-class="duration-100 ease-in"
                        leave-from-class="opacity-100 scale-100" leave-to-class="opacity-0 scale-95">
                <PopoverPanel focus
                              class="absolute inset-x-0 top-0 origin-top-right transform p-2 transition md:hidden">
                    <div
                        class="divide-y-2 divide-gray-50 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <div class="px-5 pt-5 pb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <img class="h-8 w-auto"
                                         src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=600"
                                         alt="Your Company" />
                                </div>
                                <div class="-mr-2">
                                    <PopoverButton
                                        class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500">
                                        <span class="sr-only">Close menu</span>
                                        <XMarkIcon class="h-6 w-6" aria-hidden="true" />
                                    </PopoverButton>
                                </div>
                            </div>
                            <div class="mt-6">
                                <nav class="grid grid-cols-1 gap-7">
                                    <a v-for="solution in products" :key="solution.name" :href="solution.href"
                                       class="-m-3 flex items-center rounded-lg p-3 hover:bg-gray-50">
                                        <div
                                            class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-md bg-indigo-500 text-white">
                                            <component :is="solution.icon" class="h-6 w-6" aria-hidden="true" />
                                        </div>
                                        <div class="ml-4 text-base font-medium text-gray-900">{{ solution.name }}</div>
                                    </a>
                                </nav>
                            </div>
                        </div>
                        <div class="py-6 px-5">
                            <div class="grid grid-cols-2 gap-4">
                                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Pricing</a>

                                <a href="#" class="text-base font-medium text-gray-900 hover:text-gray-700">Docs</a>

                                <a href="#"
                                   class="text-base font-medium text-gray-900 hover:text-gray-700">Enterprise</a>
                                <a v-for="resource in resources" :key="resource.name" :href="resource.href"
                                   class="text-base font-medium text-gray-900 hover:text-gray-700">{{
                                        resource.name
                                    }}</a>
                            </div>
                            <div class="mt-6">
                                <div v-if="$page.props.user" class="hidden sm:ml-6 sm:flex sm:items-center">
                                    <!-- Settings Dropdown -->
                                    <div class="relative ml-3">
                                        <Dropdown align="right" width="48">
                                            <template #trigger>
                                                <button
                                                    v-if="$page.props.jetstream.managesProfilePhotos"
                                                    class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
                                                    <img
                                                        class="h-8 w-8 rounded-full object-cover"
                                                        :src="$page.props.user.profile_photo_url"
                                                        :alt="$page.props.user.name" />
                                                </button>

                                                <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition hover:text-gray-700 focus:outline-none">
                                                {{ $page.props.user.name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                                     viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                            </template>

                                            <template #content>
                                                <!-- Account Management -->
                                                <div class="block px-4 py-2 text-xs text-gray-400">Manage Account</div>

                                                <DropdownLink :href="route('profile.show')"> Profile</DropdownLink>

                                                <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                                              :href="route('api-tokens.index')"> API Tokens
                                                </DropdownLink>

                                                <div class="border-t border-gray-100" />

                                                <!-- Authentication -->
                                                <form @submit.prevent="logout">
                                                    <DropdownLink as="button"> Log Out</DropdownLink>
                                                </form>
                                            </template>
                                        </Dropdown>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </PopoverPanel>
            </transition>
        </Popover>
        <main class="bg-white pb-12 px-4">
            <slot />
        </main>
</template>
