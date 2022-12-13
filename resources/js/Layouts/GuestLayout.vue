<template>

</template>

<script>
export default {
    name: 'GuestLayout.vue',
};
</script>

<style scoped>

</style>
<script setup>
import {ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import ApplicationMark from '@/Jetstream/ApplicationMark.vue';
import Banner from '@/Jetstream/Banner.vue';
import Dropdown from '@/Jetstream/Dropdown.vue';
import DropdownLink from '@/Jetstream/DropdownLink.vue';
import NavLink from '@/Jetstream/NavLink.vue';
import ResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';
import {Notification, NotificationGroup} from 'notiwind';
import LightNotification from '@/Layouts/Notifications/LightNotification.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(
        route('current-team.update'),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        },
    );
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>
        <Banner />

        <div class="min-h-screen bg-slate-50">
            <nav class="border-b border-gray-100 bg-white">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->

                            <NavLink href="/">
                                <ApplicationMark />
                            </NavLink>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                                <NavLink :href="route('bedarf.index')" :active="route().current('bedarf.*')">
                                    Energieausweis
                                </NavLink>
                            </div>
                        </div>

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

                        <!-- Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                                @click="showingNavigationDropdown = !showingNavigationDropdown">
                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path
                                        :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                    <path
                                        :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
                     class="sm:hidden">
                    <div class="space-y-1 pt-2 pb-3">
                        <ResponsiveNavLink :href="route('start')" :active="route().current('start')"> Items
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div v-if="$page.props.user" class="border-t border-gray-200 pt-4 pb-1">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="mr-3 shrink-0">
                                <img class="h-10 w-10 rounded-full object-cover"
                                     :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />
                            </div>

                            <div>
                                <div class="text-base font-medium text-gray-800">
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :href="route('profile.show')" :active="route().current('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink
                                v-if="$page.props.jetstream.hasApiFeatures"
                                :href="route('api-tokens.index')"
                                :active="route().current('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button"> Log Out</ResponsiveNavLink>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="sticky top-0 z-40 bg-white shadow">
                <div id="header" class="mx-auto flex h-20 max-w-7xl items-center px-4 sm:px-6 lg:px-8" />
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
        <NotificationGroup>
            <div class="pointer-events-none fixed inset-0 z-50 flex items-start justify-end p-6 px-4 py-6">
                <div class="w-full max-w-sm">
                    <Notification
                        v-slot="{ notifications, close }"
                        enter="ease-out duration-300 transition"
                        enter-from="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-4"
                        enter-to="translate-y-0 opacity-100 sm:translate-x-0"
                        leave="transition ease-in duration-300"
                        leave-from="opacity-100"
                        leave-to="opacity-0"
                        move="transition duration-300"
                        move-delay="delay-300">
                        <LightNotification v-for="notification in notifications" :key="notification.id"
                                           :notification="notification" :close="close" />
                    </Notification>
                </div>
            </div>
        </NotificationGroup>
    </div>
</template>
