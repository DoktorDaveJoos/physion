<template>
    <div
        class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-black ring-opacity-5">
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <CheckCircleIcon
                        class="h-6 w-6 text-green-400"
                        aria-hidden="true" />
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900">
                        {{ notification.title }}
                    </p>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ notification.text }}
                    </p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button
                        type="button"
                        class="inline-flex rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                        @click="close(notification.id)">
                        <span class="sr-only">Close</span>
                        <XMarkIcon class="h-5 w-5" aria-hidden="true" />
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { CheckCircleIcon, XMarkIcon } from '@heroicons/vue/24/outline';

export default {
    components: { CheckCircleIcon, XMarkIcon },
    props: {
        notification: {
            type: Object,
            required: true,
        },
        close: {
            type: Function,
            required: true,
        },
    },
};
</script>

<style lang="scss" scoped></style>
