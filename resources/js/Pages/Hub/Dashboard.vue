<script setup>
import SidebarLayout from '../../Layouts/SidebarLayout.vue';
import {
    ChevronRightIcon,
    XMarkIcon,
    UserIcon,
} from '@heroicons/vue/24/outline';
import { Link, Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import BzButton from '../../Components/BzButton.vue';
import BzCard from './Components/BzCard.vue';
import DashboardFeed from './Components/DashboardFeed.vue';
import Badge from '../../Components/Badge.vue';

defineProps({
    products: Array,
    stats: Object,
    activities: Array,
});

const showWarning = ref(true);
</script>

<template>
    <Head title="Dashboard"></Head>
    <SidebarLayout>
        <template v-if="!$page.props.auth.user?.current_team_id">
            <el-empty
                description="Sie müssen zuerst einem Team beitreten!"></el-empty>

            <div class="flex justify-center">
                <div class="max-w-lg text-sm text-gray-500">
                    Schau in der Navigation links unter
                    <span class="font-bold">"Deine Teams"</span> ob du dort ein
                    Team findest. Wende Dich sonst gerne an das Bauzertifikate
                    Team. Danke! Und schön, dass Du bei Uns bist!
                </div>
            </div>
        </template>
        <template v-else>
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-2">
                    <bz-card>
                        <template #title>Übersicht</template>
                        <template #subtitle
                            >Alles was dein Team betrifft</template
                        >
                        <template #content>
                            <div class="space-y-2 py-4 px-6">
                                <p class="text-sm font-semibold text-gray-800">
                                    Ansprechpartner
                                </p>
                                <div
                                    class="rounded-lg flex justify-between items-center py-2 px-4 bg-gray-100">
                                    <div class="flex items-center">
                                        <user-icon
                                            class="h-4 w-4 mr-2 text-gray-400" />
                                        <span
                                            class="text-sm font-semibold text-gray-900"
                                            >Hannes Jungert</span
                                        >
                                        <badge
                                            class="ml-4"
                                            size="sm"
                                            label="fachlich"></badge>
                                    </div>
                                    <span class="text-xs text-gray-900"
                                        >+49 152 23021307</span
                                    >
                                </div>
                                <div
                                    class="rounded-lg flex justify-between items-center py-2 px-4 bg-gray-100">
                                    <div class="flex items-center">
                                        <user-icon
                                            class="h-4 w-4 mr-2 text-gray-400" />
                                        <span
                                            class="text-sm font-semibold text-gray-900"
                                            >David Joos</span
                                        >
                                        <badge
                                            class="ml-4"
                                            size="sm"
                                            label="technisch"></badge>
                                    </div>
                                    <span class="text-xs text-gray-900"
                                        >+49 152 2541810</span
                                    >
                                </div>
                                <el-empty
                                    description="Hier entsteht Ihr persönlicher Bereich." />
                            </div>
                        </template>
                    </bz-card>
                </div>

                <div>
                    <div class="rounded-lg px-4 py-4 bg-white shadow h-auto">
                        <div class="flex items-center mb-4">
                            <span class="text-sm text-gray-700 font-semibold"
                                >Aktivitäten</span
                            >
                        </div>
                        <dashboard-feed :activities="activities" />
                    </div>
                </div>
            </div>
        </template>
    </SidebarLayout>
</template>
