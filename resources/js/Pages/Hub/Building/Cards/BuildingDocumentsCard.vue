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
                    Gebäudedokumente
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    Baugesuch, Grundriss, etc.
                </p>
            </div>
            <bz-button type="secondary">hochladen</bz-button>
        </div>
        <div class="border-t border-gray-100">
            <ul
                v-if="building.data.documents?.length > 0"
                class="divide-y divide-gray-100"
                role="list">
                <li
                    v-for="file in building.data.documents"
                    class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                    <div class="flex w-0 flex-1 items-center">
                        <PaperClipIcon
                            aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-400" />
                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                            <span class="truncate font-medium">{{
                                file.name
                            }}</span>
                            <span class="flex-shrink-0 text-gray-400">{{
                                file.size
                            }}</span>
                        </div>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <a
                            class="font-medium text-blue-600 hover:text-blue-500"
                            href="#"
                            >Download</a
                        >
                    </div>
                </li>
                <li
                    class="flex items-center justify-between py-4 pl-4 pr-5 text-sm leading-6">
                    <div class="flex w-0 flex-1 items-center">
                        <PaperClipIcon
                            aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-400" />
                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                            <span class="truncate font-medium"
                                >grundriss-müller.pdf</span
                            >
                            <span class="flex-shrink-0 text-gray-400"
                                >4.5mb</span
                            >
                        </div>
                    </div>
                    <div class="ml-4 flex-shrink-0">
                        <a
                            class="font-medium text-blue-600 hover:text-blue-500"
                            href="#"
                            >Download</a
                        >
                    </div>
                </li>
            </ul>
            <el-empty description="Noch keine Dokumente vorhanden" v-else>
            </el-empty>
        </div>
    </div>
</template>
