<script setup xmlns="http://www.w3.org/1999/html">
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import ApplicationMark from '../Components/ApplicationMark.vue';
import Banner from '../Components/Banner.vue';
import Dropdown from '../Components/Dropdown.vue';
import DropdownLink from '../Components/DropdownLink.vue';
import NavLink from '../Components/NavLink.vue';
import ResponsiveNavLink from '../Components/ResponsiveNavLink.vue';
import { ChevronRightIcon, ChevronDownIcon } from '@heroicons/vue/24/solid';

defineProps({
    title: String,
    subtitle: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(
        route('current-team.update'),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title"></Head>

        <Banner />

        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto px-4 sm:px-6">
                    <div class="flex py-6 justify-between">
                        <!-- Logo -->

                        <NavLink href="/">
                            <ApplicationMark />
                            <div class="ml-1 hidden lg:flex items-baseline">
                                <span
                                    class="text-lg tracking-tight font-light text-gray-800">
                                    energie
                                </span>
                                <span
                                    class="hidden ml-0.5 text-lg text-primary font-semibold md:block">
                                    HUB
                                </span>
                                <span class="text-xs text-slate-400 ml-2"
                                    >by bauzertifikate.de</span
                                >
                            </div>
                        </NavLink>

                        <div class="items-center space-x-4 hidden sm:flex">
                            <!-- Teams Dropdown -->
                            <Dropdown
                                v-if="$page.props.jetstream.hasTeamFeatures"
                                align="right"
                                width="60">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                            {{
                                                $page.props.user.current_team
                                                    .name
                                            }}

                                            <svg
                                                class="ml-2 -mr-0.5 h-4 w-4"
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke-width="1.5"
                                                stroke="currentColor">
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <template
                                            v-if="
                                                $page.props.jetstream
                                                    .hasTeamFeatures
                                            ">
                                            <div
                                                class="block px-4 py-2 text-xs text-gray-400">
                                                Manage Team
                                            </div>

                                            <!--                                            Team Settings-->
                                            <DropdownLink
                                                v-if="
                                                    $page.props.jetstream
                                                        .canCreateTeams
                                                "
                                                :href="route('teams.create')">
                                                Neues Team
                                            </DropdownLink>

                                            <!-- Team Settings-->
                                            <DropdownLink
                                                :href="
                                                    route('teams.show', {
                                                        team: $page.props.user
                                                            .current_team,
                                                    })
                                                ">
                                                Team Settings
                                            </DropdownLink>

                                            <div
                                                class="block px-4 py-2 text-xs text-gray-400">
                                                Team wechseln
                                            </div>
                                            <template
                                                v-for="team in $page.props.user
                                                    .all_teams"
                                                :key="team.id">
                                                <form
                                                    @submit.prevent="
                                                        switchToTeam(team)
                                                    ">
                                                    <DropdownLink as="button">
                                                        <div
                                                            class="flex items-center">
                                                            <svg
                                                                v-if="
                                                                    team.id ===
                                                                    $page.props
                                                                        .user
                                                                        .current_team_id
                                                                "
                                                                class="mr-2 h-5 w-5 text-green-400"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                fill="none"
                                                                viewBox="0 0 24 24"
                                                                stroke-width="1.5"
                                                                stroke="currentColor">
                                                                <path
                                                                    stroke-linecap="round"
                                                                    stroke-linejoin="round"
                                                                    d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                            </svg>

                                                            <div>
                                                                {{ team.name }}
                                                            </div>
                                                        </div>
                                                    </DropdownLink>
                                                </form>
                                            </template>
                                        </template>
                                    </div>
                                </template>
                            </Dropdown>
                            <!--                        </div>-->

                            <!--                        &lt;!&ndash; Settings Dropdown &ndash;&gt;-->
                            <!--                        <div class="ml-3 relative">-->
                            <Dropdown align="right" width="48">
                                <template #trigger>
                                    <button
                                        v-if="
                                            $page.props.jetstream
                                                .managesProfilePhotos
                                        "
                                        class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img
                                            class="h-8 w-8 rounded-full object-cover"
                                            :src="
                                                $page.props.user
                                                    .profile_photo_url
                                            "
                                            :alt="$page.props.user.name" />
                                    </button>

                                    <span v-else class="inline-flex rounded-md">
                                        <button
                                            type="button"
                                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
                                            {{ $page.props.user.name }}

                                            <ChevronDownIcon
                                                class="ml-2 h-4 w-4" />
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
                                        v-if="
                                            $page.props.jetstream.hasApiFeatures
                                        "
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
                        </div>
                        <!--                    </div>-->

                        <!--                    &lt;!&ndash; Hamburger &ndash;&gt;-->
                        <!--                    <div class="-mr-2 flex items-center sm:hidden">-->
                        <button
                            class="inline-flex sm:hidden items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition"
                            @click="
                                showingNavigationDropdown =
                                    !showingNavigationDropdown
                            ">
                            <svg
                                class="h-6 w-6"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24">
                                <path
                                    :class="{
                                        hidden: showingNavigationDropdown,
                                        'inline-flex':
                                            !showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path
                                    :class="{
                                        hidden: !showingNavigationDropdown,
                                        'inline-flex':
                                            showingNavigationDropdown,
                                    }"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden">
                    <div class="space-y-1 pt-2 pb-3">
                        <ResponsiveNavLink
                            :href="route('start')"
                            :active="route().current('start')">
                            Items
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div
                                v-if="
                                    $page.props.jetstream.managesProfilePhotos
                                "
                                class="shrink-0 mr-3">
                                <img
                                    class="h-10 w-10 rounded-full object-cover"
                                    :src="$page.props.user.profile_photo_url"
                                    :alt="$page.props.user.name" />
                            </div>

                            <div>
                                <div
                                    class="font-medium text-base text-gray-800">
                                    {{ $page.props.user.name }}
                                </div>
                                <div class="font-medium text-sm text-gray-500">
                                    {{ $page.props.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('profile.show')"
                                :active="route().current('profile.show')">
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
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template
                                v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200" />

                                <div
                                    class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink
                                    :href="
                                        route('teams.show', {
                                            team: $page.props.user.current_team,
                                        })
                                    "
                                    :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink
                                    v-if="$page.props.jetstream.canCreateTeams"
                                    :href="route('teams.create')"
                                    :active="route().current('teams.create')">
                                    Neues Team
                                </ResponsiveNavLink>

                                <div class="border-t border-gray-200" />

                                <!-- Team Switcher -->
                                <div
                                    class="block px-4 py-2 text-xs text-gray-400">
                                    Team wechseln
                                </div>

                                <template
                                    v-for="team in $page.props.user.all_teams"
                                    :key="team.id">
                                    <form @submit.prevent="switchToTeam(team)">
                                        <ResponsiveNavLink as="button">
                                            <div class="flex items-center">
                                                <svg
                                                    v-if="
                                                        team.id ===
                                                        $page.props.user
                                                            .current_team_id
                                                    "
                                                    class="mr-2 h-5 w-5 text-green-400"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    fill="none"
                                                    viewBox="0 0 24 24"
                                                    stroke-width="1.5"
                                                    stroke="currentColor">
                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <div>{{ team.name }}</div>
                                            </div>
                                        </ResponsiveNavLink>
                                    </form>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="sticky border-b border-gray-200 shadow-sm bg-white top-0 z-40">
                <div
                    id="header"
                    class="mx-auto flex h-16 items-center px-4 sm:px-6 lg:px-8">
                    resources
                </div>
            </header>

            <!-- Page Content -->
            <main class="mx-auto max-w-7xl sm:px-6 lg:px-8 py-8">
                <slot />
            </main>
        </div>
    </div>
</template>
