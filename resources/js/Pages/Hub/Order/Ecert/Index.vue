<script setup>
import SidebarLayout from '../../../../Layouts/SidebarLayout.vue';
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    orders: Object,
});

const subTabsProducts = [
    {
        name: 'Energieausweis',
        active: true,
        route: route('orders.ecert.index'),
    },
    {
        name: 'isfp',
        active: false,
        route: route('orders.isfp.index'),
    },
    {
        name: 'bza',
        active: false,
        route: route('orders.bza.index'),
    },
];
</script>

<template>
    <Head>
        <title>Bestellungen</title>
    </Head>

    <SidebarLayout>
        <div
            class="rounded-lg shadow bg-white px-6 py-4 flex items-center justify-between">
            <div class="flex space-x-2">
                <h3
                    class="text-lg font-display font-semibold leading-6 text-gray-700">
                    Bestellungen
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    - Hier findest Du Bestellungen
                </p>
            </div>
        </div>

        <div
            class="rounded-lg mt-4 shadow bg-white px-6 py-3 flex items-center justify-center">
            <div>
                <div class="sm:hidden">
                    <label class="sr-only" for="tabs">Select a tab</label>
                    <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                    <select
                        id="tabs"
                        class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                        name="tabs">
                        <option
                            v-for="tab in subTabsProducts"
                            :key="tab.name"
                            :selected="tab.active">
                            {{ tab.name }}
                        </option>
                    </select>
                </div>
                <div class="hidden sm:block">
                    <nav aria-label="Tabs" class="flex space-x-4">
                        <Link
                            v-for="tab in subTabsProducts"
                            :key="tab.name"
                            :aria-current="tab.active ? 'page' : undefined"
                            :class="[
                                tab.active
                                    ? 'bg-gray-100 text-gray-700'
                                    : 'text-gray-500 hover:text-gray-700',
                                'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',
                            ]"
                            :href="tab.route">
                            {{ tab.name }}
                        </Link>
                    </nav>
                </div>
            </div>
        </div>

        <!--        <ul-->
        <!--            role="list"-->
        <!--            class="divide-y divide-gray-100 overflow-hidden rounded-lg bg-white shadow mt-6">-->
        <!--            <template-->
        <!--                v-for="building in buildings.data"-->
        <!--                :key="building.data.id">-->
        <!--                <Link-->
        <!--                    :href="building.links.self"-->
        <!--                    class="relative flex items-center justify-between gap-x-6 p-4 group hover:bg-gray-50 transition duration-150">-->
        <!--                    <div class="flex min-w-0 gap-x-4">-->
        <!--                        <div-->
        <!--                            class="bg-gray-100 rounded-md h-16 w-16 flex items-center justify-center group-hover:shadow-lg transition duration-150"-->
        <!--                            v-if="!building.links.image">-->
        <!--                            <photo-icon class="h-6 w-6 text-gray-400" />-->
        <!--                        </div>-->
        <!--                        <img-->
        <!--                            v-else-->
        <!--                            class="h-16 w-16 flex-none rounded-md bg-gray-50 group-hover:shadow-lg"-->
        <!--                            :src="building.links.image"-->
        <!--                            alt="" />-->
        <!--                        <div class="min-w-0 flex-auto items-center">-->
        <!--                            <p class="text-sm font-semibold text-gray-900">-->
        <!--                                <span-->
        <!--                                    class="absolute inset-x-0 -top-px bottom-0" />-->
        <!--                                {{ building.data.address }}-->
        <!--                            </p>-->
        <!--                            <p class="flex text-xs leading-5 text-gray-500">-->
        <!--                                <span class="relative truncate hover:underline"-->
        <!--                                >{{ building.data.postal_code }}-->
        <!--                                    {{ building.data.city }}</span-->
        <!--                                >-->
        <!--                            </p>-->
        <!--                            <p class="flex text-xs leading-5 text-gray-500">-->
        <!--                                <span class="relative truncate hover:underline"-->
        <!--                                >Erstellt von-->
        <!--                                    {{ building.data.created_by }}</span-->
        <!--                                >-->
        <!--                            </p>-->
        <!--                        </div>-->
        <!--                        <div class="flex items-start space-x-2">-->
        <!--                            <badge-->
        <!--                                type="info"-->
        <!--                                size="sm"-->
        <!--                                :label="building.data.type" />-->
        <!--                            <badge-->
        <!--                                v-if="building.data.additional_type"-->
        <!--                                type="info"-->
        <!--                                size="sm"-->
        <!--                                :label="building.data.additional_type" />-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                    <div class="flex shrink-0 items-center gap-x-4">-->
        <!--                        <div class="hidden sm:flex sm:flex-col sm:items-end">-->
        <!--                            &lt;!&ndash;                            <div class="flex items-center gap-x-1.5">&ndash;&gt;-->
        <!--                            &lt;!&ndash;                                <div&ndash;&gt;-->
        <!--                            &lt;!&ndash;                                    class="flex-none rounded-full bg-emerald-500/20 p-1">&ndash;&gt;-->
        <!--                            &lt;!&ndash;                                    <div&ndash;&gt;-->
        <!--                            &lt;!&ndash;                                        class="h-1.5 w-1.5 rounded-full bg-emerald-500" />&ndash;&gt;-->
        <!--                            &lt;!&ndash;                                </div>&ndash;&gt;-->
        <!--                            &lt;!&ndash;                                <p class="text-xs leading-5 text-gray-500">&ndash;&gt;-->
        <!--                            &lt;!&ndash;                                    Online&ndash;&gt;-->
        <!--                            &lt;!&ndash;                                </p>&ndash;&gt;-->
        <!--                            &lt;!&ndash;                            </div>&ndash;&gt;-->
        <!--                        </div>-->
        <!--                        <ChevronRightIcon-->
        <!--                            class="h-5 w-5 flex-none text-gray-400 group-hover:text-primary-600"-->
        <!--                            aria-hidden="true" />-->
        <!--                    </div> </Link-->
        <!--                ></template>-->
        <!--        </ul>-->

        <!--        <div-->
        <!--            v-if="orders.data.length > 0"-->
        <!--            class="rounded-lg mt-6 shadow bg-white px-6 py-3 flex items-center justify-center">-->
        <!--            <div class="hidden sm:block">-->
        <!--                <nav aria-label="Pagination" class="flex space-x-4">-->
        <!--                    <Link-->
        <!--                        :class="[-->
        <!--                            !orders.links.prev-->
        <!--                                ? 'text-gray-400 cursor-not-allowed'-->
        <!--                                : 'text-gray-500 hover:text-gray-700',-->
        <!--                            'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',-->
        <!--                        ]"-->
        <!--                        :disabled="!orders.links.prev"-->
        <!--                        :href="orders.links.prev">-->
        <!--                        Vorherige-->
        <!--                    </Link>-->

        <!--                    <div class="flex items-center">-->
        <!--                        <span class="text-primary-500 text-sm font-bold mr-1"-->
        <!--                            >{{ orders.meta.current_page }} </span-->
        <!--                        ><span class="text-gray-500 text-xs font-bold">-->
        <!--                            / {{ orders.meta.last_page }}</span-->
        <!--                        >-->
        <!--                    </div>-->
        <!--                    <Link-->
        <!--                        :class="[-->
        <!--                            !orders.links.next-->
        <!--                                ? 'text-gray-400 cursor-not-allowed'-->
        <!--                                : 'text-gray-500 hover:text-gray-700',-->
        <!--                            'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',-->
        <!--                        ]"-->
        <!--                        :disabled="!orders.links.next"-->
        <!--                        :href="orders.links.next">-->
        <!--                        nächste-->
        <!--                    </Link>-->
        <!--                </nav>-->
        <!--            </div>-->
        <!--        </div>-->
        <el-empty description="Noch keine Bestellungen" />
    </SidebarLayout>
</template>
