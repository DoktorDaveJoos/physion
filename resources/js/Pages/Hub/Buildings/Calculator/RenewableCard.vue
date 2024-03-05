<script setup>
import BzButton from '../../../../Components/BzButton.vue';
import { computed } from 'vue';

const props = defineProps({
    building: Object,
});

const hasSolarthermie = computed(() => {
    return (
        props.building.data.renewables?.filter(
            (entry) => entry.type === 'Solarthermie'
        ).length > 0
    );
});

const hasRenewables = computed(
    () => props.building.data.renewables?.length > 0
);
</script>

<template>
    <div class="rounded-lg min-h-[250px] bg-gray-100 p-4 flex flex-col">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium leading-6 text-gray-900">
                    Erneuerbare Energien
                </h2>
            </div>
        </div>

        <div v-if="hasSolarthermie" class="text-gray-500 text-gray-500 text-xs">
            Sehr gut! Sie haben Solarthermie bereits erfasst. Falls das Gebäude
            über eine Photovoltaik Anlage verfügt sollten Sie diese ebenfalls
            erfassen.
        </div>
        <div
            v-else-if="hasRenewables"
            class="text-gray-500 text-gray-500 text-xs">
            Sie haben bereits erneuerbare Energien erfasst. Sollte das Gebäude
            ebenfalls über eine Solarthermie Anlage verfügen, sollte diese
            ebenfalls erfasst werden um die möglichen Zuschüsse korrekterweise
            vorzuschlagen.
        </div>
        <div v-else class="text-gray-500 text-gray-500 text-xs">
            Sie haben noch keine erneuerbaren Energien erfasst. Falls das
            Gebäude darüber verfügt, sollten Sie diese erfassen.
        </div>

        <div
            class="flex-1 flex flex-col items-center justify-end text-xs text-gray-500 pb-4">
            <bz-button
                class="w-full ring-2 ring-inset ring-gray-300"
                type="secondary"
                as="link"
                :href="route('buildings.energy.show', building.data.id)"
                >Erneuerbare Energien erfassen</bz-button
            >
            <span class="leading-6">
                Wird zur korrekten Zuschuss Analyse gebraucht
            </span>
        </div>
    </div>
</template>
