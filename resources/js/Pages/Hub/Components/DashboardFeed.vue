<template>
    <ul role="list" class="space-y-6">
        <li
            v-for="(activityItem, activityItemIdx) in activities"
            :key="activityItem.id"
            class="relative flex gap-x-4">
            <div
                :class="[
                    activityItemIdx === activities.length - 1
                        ? 'h-6'
                        : '-bottom-6',
                    'absolute left-0 top-0 flex w-6 justify-center',
                ]">
                <div class="w-px bg-gray-200" />
            </div>
            <template v-if="activityItem.type === 'kommentiert'">
                <img
                    :src="activityItem.user.profile_photo_url"
                    alt=""
                    class="relative mt-3 h-6 w-6 flex-none rounded-full bg-gray-200" />
                <div
                    class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                    <div class="flex justify-between gap-x-4">
                        <div class="py-0.5 text-xs leading-5 text-gray-500">
                            <span class="font-medium text-gray-900">{{
                                activityItem.user.first_name
                            }}</span>
                            hat
                        </div>
                        <time
                            :datetime="activityItem.dateTime"
                            class="flex-none py-0.5 text-xs leading-5 text-gray-500"
                            >{{ activityItem.date }}</time
                        >
                    </div>
                    <p class="text-sm leading-6 text-gray-500">
                        {{ activityItem.comment }}
                    </p>
                </div>
            </template>
            <template v-else>
                <div
                    class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                    <CheckCircleIcon
                        v-if="activityItem.type === 'bestellt'"
                        class="h-6 w-6 text-blue-600"
                        aria-hidden="true" />
                    <div
                        v-else
                        class="h-1.5 w-1.5 rounded-full bg-gray-200 ring-1 ring-gray-200" />
                </div>
                <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                    <span class="font-medium text-gray-900">{{
                        activityItem.user.first_name
                    }}</span>
                    hat {{ activityItem.subject }} {{ activityItem.type }}.
                </p>
                <time
                    :datetime="activityItem.created_at"
                    class="flex-none py-0.5 text-xs leading-5 text-gray-500"
                    >{{ dayjs(activityItem.created_at).fromNow() }}</time
                >
            </template>
        </li>
    </ul>

    <!-- New comment form -->
    <div class="mt-6 flex gap-x-3">
        <form action="#" class="relative flex-auto">
            <div
                class="overflow-hidden rounded-lg pb-12 ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-blue-600">
                <label for="comment" class="sr-only"
                    >Füge deine Notiz hinzu</label
                >
                <textarea
                    rows="2"
                    name="comment"
                    id="comment"
                    class="block w-full resize-none border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6"
                    placeholder="Füge deine Notiz hinzu..." />
            </div>

            <div
                class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
                <div class="flex items-center space-x-5">
                    <div class="flex items-center"></div>
                </div>
                <bz-button type="secondary"> Notiz anhängen </bz-button>
            </div>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { CheckCircleIcon } from '@heroicons/vue/24/solid';
import {
    FaceFrownIcon,
    FaceSmileIcon,
    FireIcon,
    HandThumbUpIcon,
    HeartIcon,
    PaperClipIcon,
    XMarkIcon,
} from '@heroicons/vue/20/solid';
import dayjs from 'dayjs';
// import relativeTime plugin
import relativeTime from 'dayjs/plugin/relativeTime';
import BzButton from '../../../Components/BzButton.vue';

// extend dayjs with relativeTime plugin
dayjs.extend(relativeTime);

const props = defineProps({
    activities: Array,
});

console.log(props.activities);
</script>
