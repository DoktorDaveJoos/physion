<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import ChevronLeftIcon from '@heroicons/vue/20/solid/ChevronLeftIcon';
import {InertiaLink} from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';

defineProps({
    post: {
        type: Object,
        required: true,
    },
});

</script>

<template>
    <GuestLayout>

        <div class="relative flex justify-center">
            <div class="max-w-3xl w-full grid">
                <div class="flex mt-10">
                    <InertiaLink :href="route('blog.show')"
                                 class="text-gray-600 hover:text-gray-500 text-sm flex items-center">
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                        Zurück
                    </InertiaLink>
                </div>

                <div class="flex mt-10">
                    <span class="text-sm text-gray-500 font-light">{{
                            dayjs(post.published_at).
                                locale('de').
                                format('dddd DD.MMM, YYYY')
                        }}</span>
                </div>

                <div class="flex mt-2 w-full">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ post.title }}</h1>
                </div>

                <div class="group block flex-shrink-0">
                    <div class="flex items-center">

<!--                        <span v-if="true" class="inline-block h-10 w-10 overflow-hidden rounded-full bg-gray-100">-->
<!--                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">-->
<!--                                <path-->
<!--                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />-->
<!--                            </svg>-->
<!--                        </span>-->
                        <img class="inline-block h-9 w-9 rounded-full"
                             src="/hannes-blog.jpg"
                             alt="" />

                        <div class="ml-3 py-4">
                            <p class="text-sm text-gray-700 group-hover:text-gray-900">{{
                                    post.user.name
                                }}</p>
                            <p class="text-xs text-gray-500 group-hover:text-gray-700">{{
                                    post.user.email
                                }}</p>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col mt-6 w-full text-gray-700 blog-content" v-html="post.content"></div>
            </div>
        </div>
    </GuestLayout>
</template>

<style scoped>

.blog-content >>> p {
    @apply py-4;
}

.blog-content >>> ol {
    @apply list-decimal px-8;
}

.blog-content >>> ul {
    @apply list-disc px-8;
}

</style>


