<!--
  This example requires some changes to your config:

  ```
  // tailwind.config.js
  module.exports = {
    // ...
    plugins: [
      // ...
      require('@tailwindcss/forms'),
    ],
  }
  ```
-->
<template>
    <!--
      This example requires updating your template:

      ```
      <html class="h-full bg-white">
      <body class="h-full">
      ```
    -->

    <div class="bg-gray-50 h-screen w-full fixed -z-10"></div>

    <TransitionRoot :show="sidebarOpen" as="template">
        <Dialog
            as="div"
            class="relative z-50 lg:hidden"
            @close="sidebarOpen = false">
            <TransitionChild
                as="template"
                enter="transition-opacity ease-linear duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="transition-opacity ease-linear duration-300"
                leave-from="opacity-100"
                leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-900/80" />
            </TransitionChild>

            <div class="fixed inset-0 flex font-sans">
                <TransitionChild
                    as="template"
                    enter="transition ease-in-out duration-300 transform"
                    enter-from="-translate-x-full"
                    enter-to="translate-x-0"
                    leave="transition ease-in-out duration-300 transform"
                    leave-from="translate-x-0"
                    leave-to="-translate-x-full">
                    <DialogPanel
                        class="relative mr-16 flex w-full max-w-xs flex-1">
                        <TransitionChild
                            as="template"
                            enter="ease-in-out duration-300"
                            enter-from="opacity-0"
                            enter-to="opacity-100"
                            leave="ease-in-out duration-300"
                            leave-from="opacity-100"
                            leave-to="opacity-0">
                            <div
                                class="absolute left-full top-0 flex w-16 justify-center pt-5">
                                <button
                                    class="-m-2.5 p-2.5"
                                    type="button"
                                    @click="sidebarOpen = false">
                                    <span class="sr-only">Close sidebar</span>
                                    <XMarkIcon
                                        aria-hidden="true"
                                        class="h-6 w-6 text-white" />
                                </button>
                            </div>
                        </TransitionChild>
                        <!-- Sidebar component, swap this element with another sidebar if you like -->
                        <div
                            class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-4">
                            <div class="flex h-16 shrink-0 items-center">
                                <application-mark />
                            </div>
                            <nav class="flex flex-1 flex-col">
                                <ul
                                    class="flex flex-1 flex-col gap-y-7"
                                    role="list">
                                    <li>
                                        <ul class="-mx-2 space-y-1" role="list">
                                            <template
                                                v-for="item in navigation"
                                                :key="item.name">
                                                <li
                                                    v-if="
                                                        userHasResource(
                                                            item.name
                                                        )
                                                    ">
                                                    <Link
                                                        :class="[
                                                            item.current
                                                                ? 'bg-gray-50 text-primary'
                                                                : 'text-gray-700 hover:text-primary hover:bg-gray-50',
                                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
                                                        ]"
                                                        :href="item.href">
                                                        <!--                                                        <component-->
                                                        <!--                                                            :is="item.icon"-->
                                                        <!--                                                            :class="[-->
                                                        <!--                                                                1 === 0-->
                                                        <!--                                                                    ? 'text-primary'-->
                                                        <!--                                                                    : 'text-gray-400 group-hover:text-primary',-->
                                                        <!--                                                                'h-6 w-6 shrink-0',-->
                                                        <!--                                                            ]"-->
                                                        <!--                                                            aria-hidden="true" />-->
                                                        {{ item.name }}
                                                    </Link>
                                                </li>
                                            </template>
                                        </ul>
                                    </li>
                                    <li>
                                        <div
                                            class="text-xs font-semibold leading-6 text-gray-400">
                                            Deine Teams
                                        </div>
                                        <ul
                                            class="-mx-2 mt-2 space-y-1"
                                            role="list">
                                            <li
                                                v-for="team in $page.props.user
                                                    .all_teams"
                                                :key="team.name">
                                                <!--                                                        :href="team.href"-->
                                                <button
                                                    :class="[
                                                        team.current
                                                            ? 'bg-gray-50 text-primary'
                                                            : 'text-gray-700 hover:text-primary hover:bg-gray-50',
                                                        'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold w-full',
                                                    ]"
                                                    @click="
                                                        switchToTeam(team.id)
                                                    ">
                                                    <span
                                                        :class="[
                                                            team.current
                                                                ? 'text-primary border-primary'
                                                                : 'text-gray-400 border-gray-200 group-hover:border-primary group-hover:text-primary',
                                                            'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white',
                                                        ]"
                                                        >{{
                                                            team.name.charAt(0)
                                                        }}</span
                                                    >
                                                    <span class="truncate">{{
                                                        team.name
                                                    }}</span>
                                                </button>
                                            </li>
                                        </ul>
                                    </li>
                                    <!--                                    <li class="mt-auto">-->
                                    <!--                                        <a-->
                                    <!--                                            href="#"-->
                                    <!--                                            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-primary">-->
                                    <!--                                            <Cog6ToothIcon-->
                                    <!--                                                class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary"-->
                                    <!--                                                aria-hidden="true" />-->
                                    <!--                                            Settings-->
                                    <!--                                        </a>-->
                                    <!--                                    </li>-->
                                </ul>
                            </nav>
                        </div>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>

    <!-- Static sidebar for desktop -->
    <div
        class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
        <!-- Sidebar component, swap this element with another sidebar if you like -->
        <div
            class="flex grow flex-col gap-y-16 overflow-y-auto border-r border-gray-200 bg-white px-6 pb-4">
            <div class="flex h-16 shrink-0 items-center">
                <NavLink
                    :href="route('hub.dashboard')"
                    class="hover:border-none flex w-full justify-between">
                    <application-mark class="!w-6" />
                    <div class="mx-2 hidden lg:flex items-baseline">
                        <span
                            class="font-display font-black text-gray-800 text-xl tracking-tight">
                            EnergieHub
                        </span>
                    </div>
                    <div class="w-6" />
                </NavLink>
            </div>
            <nav class="flex flex-1 flex-col">
                <ul class="flex flex-1 flex-col gap-y-7" role="list">
                    <li>
                        <ul class="-mx-2 space-y-1" role="list">
                            <template
                                v-for="item in navigation"
                                :key="item.name">
                                <li>
                                    <Link
                                        :class="[
                                            item.current
                                                ? 'bg-gray-50 text-primary'
                                                : 'text-gray-700 hover:text-primary hover:bg-gray-50',
                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
                                        ]"
                                        :href="item.href">
                                        <component
                                            :is="item.icon"
                                            :class="[
                                                item.current
                                                    ? 'text-primary'
                                                    : 'text-gray-400 group-hover:text-primary',
                                                'h-6 w-6 shrink-0',
                                            ]"
                                            aria-hidden="true" />
                                        {{ item.name }}
                                    </Link>
                                </li>
                            </template>
                        </ul>
                    </li>

                    <li v-if="$page.props.permission.view_management">
                        <div
                            class="text-xs font-semibold leading-6 text-gray-400">
                            Management
                        </div>
                        <ul class="-mx-2 space-y-1" role="list">
                            <template
                                v-for="item in jetstreamNavigation"
                                :key="item.name">
                                <li>
                                    <a
                                        :class="[
                                            item.current
                                                ? 'bg-gray-50 text-primary'
                                                : 'text-gray-700 hover:text-primary hover:bg-gray-50',
                                            'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold',
                                        ]"
                                        :href="item.href">
                                        <component
                                            :is="item.icon"
                                            :class="[
                                                item.current
                                                    ? 'text-primary'
                                                    : 'text-gray-400 group-hover:text-primary',
                                                'h-6 w-6 shrink-0',
                                            ]"
                                            aria-hidden="true" />
                                        {{ item.name }}
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </li>

                    <li v-if="$page.props.permission.view_admin">
                        <div
                            class="text-xs font-semibold leading-6 text-gray-400">
                            Administration
                        </div>
                        <ul class="-mx-2 space-y-1" role="list">
                            <template
                                v-for="item in adminNavigation"
                                :key="item.name">
                                <li>
                                    <a
                                        :href="item.href"
                                        class="text-gray-700 hover:text-primary hover:bg-gray-50 group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
                                        <component
                                            :is="item.icon"
                                            :class="[
                                                item.current
                                                    ? 'text-primary'
                                                    : 'text-gray-400 group-hover:text-primary',
                                                'h-6 w-6 shrink-0',
                                            ]"
                                            aria-hidden="true" />
                                        {{ item.name }}
                                    </a>
                                </li>
                            </template>
                        </ul>
                    </li>

                    <li v-if="$page.props.user.all_teams?.length > 0">
                        <div
                            class="text-xs font-semibold leading-6 text-gray-400">
                            Deine Teams
                        </div>
                        <ul class="-mx-2 mt-2 space-y-1" role="list">
                            <li
                                v-for="team in $page.props.user.all_teams"
                                :key="team.name">
                                <button
                                    :class="[
                                        team.current
                                            ? 'bg-gray-50 text-primary'
                                            : 'text-gray-700 hover:text-primary hover:bg-gray-50',
                                        'group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold w-full',
                                    ]"
                                    @click="switchToTeam(team.id)">
                                    <span
                                        :class="[
                                            team.id ===
                                            $page.props.user.current_team_id
                                                ? 'text-primary border-primary'
                                                : 'text-gray-400 border-gray-200 group-hover:border-primary group-hover:text-primary',
                                            'flex h-6 w-6 shrink-0 items-center justify-center rounded-lg border text-[0.625rem] font-medium bg-white',
                                        ]"
                                        >{{ team.name.charAt(0) }}</span
                                    >
                                    <span class="truncate">{{
                                        team.name
                                    }}</span>
                                </button>
                            </li>
                        </ul>
                    </li>
                    <!--                    <li class="mt-auto">-->
                    <!--                        <a-->
                    <!--                            href="#"-->
                    <!--                            class="group -mx-2 flex gap-x-3 rounded-md p-2 text-sm font-semibold leading-6 text-gray-700 hover:bg-gray-50 hover:text-primary">-->
                    <!--                            <Cog6ToothIcon-->
                    <!--                                class="h-6 w-6 shrink-0 text-gray-400 group-hover:text-primary"-->
                    <!--                                aria-hidden="true" />-->
                    <!--                            Settings-->
                    <!--                        </a>-->
                    <!--                    </li>-->
                </ul>
            </nav>
        </div>
    </div>

    <div class="lg:pl-72">
        <div
            class="sticky top-0 z-40 flex h-16 shrink-0 items-center gap-x-4 border-b border-gray-200 bg-white px-4 shadow-sm sm:gap-x-6 sm:px-6 lg:px-8">
            <button
                class="-m-2.5 p-2.5 text-gray-700 lg:hidden"
                type="button"
                @click="sidebarOpen = true">
                <span class="sr-only">Open sidebar</span>
                <Bars3Icon aria-hidden="true" class="h-6 w-6" />
            </button>

            <!-- Separator -->
            <div aria-hidden="true" class="h-6 w-px bg-gray-200 lg:hidden" />

            <div class="flex flex-1 gap-x-4 self-stretch lg:gap-x-6">
                <div class="flex-1 flex justify-start">
                    <button
                        type="button"
                        class="flex items-center space-x-2 w-full"
                        @click="showSearch">
                        <magnifying-glass-icon
                            aria-hidden="true"
                            class="h-5 w-5 text-gray-500" />
                        <span class="font-semibold text-sm text-gray-500"
                            >Suche</span
                        >
                    </button>
                    <command-search
                        :open="search"
                        @close="search = false"
                        v-if="search"></command-search>
                </div>

                <!--                <form class="relative flex flex-1" action="#" method="GET">-->
                <!--                    <label for="search-field" class="sr-only">Search</label>-->
                <!--                    <MagnifyingGlassIcon-->
                <!--                        class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-400"-->
                <!--                        aria-hidden="true" />-->
                <!--                    <input-->
                <!--                        id="search-field"-->
                <!--                        class="block h-full w-full border-0 py-0 pl-8 pr-0 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm"-->
                <!--                        placeholder="Suche..."-->
                <!--                        type="search"-->
                <!--                        name="search" />-->
                <!--                </form>-->
                <div class="flex items-center gap-x-4 lg:gap-x-6">
                    <!-- Separator -->
                    <div
                        aria-hidden="true"
                        class="hidden lg:block lg:h-6 lg:w-px lg:bg-gray-200" />

                    <!-- Profile dropdown -->
                    <Menu as="div" class="relative text-left">
                        <!--                            <MenuButton class="-m-1.5 flex items-center p-1.5">-->
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                <button
                                    v-if="
                                        $page.props.jetstream
                                            .managesProfilePhotos
                                    "
                                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                    <img
                                        :alt="$page.props.user.first_name"
                                        :src="
                                            $page.props.user.profile_photo_url
                                        "
                                        class="h-8 w-8 rounded-full object-cover" />
                                </button>

                                <span v-else class="inline-flex rounded-md">
                                    <button
                                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition"
                                        type="button">
                                        {{ $page.props.user.first_name }}

                                        <ChevronDownIcon class="ml-2 h-4 w-4" />
                                    </button>
                                </span>
                            </template>

                            <template #content>
                                <!-- Account Management -->
                                <div
                                    class="block px-4 py-2 text-xs text-gray-400">
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
                                    <DropdownLink as="button">
                                        Log Out
                                    </DropdownLink>
                                </form>
                            </template>
                        </Dropdown>
                        <!--                            </MenuButton>-->
                        <transition
                            enter-active-class="transition ease-out duration-100"
                            enter-from-class="transform opacity-0 scale-95"
                            enter-to-class="transform opacity-100 scale-100"
                            leave-active-class="transition ease-in duration-75"
                            leave-from-class="transform opacity-100 scale-100"
                            leave-to-class="transform opacity-0 scale-95">
                            <MenuItems
                                class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                <MenuItem
                                    v-for="item in userNavigation"
                                    :key="item.name"
                                    v-slot="{ active }">
                                    <a
                                        :class="[
                                            active ? 'bg-gray-50' : '',
                                            'block px-3 py-1 text-sm leading-6 text-gray-900',
                                        ]"
                                        :href="item.href"
                                        >{{ item.name }}</a
                                    >
                                </MenuItem>
                            </MenuItems>
                        </transition>
                    </Menu>
                </div>
            </div>
        </div>

        <slot name="header" />

        <main class="py-6 flex justify-center">
            <div class="px-4 w-full sm:px-6 lg:px-8 max-w-7xl">
                <!-- Your content -->
                <slot />
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import {
    Dialog,
    DialogPanel,
    Menu,
    MenuItem,
    MenuItems,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import {
    AdjustmentsVerticalIcon,
    Bars3Icon,
    CreditCardIcon,
    FolderIcon,
    HomeIcon,
    UsersIcon,
    WrenchIcon,
    XMarkIcon,
    HomeModernIcon,
    RectangleGroupIcon,
} from '@heroicons/vue/24/outline';
import { ChevronDownIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid';
import Dropdown from '../Components/Dropdown.vue';
import DropdownLink from '../Components/DropdownLink.vue';
import ApplicationMark from '../Components/ApplicationMark.vue';
import NavLink from '../Components/NavLink.vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import CommandSearch from '../Components/CommandSearch.vue';

const search = ref(false);
const showSearch = () => {
    search.value = true;
};

const navigation = [
    {
        name: 'Dashboard',
        href: route('hub.dashboard'),
        icon: RectangleGroupIcon,
        current: route().current('hub.dashboard'),
    },
    {
        name: 'Gebäude',
        href: route('hub.buildings.index'),
        icon: HomeModernIcon,
        current: route().current('hub.buildings*'),
    },
    // {
    //     name: 'Bestellungen',
    //     href: route('hub.certificates'),
    //     icon: FolderIcon,
    //     current:
    //         route().current('hub.orders*') ||
    //         route().current('hub.certificates*'),
    // },
];

const jetstreamNavigation = [
    {
        name: 'Team',
        href: usePage().props.user?.current_team_id
            ? route('teams.show', {
                  team: usePage().props.user.current_team_id,
              })
            : null,
        icon: UsersIcon,
        current: route().current('teams.show'),
    },
    {
        name: 'Billing',
        href: route('hub.billing'),
        icon: CreditCardIcon,
        current: route().current('hub.billing'),
    },
];

const adminNavigation = [
    {
        name: 'Nova',
        href: route('nova.pages.home'),
        icon: AdjustmentsVerticalIcon,
    },
    { name: 'Telescope', href: route('telescope'), icon: WrenchIcon },
];

const switchToTeam = (teamId) => {
    router.put(
        route('current-team.update'),
        {
            team_id: teamId,
        },
        {
            preserveState: false,
        }
    );
};

const userHasResource = (itemName) => {
    return usePage().props.resources.some(
        (item) => item.display_name === itemName
    );
};

const userNavigation = [
    { name: 'Your profile', href: '#' },
    { name: 'Sign out', href: '#' },
];

const sidebarOpen = ref(false);

const logout = () => {
    router.post(route('logout'));
};
</script>
