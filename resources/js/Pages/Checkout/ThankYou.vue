<template>
    <div class="bg-white">
        <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="max-w-xl">
                <h1 class="text-base font-medium text-blue-600">Danke schön!</h1>
                <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl">Auftrag in Bearbeitung!</p>
                <p class="mt-2 text-base text-gray-500">Wir haben deinen Auftrag erfolgreich erhalten</p>

                <dl class="mt-12 text-sm font-medium">
                    <dt class="text-gray-900">Energieausweis ID</dt>
                    <dd class="mt-2 text-blue-600">{{ order.id }}</dd>
                </dl>
            </div>

            <div class="mt-10 border-t border-gray-200 py-6 flex justify-end">

                <InertiaLink :href="route('order.show', order.id)" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Auftrag anzeigen
                </InertiaLink>

            </div>
        </div>
    </div>
</template>

<script setup>
import {InertiaLink} from '@inertiajs/inertia-vue3';

defineProps({
    order: {
        type: Object,
        required: true,
    },
});

</script>
