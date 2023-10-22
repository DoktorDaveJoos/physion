<script setup>
import BzButton from '../../../../Components/BzButton.vue';
import { computed } from 'vue';

const props = defineProps({
    building: Object,
});

const hasOldheatings = computed(() => {
    return (
        props.building.data.heatings?.filter(
            (entry) => entry.type === 'Ölheizung' || entry.type === 'Gasheizung'
        ).length > 0
    );
});

const hasheatings = computed(() => props.building.data.heatings?.length > 0);
</script>

<template>
    <div class="rounded-lg min-h-[250px] bg-gray-100 p-4 flex flex-col">
        <div>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-medium leading-6 text-gray-900">
                    Heizung
                </h2>
            </div>
        </div>

        <div
            v-if="hasheatings && !hasOldheatings"
            class="text-gray-500 text-gray-500 text-xs">
            Sehr gut! Sie haben bereits ein Heizungssystem erfasst. Falls Sie
            dennoch eine Öl- oder Gasheizung betreiben - erfassen Sie diese
            jetzt.
        </div>
        <div
            v-else-if="!hasheatings"
            class="text-gray-500 text-gray-500 text-xs">
            Sie haben noch kein Heizungssystem erfasst. Um die erforderlichen
            bzw möglichen Einzelmaßnahmen besser abzuschätzen inklusive etwaiger
            extra Förderungen, sollte die Heizungsanlage erfasst werden.
        </div>
        <div v-else class="text-gray-500 text-gray-500 text-xs">
            Perfekt. Durch die angegebene alte Heizung bekommen Sie einen extra
            Zuschuss von
            <strong>10 %</strong> auf die neue Heizung.
        </div>

        <div
            v-if="!hasheatings"
            class="flex-1 flex flex-col items-center justify-end text-xs text-gray-500 pb-4">
            <bz-button
                class="w-full"
                as="link"
                :href="route('buildings.energy.show', building.data.id)"
                >Jetzt Heizungssystem erfassen</bz-button
            >
            <span class="leading-6">
                Bis zu <span class="font-bold">10% Zuschuss</span> mehr Zuschuss
            </span>
        </div>
        <div
            v-else
            class="flex-1 flex flex-col items-center justify-end text-xs text-gray-500 pb-4">
            <bz-button
                class="w-full ring-2 ring-inset ring-gray-300"
                type="secondary"
                as="link"
                :href="route('buildings.energy.show', building.data.id)"
                >Weitere Heizungssysteme erfassen</bz-button
            >
            <span class="leading-6">
                Weitere Heizsysteme führen zu
                <strong>keinen weiteren</strong> Zuschüssen
            </span>
        </div>
    </div>
</template>
