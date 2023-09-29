<script setup>
import {
    PaperClipIcon,
    CheckCircleIcon,
    XCircleIcon,
} from '@heroicons/vue/24/solid';
import BzButton from '../../../../Components/BzButton.vue';

defineProps({
    building: Object,
});
</script>

<template>
    <div class="rounded-lg shadow bg-white mt-6 flex flex-col">
        <div class="flex px-6 py-4 justify-between items-center">
            <div>
                <h3 class="text-base font-semibold leading-7 text-gray-900">
                    Thermische Hülle
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    Detaillierte Angaben zur Gebäudehülle
                </p>
            </div>
            <bz-button type="secondary">bearbeiten</bz-button>
        </div>
        <div class="border-t border-gray-100">
            <el-empty
                v-if="
                    !building.data.wall &&
                    !building.data.roof &&
                    !building.data.cellarModel
                "
                description="Keine Daten vorhanden">
                <bz-button
                    as="link"
                    :href="
                        route('hub.buildings.thermal', {
                            building: building.data.id,
                        })
                    "
                    >jetzt anlegen</bz-button
                >
            </el-empty>
            <template v-else>
                <ul role="list" class="divide-y divide-gray-100">
                    <li class="flex px-6 py-4 items-center justify-between">
                        <div class="flex items-center">
                            <check-circle-icon
                                v-if="building.data.wall"
                                class="h-5 w-5 text-emerald-500 mr-2 opacity-70" />
                            <x-circle-icon
                                v-else
                                class="h-5 w-5 text-red-500 mr-2 opacity-70" />
                            <span class="font-semibold text-sm">
                                Außenwand
                            </span>
                        </div>
                        <bz-button
                            v-if="!building.data.wall"
                            as="link"
                            :href="
                                route('hub.buildings.thermal', building.data.id)
                            "
                            type="primary"
                            plain
                            >jetzt bearbeiten</bz-button
                        >
                    </li>
                    <li class="flex px-6 py-4 items-center justify-between">
                        <div class="flex items-center">
                            <check-circle-icon
                                v-if="building.data.roof"
                                class="h-5 w-5 text-emerald-500 mr-2 opacity-70" />
                            <x-circle-icon
                                v-else
                                class="h-5 w-5 text-red-500 mr-2 opacity-70" />
                            <span class="font-semibold text-sm"> Dach </span>
                        </div>
                        <bz-button
                            v-if="!building.data.roof"
                            as="link"
                            :href="
                                route('hub.buildings.thermal', building.data.id)
                            "
                            type="primary"
                            plain
                            >jetzt bearbeiten</bz-button
                        >
                    </li>
                    <li class="flex px-6 py-4 items-center justify-between">
                        <div class="flex items-center">
                            <check-circle-icon
                                v-if="building.data.cellarModel"
                                class="h-5 w-5 text-emerald-500 mr-2 opacity-70" />
                            <x-circle-icon
                                v-else
                                class="h-5 w-5 text-red-500 mr-2 opacity-70" />
                            <span class="font-semibold text-sm"> Keller </span>
                        </div>
                        <bz-button
                            v-if="!building.data.cellarModel"
                            as="link"
                            :href="
                                route('hub.buildings.thermal', building.data.id)
                            "
                            type="primary"
                            plain
                            >jetzt bearbeiten</bz-button
                        >
                    </li>
                </ul>
            </template>
        </div>
    </div>
</template>
