<script setup>
import { PaperClipIcon } from '@heroicons/vue/24/outline';
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
                    Energieträger / Heizung / Erneuerbare Energien
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    Detaillierte Angaben zum Energieträger des Gebäudes
                </p>
            </div>
            <bz-button type="secondary">bearbeiten</bz-button>
        </div>
        <div class="border-t border-gray-100">
            <el-empty description="Keine Daten vorhanden">
                <bz-button as="link">jetzt anlegen</bz-button>
            </el-empty>
        </div>
    </div>
</template>
