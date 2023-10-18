<template>
    <guest-layout>
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-primary">
                        EnergiebHub
                    </h2>
                    <p
                        class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                        Deine Energieberater Software
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Entdecken Sie die leistungsstarke cloudbasierte
                        Energieberater-Software, die Ihr Unternehmen in Sachen
                        Energieeffizienz und Kosteneinsparungen auf ein neues
                        Level hebt. Mit modernster cloudbasierter Technologie
                        bietet unsere Software eine benutzerfreundliche
                        Plattform, um Ihren Energieverbrauch zu optimieren und
                        nachhaltige Lösungen umzusetzen. Steigern Sie Ihre
                        Effizienz, reduzieren Sie Ihre Kosten und setzen Sie ein
                        starkes Zeichen für die Umwelt.
                    </p>
                </div>

                <div class="bg-white py-16 sm:py-24 lg:py-32">
                    <div
                        class="mx-auto grid max-w-5xl grid-cols-1 gap-10 px-0 sm:px-6 lg:grid-cols-12 lg:gap-8 lg:px-8">
                        <div
                            class="max-w-xl text-xl font-bold tracking-tight text-gray-900 sm:text-2xl lg:col-span-6">
                            <h2 class="inline sm:block lg:inline xl:block">
                                Jetzt für unseren Newsletter anmelden und
                                erfahren Sie als Erster von den neuesten
                                Entwicklungen und exklusiven Angeboten!
                            </h2>
                        </div>
                        <el-form class="w-full lg:col-span-6 lg:pt-2">
                            <div class="flex flex-col sm:flex-row gap-x-4">
                                <label for="email-address" class="sr-only"
                                    >Email</label
                                >
                                <el-form-item
                                    :error="emailForm.errors.email"
                                    class="w-full">
                                    <el-input
                                        v-model="emailForm.email"
                                        id="email-address"
                                        class="w-full"
                                        name="email"
                                        type="email"
                                        autocomplete="email"
                                        size="large"
                                        placeholder="Deine Email Adresse" />
                                </el-form-item>
                                <bz-button
                                    @click="subscribe"
                                    class="flex-none rounded-md bg-primary px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary">
                                    Abonnieren
                                </bz-button>
                            </div>
                            <p class="text-sm leading-6 text-gray-900">
                                Deine Daten sind uns wichtig. Lies unseren
                                <Link
                                    :href="route('datenschutz')"
                                    class="font-semibold text-primary hover:text-blue-500"
                                    >Datenschutz&nbsp;</Link
                                >.
                            </p>
                        </el-form>
                    </div>
                </div>

                <div class="mx-auto max-w-2xl lg:max-w-none">
                    <dl
                        class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                        <div
                            v-for="feature in features"
                            :key="feature.name"
                            class="flex flex-col">
                            <dt
                                class="flex items-center gap-x-3 text-base font-semibold leading-7 text-gray-900">
                                <component
                                    :is="feature.icon"
                                    class="h-5 w-5 flex-none text-primary"
                                    aria-hidden="true" />
                                {{ feature.name }}
                            </dt>
                            <dd
                                class="mt-4 flex flex-auto flex-col text-base leading-7 text-gray-600">
                                <p class="flex-auto">
                                    {{ feature.description }}
                                </p>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </guest-layout>
</template>

<script setup>
import {
    ArrowPathIcon,
    CloudArrowUpIcon,
    LockClosedIcon,
} from '@heroicons/vue/20/solid';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import BzButton from '../../Components/BzButton.vue';
import { ElNotification } from 'element-plus';

const emailForm = useForm({
    email: '',
});

const subscribe = () => {
    emailForm.post(route('newsletter.store'), {
        preserveScroll: true,
        onSuccess: () => {
            emailForm.reset();
            ElNotification({
                title: 'Erfolgreich abonniert',
                message:
                    'Du hast dich erfolgreich für den Newsletter angemeldet.',
                type: 'success',
            });
        },
    });
};

const features = [
    {
        name: 'Cloud Technologie',
        description:
            'Mit unserer cloudbasierten Energieberater-Software haben Sie jederzeit und von überall aus Zugriff auf Ihre Daten und Analysen. Egal ob Sie im Büro, zu Hause oder unterwegs sind, Sie können Ihre Energieberatung nahtlos fortsetzen und effizient arbeiten.',
        href: '#',
        icon: CloudArrowUpIcon,
    },
    {
        name: 'Sicherheit',
        description:
            'Ihre Daten und Informationen sind bei uns in sicheren Händen. Unsere cloudbasierte Plattform verwendet hochmoderne Sicherheitsmaßnahmen wie Datenverschlüsselung und Zugriffskontrollen, um sicherzustellen, dass Ihre sensiblen Energieverbrauchsdaten geschützt sind. Konzentrieren Sie sich auf Ihre Energieoptimierung, während wir uns um Ihre Datensicherheit kümmern.',
        href: '#',
        icon: LockClosedIcon,
    },
    {
        name: 'Updates',
        description:
            'Dank regelmäßiger Updates und Upgrades unserer cloudbasierten Software bleiben Sie immer auf dem neuesten Stand der Technologie. Wir sorgen dafür, dass Sie Zugang zu den neuesten Funktionen, Tools und Erkenntnissen haben, um Ihre Energieeffizienz kontinuierlich zu verbessern. Bleiben Sie vorne dabei und maximieren Sie Ihre Einsparungen mit unserer stets aktuellen Energieberater-Software.',
        href: '#',
        icon: ArrowPathIcon,
    },
];
</script>
