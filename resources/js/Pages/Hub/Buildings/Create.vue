<script setup>
import { Head } from '@inertiajs/vue3';
import SidebarLayout from '../../../Layouts/SidebarLayout.vue';
import BzCard from '../Components/BzCard.vue';
import CreateBuildingForm from '../Components/CreateBuildingForm.vue';
</script>

<template>
    <Head>
        <title>Neues Gebäude</title>
    </Head>
    <sidebar-layout>
        <div
            class="rounded-lg shadow bg-white px-6 py-4 flex items-center justify-between mb-6">
            <div class="flex space-x-2">
                <h3
                    class="text-lg font-display font-semibold leading-6 text-gray-900">
                    Neues Gebäude
                </h3>
            </div>
        </div>

        <bz-card>
            <template #title>Gebäude anlegen</template>
            <template #subtitle>Allgemeine Daten zum Gebäude angeben</template>
            <template #button>
                <!--                <bz-button type="primary" @click="form.submit()">-->
                <!--                    Gebäude anlegen-->
                <!--                </bz-button>-->
            </template>
            <template #content>
                <suspense>
                    <create-building-form />
                </suspense>
            </template>
        </bz-card>
    </sidebar-layout>
</template>
