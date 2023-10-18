<script setup>
import BzButton from '../../Components/BzButton.vue';
import BlinkingWrapper from './Components/BlinkingWrapper.vue';

defineProps({
    result: {
        type: Object,
        required: true,
    },
});

const statuses = {
    created: 'In Datenerfassung',
    open: 'In Bearbeitung',
    finalized: 'Datenerfassung abgeschlossen',
    shipped: 'Abgeschlossen',
    in_clarification: 'In Klärung',
};
</script>

<template>
    <blinking-wrapper>
        <div
            class="bg-white py-16 px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
            <div class="mx-auto max-w-lg lg:max-w-none">
                <div>
                    <h1 class="font-bold text-2xl">Ergebnis</h1>
                    <div class="mt-6 flow-root">
                        <ul role="list" class="divide-y divide-gray-100">
                            <li
                                class="flex items-center justify-between gap-x-6 py-5">
                                <div class="min-w-full">
                                    <div class="flex items-start gap-x-3">
                                        <p
                                            class="text-sm font-semibold leading-6 text-gray-900">
                                            #{{ result.data.slug }}
                                        </p>
                                        <p
                                            class="rounded-md whitespace-nowrap mt-0.5 px-1.5 py-0.5 text-xs font-medium bg-blue-100 text-primary">
                                            {{ statuses[result.data.status] }}
                                        </p>
                                    </div>
                                    <div
                                        class="mt-1 flex items-center gap-x-2 text-xs leading-5 text-gray-500">
                                        <p class="whitespace-nowrap">
                                            Erstellt am
                                            <time
                                                :datetime="result.created_at"
                                                >{{
                                                    result.data.created_at
                                                }}</time
                                            >
                                        </p>
                                    </div>
                                </div>
                                <div
                                    class="flex flex-none items-center gap-x-4 z-50">
                                    <bz-button
                                        type="secondary"
                                        as="link"
                                        :href="result.links.self"
                                        >Bestellung ansehen</bz-button
                                    >
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </blinking-wrapper>
</template>
