<template>
    <guest-layout>
        <div class="bg-white py-24 sm:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:text-center">
                    <h2 class="text-base font-semibold leading-7 text-blue-600">
                        Business Partner Programm
                    </h2>
                    <p
                        class="mt-2 text-3xl font-bold text-gray-900 sm:text-4xl">
                        Wir sind Ihr Partner für die Zukunft
                    </p>
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Ärgern Sie sich nicht länger über Terminabsprachen,
                        Wartezeiten und unzuverlässige Dienstleister. Wir bieten
                        Ihnen eine einfache und schnelle Lösung für Ihre
                        Energieausweise. Mit unserem Business Partner Programm
                        können Sie sich auf Ihre Kernkompetenzen konzentrieren
                        und wir kümmern uns um die Erstellung der
                        Energieausweise.
                    </p>
                </div>

                <div class="bg-white py-16 lg:py-24">
                    <div
                        class="mx-auto grid max-w-5xl grid-cols-1 gap-10 px-0 sm:px-6 lg:grid-cols-12 lg:gap-8 lg:px-8">
                        <div
                            class="max-w-xl text-xl font-bold tracking-tight text-gray-900 sm:text-2xl lg:col-span-6">
                            <h2 class="inline sm:block lg:inline xl:block">
                                Jetzt E-Mail Adresse eintragen und Angebot
                                einholen!
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
                                <el-form-item>
                                    <!--                                        class="flex-none rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">-->
                                    <bz-button
                                        @click="subscribe"
                                        class="flex-none h-full">
                                        Angebot einholen
                                    </bz-button>
                                </el-form-item>
                            </div>
                            <p class="text-sm leading-6 text-gray-900">
                                Deine Daten sind uns wichtig. Lies unseren
                                <Link
                                    :href="route('datenschutz')"
                                    class="font-semibold text-blue-600 hover:text-blue-500"
                                    >Datenschutz&nbsp;</Link
                                >.
                            </p>
                        </el-form>
                    </div>
                </div>

                <div class="mx-auto mt-16 max-w-2xl lg:mt-16 lg:max-w-6xl">
                    <dl
                        class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-10 lg:max-w-none lg:grid-cols-3 lg:gap-y-16">
                        <div
                            v-for="feature in features"
                            :key="feature.name"
                            class="relative pl-16">
                            <dt
                                class="text-base font-semibold leading-7 text-gray-900">
                                <div
                                    class="absolute left-0 top-0 flex h-10 w-10 items-center justify-center rounded-lg bg-blue-600">
                                    <component
                                        :is="feature.icon"
                                        class="h-6 w-6 text-white"
                                        aria-hidden="true" />
                                </div>
                                {{ feature.name }}
                            </dt>
                            <dd class="mt-2 text-base leading-7 text-gray-600">
                                {{ feature.description }}
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
    FingerPrintIcon,
    LockClosedIcon,
    RocketLaunchIcon,
    ClockIcon,
    PhoneIcon,
    ReceiptPercentIcon,
    ChatBubbleOvalLeftIcon,
    GiftIcon,
    UserGroupIcon,
    PaperAirplaneIcon,
} from '@heroicons/vue/24/outline';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import BzButton from '../../Components/BzButton.vue';
import { ElNotification } from 'element-plus';

const emailForm = useForm({
    email: '',
});

const subscribe = () => {
    emailForm.post(route('business.store'), {
        preserveScroll: true,
        onSuccess: () => {
            emailForm.reset();
            ElNotification({
                title: 'Vielen Dank!',
                message: 'Wir werden uns in Kürze bei Ihnen melden.',
                type: 'success',
            });
        },
    });
};

const features = [
    {
        name: 'Schnell',
        description:
            'Wir garantieren Ihnen Werktags die Lieferung des Energieausweises innerhalb von 24 Stunden. Geben Sie uns einfach die Daten und wir kümmern uns um den Rest.',
        icon: RocketLaunchIcon,
    },
    {
        name: 'Direkter Ansprechpartner',
        description:
            'Sie haben einen direkten Ansprechpartner, der Ihnen bei Fragen und Problemen zur Seite steht. Keine nervigen Warteschleifen. Wir sind für Sie da und kümmern uns um Ihre Anliegen.',
        icon: PhoneIcon,
    },
    {
        name: 'Monatliche Rechnung',
        description:
            'Mit unserem Partner Programm erhalten Sie monatliche Rechnungen und müssen nicht vorneweg für die Dienstleistung bezahlen. Sie zahlen nur für die Ausweise die Sie auch wirklich benötigen.',
        icon: ReceiptPercentIcon,
    },
    {
        name: 'Keine Fixkosten',
        description:
            'Sie zahlen nur für die Ausweise die Sie auch wirklich benötigen. Keine Fixkosten, keine versteckten Kosten. Sie zahlen nur für die Dienstleistung die Sie auch wirklich benötigen.',
        icon: GiftIcon,
    },
    {
        name: 'Team Verwaltung',
        description:
            'Verwalten Sie Ihr Team und Ihre Projekte in einem übersichtlichen Dashboard. Sie können jederzeit neue Projekte anlegen und Ihre Mitarbeiter hinzufügen. So haben Sie immer den Überblick.',
        icon: UserGroupIcon,
    },
    {
        name: 'Mitgestalten',
        description:
            'Sie haben Anregungen oder Wünsche? Wir setzen Ihre Wünsche um. Gestalten Sie das Produkt mit und helfen Sie uns dabei, die beste Lösung für Sie zu entwickeln.',
        icon: ChatBubbleOvalLeftIcon,
    },
    {
        name: 'Cloud-basiert',
        description:
            'All Ihre Projekte und Daten sind sicher gespeichert in der Cloud. Wir arbeiten ausschließlich mit deutschen Servern und können so die Sicherheit und Integrität Ihrer Daten garantieren. Nie wieder einen Ausweis verlieren oder vergessen.',
        icon: CloudArrowUpIcon,
    },
    {
        name: 'Sicherheit',
        description:
            'Die Sicherheit Ihrer Daten ist uns das größte Anliegen. Wir arbeiten ausschließlich mit Technologien die höchsten Sicherheitsstandards genügen. Alle Daten werden verschlüsselt übertragen und gespeichert.',
        icon: LockClosedIcon,
    },
    {
        name: 'Papierlos',
        description:
            'Wir arbeiten ausschließlich digital. Sie erhalten Ihre Ausweise als PDF und können diese direkt an Ihre Kunden weiterleiten. Nie wieder Papierkram und Aktenordner.',
        icon: PaperAirplaneIcon,
    },
];
</script>
