<script setup>
import {
    Popover,
    PopoverButton,
    PopoverGroup,
    PopoverPanel,
} from '@headlessui/vue';
import {
    Bars3Icon,
    CalculatorIcon,
    CurrencyEuroIcon,
    DocumentChartBarIcon,
    FireIcon,
    LightBulbIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import { ChevronDownIcon } from '@heroicons/vue/20/solid';
import ApplicationMark from '../../Jetstream/ApplicationMark.vue';
import NavLink from '../../Jetstream/NavLink.vue';
import { Link, router } from '@inertiajs/vue3';
import DropdownLink from '../../Jetstream/DropdownLink.vue';
import Dropdown from '../../Jetstream/Dropdown.vue';
import FlyOut from './FlyOut.vue';

defineProps({
    showMenu: {
        type: Boolean,
        required: true,
    },
});

const products = [
    [
        {
            name: 'Verbrauchsausweis',
            description:
                'Energieausweis, der die Energieeffizienz eines Gebäudes über den Energieverbrauch ermittelt.',
            href: route('order.create', 'vrbr'),
            icon: FireIcon,
            theme: 'bg-sky-500',
            active: true,
            availableFrom: null,
        },
        {
            name: 'Bedarfsausweis',
            description:
                'Energieausweis, der die Energieeffizienz eines Gebäudes rechnerisch ermittelt.',
            href: route('order.create', 'bdrf'),
            icon: CalculatorIcon,
            theme: 'bg-sky-500',
            active: true,
        },
    ],
    [
        {
            name: 'QNG Zertifikat',
            description:
                'Bescheinigung über die Einhaltung von Niedrigenergiehaus-Anforderungen.',
            href: '#',
            icon: DocumentChartBarIcon,
            theme: 'bg-teal-500',
            active: false,
            availableFrom: 'November 2023',
        },
    ],
    [
        {
            name: 'Effiziente Energienutzung',
            description:
                'Der Ratgeber für Energieausweis, BIRN Zertifikat und Einsparmöglichkeiten',
            href: '#',
            icon: LightBulbIcon,
            theme: 'bg-violet-500',
            active: false,
            availableFrom: 'Ende 2023',
        },
        {
            name: 'Förderung A-Z',
            description:
                'Der Leitfaden zum Energie sparen und Förderungen sichern!',
            href: '#',
            icon: CurrencyEuroIcon,
            theme: 'bg-violet-500',
            active: false,
            availableFrom: 'Demnächst',
        },
    ],
];
const resources = [
    {
        name: 'Find my Energieausweis',
        description:
            'Link verloren? Finden Sie Ihren Energieausweis mit Ihrer E-Mail Adresse und der Postleitzahl.',
        href: route('find.show'),
    },
    {
        name: 'Kontakt',
        description: 'Sie haben ein unlösbares Problem - melden Sie sich.',
        href: route('contact.show'),
    },
];

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <Popover class="relative bg-white z-20 sticky top-0">
        <div
            class="flex border-b border-gray-200 shadow-sm items-center justify-between px-4 py-6 sm:px-6 md:justify-start md:space-x-10">
            <div class="flex justify-start">
                <NavLink href="/">
                    <ApplicationMark />
                    <div class="ml-1 hidden lg:flex items-baseline">
                        <span
                            class="text-lg tracking-tight font-light text-gray-800">
                            bauzertifikate
                        </span>
                        <span
                            class="hidden text-lg text-blue-600 font-semibold md:block">
                            .de
                        </span>
                    </div>
                </NavLink>
            </div>
            <div class="-my-2 -mr-2 md:hidden">
                <PopoverButton
                    class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                    <span class="sr-only">Open menu</span>
                    <Bars3Icon class="h-6 w-6" aria-hidden="true" />
                </PopoverButton>
            </div>
            <PopoverGroup
                v-if="showMenu"
                as="nav"
                class="hidden md:flex flex-1 justify-center">
                <div class="flex items-center space-x-10">
                    <fly-out title="Produkte" :items="products" />

                    <a
                        :href="route('blog.show')"
                        class="text-base px-2 font-medium text-gray-500 hover:text-gray-900"
                        >Blog
                    </a>
                    <Link
                        :href="route('about')"
                        class="text-base font-medium px-2 text-gray-500 hover:text-gray-900">
                        Über uns
                    </Link>
                    <Link
                        :href="route('start') + '#faq'"
                        class="text-base font-medium px-2 text-gray-500 hover:text-gray-900"
                        >FAQ
                    </Link>

                    <Popover class="relative" v-slot="{ open }">
                        <PopoverButton
                            :class="[
                                open
                                    ? 'text-gray-900 bg-blue-50'
                                    : 'text-gray-500',
                                'group inline-flex items-center px-2 rounded-md bg-white text-base font-medium hover:text-gray-900 focus:outline-none',
                            ]">
                            <span>Mehr</span>
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
                                class="absolute left-1/2 z-10 mt-3 w-screen max-w-xs -translate-x-1/2 transform px-2 sm:px-0">
                                <div
                                    class="overflow-hidden rounded-lg shadow-lg ring-1 ring-black ring-opacity-5">
                                    <div
                                        class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                        <Link
                                            v-for="resource in resources"
                                            :key="resource.name"
                                            :href="resource.href"
                                            class="-m-3 block rounded-md p-3 hover:bg-gray-50">
                                            <p
                                                class="text-base font-medium text-gray-900">
                                                {{ resource.name }}
                                            </p>
                                            <p
                                                class="mt-1 text-sm text-gray-500">
                                                {{ resource.description }}
                                            </p>
                                        </Link>
                                    </div>
                                </div>
                            </PopoverPanel>
                        </transition>
                    </Popover>

                    <Link
                        :href="route('business-partner')"
                        class="text-base font-medium px-6 text-blue-500 hover:text-blue-900"
                        >Partner werden
                    </Link>
                </div>
            </PopoverGroup>
            <template v-if="!$page.props.user">
                <div
                    v-if="showMenu"
                    class="hidden items-center justify-end md:flex">
                    <Link
                        :href="route('login')"
                        class="text-sm font-light underline text-gray-500 hover:text-gray-900"
                        >EnergieHub Anmeldung
                    </Link>
                </div>
            </template>
            <template v-else>
                <Dropdown align="right" width="48">
                    <template #trigger>
                        <button
                            v-if="$page.props.jetstream.managesProfilePhotos"
                            class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            <img
                                class="h-8 w-8 rounded-full object-cover"
                                :src="$page.props.user.profile_photo_url"
                                :alt="$page.props.user.first_name" />
                        </button>

                        <span v-else class="inline-flex rounded-md">
                            <button
                                type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                {{ $page.props.user.first_name }}

                                <ChevronDownIcon class="ml-2 h-4 w-4" />
                            </button>
                        </span>
                    </template>

                    <template #content>
                        <!-- Account Management -->
                        <div class="block px-4 py-2 text-xs text-gray-400">
                            Manage Account
                        </div>

                        <DropdownLink :href="route('profile.show')">
                            Profile
                        </DropdownLink>

                        <DropdownLink
                            v-if="$page.props.jetstream.hasApiFeatures"
                            :href="route('api-tokens.index')">
                            API Tokens
                        </DropdownLink>

                        <div class="border-t border-gray-100" />

                        <!-- Authentication -->
                        <form @submit.prevent="logout">
                            <DropdownLink as="button"> Log Out </DropdownLink>
                        </form>
                    </template>
                </Dropdown>
            </template>
            <transition
                enter-active-class="duration-200 ease-out"
                enter-from-class="opacity-0 scale-95"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="duration-100 ease-in"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-95">
                <!-- Mobile -->
                <PopoverPanel
                    focus
                    class="absolute inset-x-0 top-0 origin-top-right transform p-2 transition md:hidden">
                    <div
                        class="divide-y-2 divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                        <div class="px-5 pt-5 pb-6">
                            <div class="flex items-center justify-between">
                                <div>
                                    <ApplicationMark />
                                </div>
                                <div class="-mr-2">
                                    <PopoverButton
                                        class="inline-flex items-center justify-center rounded-md bg-white p-2 text-gray-400 hover:bg-gray-100 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500">
                                        <span class="sr-only">Close menu</span>
                                        <XMarkIcon
                                            class="h-6 w-6"
                                            aria-hidden="true" />
                                    </PopoverButton>
                                </div>
                            </div>
                        </div>
                        <div class="py-6 px-5">
                            <div class="grid grid-cols-2 gap-6">
                                <a
                                    :href="route('blog.show')"
                                    class="text-base px-2 font-medium text-gray-500 hover:text-gray-900"
                                    >Blog
                                </a>
                                <Link
                                    :href="route('about')"
                                    class="text-base font-medium px-2 text-gray-500 hover:text-gray-900">
                                    Über uns
                                </Link>
                                <Link
                                    :href="route('start') + '#faq'"
                                    class="text-base font-medium px-2 text-gray-500 hover:text-gray-900"
                                    >FAQ
                                </Link>
                                <Link
                                    :href="route('contact.show')"
                                    class="text-base font-medium px-2 text-gray-500 hover:text-gray-900"
                                    >Kontakt
                                </Link>
                                <Link
                                    :href="route('find.show')"
                                    class="text-base font-medium px-2 text-gray-500 hover:text-gray-900"
                                    >Find my
                                </Link>
                                <Link
                                    :href="route('energiehub')"
                                    class="text-base font-medium px-2 text-gray-500 hover:text-gray-900"
                                    >EnergieHub
                                </Link>
                            </div>
                        </div>

                        <template v-for="category in products">
                            <div
                                class="p-1 py-4"
                                v-if="
                                    category.filter((product) => product.active)
                                        .length > 0
                                ">
                                <template v-for="product in category">
                                    <div
                                        class="p-2 space-y-1"
                                        v-if="product.active">
                                        <Link
                                            :href="product.href"
                                            class="rounded-md bg-slate-100 p-2 flex items-center">
                                            <div
                                                class="h-10 w-10 rounded-md mr-4 flex justify-center items-center"
                                                :class="product.theme">
                                                <component
                                                    :is="product.icon"
                                                    class="w-6 h-6 text-white" />
                                            </div>
                                            <span
                                                class="text-sm leading-tight text-gray-500 font-semibold"
                                                >{{ product.name }}</span
                                            >
                                        </Link>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </PopoverPanel>
            </transition>
        </div>
    </Popover>
</template>
