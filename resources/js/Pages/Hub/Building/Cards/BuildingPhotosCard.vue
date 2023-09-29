<script setup>
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
                    Gebäudefotos
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    Fotos vom Gebäude, Heizungsanlage, etc.
                </p>
            </div>
            <bz-button type="secondary">bilder hochladen</bz-button>
        </div>
        <div class="border-t border-gray-100">
            <ul
                v-if="building.data.photos?.length > 0"
                class="grid p-4 grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"
                role="list">
                <li
                    v-for="file in building.data.photos"
                    :key="file.source"
                    class="relative">
                    <div
                        class="group aspect-h-7 aspect-w-10 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                        <img
                            :src="file.source"
                            alt=""
                            class="pointer-events-none object-cover group-hover:opacity-75" />
                        <button
                            class="absolute inset-0 focus:outline-none"
                            type="button">
                            <span class="sr-only"
                                >View details for {{ file.title }}</span
                            >
                        </button>
                    </div>
                    <p
                        class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900">
                        {{ file.title }}
                    </p>
                    <p
                        class="pointer-events-none block text-sm font-medium text-gray-500">
                        {{ file.size }}
                    </p>
                </li>
            </ul>
            <el-empty
                description="Noch keine Fotos vorhanden"
                v-else></el-empty>
        </div>
    </div>
</template>
