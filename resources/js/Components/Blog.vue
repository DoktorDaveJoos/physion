<template>
    <div class="relative bg-gray-50 px-6 pt-16 pb-20 lg:px-8 lg:pt-24 lg:pb-28">
        <div class="absolute inset-0">
            <div class="h-1/3 bg-white sm:h-2/3" />
        </div>
        <div class="relative mx-auto max-w-7xl">
            <div class="text-center">
                <h2
                    class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Neues vom Blog
                </h2>
                <p class="mx-auto mt-3 max-w-2xl text-xl text-gray-500 sm:mt-4">
                    Auf dem Laufenden bleiben bei Sanierung, Energieeffizienz
                    und nachhaltigem Bauen, sowie BIRN-Zertifizierung und
                    Energieausweis."
                </p>
            </div>
            <div
                class="mx-auto mt-12 grid max-w-lg gap-5 lg:max-w-none lg:grid-cols-3">
                <div
                    v-for="post in entries"
                    :key="post.slug"
                    class="flex flex-col overflow-hidden rounded-lg shadow-lg">
                    <div class="flex-shrink-0">
                        <img
                            class="h-48 w-full object-cover"
                            :src="post.img"
                            alt="" />
                    </div>
                    <div
                        class="flex flex-1 flex-col justify-between bg-white p-6">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-indigo-600">
                                <span class="hover:underline">Blog</span>
                            </p>
                            <InertiaLink
                                :href="route('blog.show.post', { post: post.slug })"
                                class="mt-2 block">
                                <p class="text-xl font-semibold text-gray-900">
                                    {{ post.title }}
                                </p>
                                <p class="mt-3 text-base text-gray-500">
                                    {{ post.short_description }}
                                </p>
                            </InertiaLink>
                        </div>
                        <div class="mt-6 flex items-center">
                            <div class="flex-shrink-0">
                                <div>
                                    <span class="sr-only">Hannes Jungert</span>
                                    <img
                                        class="h-10 w-10 rounded-full"
                                        src="/hannes-blog.jpg"
                                        alt="" />
                                </div>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-gray-900">
                                    <a href="#" class="hover:underline"
                                        >Hannes Jungert</a
                                    >
                                </p>
                                <div
                                    class="flex space-x-1 text-sm text-gray-500">
                                    <time :datetime="post.datetime">{{
                                        dayjs(post.published_at)
                                            .locale('de')
                                            .format('dddd, DD MMM YYYY')
                                    }}</time>
                                    <span aria-hidden="true">&middot;</span>
                                    <span>2 min read</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { InertiaLink, usePage } from '@inertiajs/inertia-vue3';
import { dayjs } from 'element-plus';

const posts = usePage().props.value.posts;

const pictures = [
    '/office_building.svg',
    '/abstract_certificate.svg',
    '/organic_office_building.svg',
];

const entries = pictures.map((link, idx) => {
    return {
        ...posts[idx],
        img: link,
    };
});

// defineProps({
//     posts: {
//         type: Array,
//         required: true,
//     },
// });
//
// const posts = [
//     {
//         title: 'Boost your conversion rate',
//         href: '#',
//         category: { name: 'Article', href: '#' },
//         description:
//             'Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto accusantium praesentium eius, ut atque fuga culpa, similique sequi cum eos quis dolorum.',
//         date: 'Mar 16, 2020',
//         datetime: '2020-03-16',
//         imageUrl:
//             'https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80',
//         readingTime: '6 min',
//         author: {
//             name: 'Roel Aufderehar',
//             href: '#',
//             imageUrl:
//                 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//         },
//     },
//     {
//         title: 'How to use search engine optimization to drive sales',
//         href: '#',
//         category: { name: 'Video', href: '#' },
//         description:
//             'Lorem ipsum dolor sit amet consectetur adipisicing elit. Velit facilis asperiores porro quaerat doloribus, eveniet dolore. Adipisci tempora aut inventore optio animi., tempore temporibus quo laudantium.',
//         date: 'Mar 10, 2020',
//         datetime: '2020-03-10',
//         imageUrl:
//             'https://images.unsplash.com/photo-1547586696-ea22b4d4235d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80',
//         readingTime: '4 min',
//         author: {
//             name: 'Brenna Goyette',
//             href: '#',
//             imageUrl:
//                 'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//         },
//     },
//     {
//         title: 'Improve your customer experience',
//         href: '#',
//         category: { name: 'Case Study', href: '#' },
//         description:
//             'Lorem ipsum dolor sit amet consectetur adipisicing elit. Sint harum rerum voluptatem quo recusandae magni placeat saepe molestiae, sed excepturi cumque corporis perferendis hic.',
//         date: 'Feb 12, 2020',
//         datetime: '2020-02-12',
//         imageUrl:
//             'https://images.unsplash.com/photo-1492724441997-5dc865305da7?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1679&q=80',
//         readingTime: '11 min',
//         author: {
//             name: 'Daniela Metz',
//             href: '#',
//             imageUrl:
//                 'https://images.unsplash.com/photo-1487412720507-e7ab37603c6f?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
//         },
//     },
// ]
</script>
