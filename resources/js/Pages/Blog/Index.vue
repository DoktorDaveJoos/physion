<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { ChevronRightIcon } from '@heroicons/vue/20/solid';
import { InertiaLink, useForm } from '@inertiajs/inertia-vue3';
import { ElNotification } from 'element-plus';
import dayjs from 'dayjs';

defineProps({
    posts: {
        type: Array,
        required: true,
    },
});

const form = useForm({
    email: '',
});

const subscribe = () => {
    form.post(route('blog.subscribe'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('email');
            ElNotification({
                title: 'Erfolg',
                message: 'Du hast den Newsletter erfolgreich abonniert.',
                type: 'success',
            });
        },
    });
};
</script>

<template>
    <GuestLayout>
        <div class="flex justify-center">
            <div
                class="bg-white px-6 pt-16 pb-20 lg:px-8 lg:pt-24 lg:pb-28 max-w-4xl">
                <div
                    class="relative mx-auto max-w-lg divide-y divide-gray-200 lg:max-w-7xl">
                    <div>
                        <h2
                            class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                            Blog
                        </h2>
                        <div class="mt-3 sm:mt-4 text-gray-500">
                            Bleiben Sie stets auf dem neusten Stand durch
                            Abonnement unseres E-Mail-Newsletters zu
                            Energiezertifikaten, Energieausweisen, Förderungen
                            und Sanierungen.
                        </div>
                        <div class="flex">
                            <el-form
                                class="mt-6 w-full flex flex-col sm:flex-row">
                                <el-form-item :error="form.errors.email">
                                    <el-input
                                        v-model="form.email"
                                        placeholder="E-Mail Adresse"
                                        size="large"></el-input>
                                </el-form-item>
                                <el-button
                                    @click="subscribe"
                                    type="primary"
                                    class="mt-3 sm:mt-0 sm:ml-3"
                                    size="large">
                                    Abonnieren
                                </el-button>
                            </el-form>
                        </div>
                    </div>
                    <div class="mt-6 grid gap-16 pt-10 lg:gap-x-5 lg:gap-y-12">
                        <el-timeline class="hidden sm:block" center>
                            <el-timeline-item
                                v-for="post in posts"
                                :key="post.id"
                                center>
                                <InertiaLink
                                    :href="route('blog.show.post', post.slug)">
                                    <div
                                        class="p-4 rounded hover:bg-slate-50 transition duration-150">
                                        <p class="text-sm text-gray-500">
                                            <time
                                                :datetime="
                                                    dayjs(post.published_at)
                                                        .locale('de')
                                                        .format('D MMM YYYY')
                                                ">
                                                {{
                                                    dayjs(post.published_at)
                                                        .locale('de')
                                                        .format('D MMM YYYY')
                                                }}
                                            </time>
                                        </p>
                                        <a href="#" class="block">
                                            <p
                                                class="text-xl font-semibold text-gray-900">
                                                {{ post.title }}
                                            </p>
                                            <p
                                                class="mt-3 text-sm text-gray-500">
                                                {{ post.short_description }}
                                            </p>
                                        </a>
                                        <div
                                            class="mt-3 flex items-center text-blue-600 group-hover:text-blue-500">
                                            <span>Zum Beitrag</span>
                                            <ChevronRightIcon
                                                class="h-4 w-4 mt-0.5" />
                                        </div>
                                    </div>
                                </InertiaLink>
                            </el-timeline-item>
                        </el-timeline>

                        <div class="grid sm:hidden divide-y">
                            <InertiaLink
                                v-for="post in posts"
                                :key="post.id"
                                :href="route('blog.show.post', post.slug)"
                                class="py-6">
                                <p class="text-sm text-gray-500">
                                    <time
                                        :datetime="
                                            dayjs(post.published_at)
                                                .locale('de')
                                                .format('D MMM YYYY')
                                        ">
                                        {{
                                            dayjs(post.published_at)
                                                .locale('de')
                                                .format('D MMM YYYY')
                                        }}
                                    </time>
                                </p>
                                <a href="#" class="block">
                                    <p
                                        class="text-xl font-semibold text-gray-900">
                                        {{ post.title }}
                                    </p>
                                    <p class="mt-3 text-sm text-gray-500">
                                        {{ post.short_description }}
                                    </p>
                                </a>
                                <div
                                    class="mt-3 flex items-center text-blue-600 group-hover:text-blue-500">
                                    <span>Zum Beitrag</span>
                                    <ChevronRightIcon class="h-4 w-4 mt-0.5" />
                                </div>
                            </InertiaLink>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>
