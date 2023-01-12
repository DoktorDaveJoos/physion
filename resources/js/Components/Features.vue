<template>
    <div class="overflow-hidden bg-gray-50 py-16 lg:py-24 z-10">
        <div class="relative mx-auto max-w-xl px-6 lg:max-w-7xl lg:px-8">
            <svg class="absolute left-full hidden -translate-x-1/2 -translate-y-1/4 transform lg:block" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
                <defs>
                    <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)" />
            </svg>

            <div class="relative">
                <h2 class="text-center text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">Was Bauzertifikate besser kann</h2>
                <p class="mx-auto mt-4 max-w-6xl text-center text-xl text-gray-500">Bauzertifikate bietet eine umfassende Palette an Dienstleistungen, einschließlich des Verkaufs von Energieausweisen, Ratgebern und dem BIRN Zertifikat. Dabei legen wir größten Wert auf die Verwendung der neuesten Technologien, die Erfüllung höchster Qualitätsstandards und eine benutzerfreundliche Erfahrung für unsere Kunden.</p>
            </div>

            <div class="relative mt-12 lg:mt-24 lg:grid lg:grid-cols-2 lg:items-center lg:gap-12">
                <div class="relative">
                    <h3 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Energieausweise</h3>
                    <p class="mt-3 text-lg text-gray-500">Bauzertifikate bietet nicht nur den Verkauf von Energieausweisen an, sondern auch einen umfassenden Service dazu, einschließlich Beratung, Unterstützung und schneller Abwicklung. Wir legen Wert auf Qualität und Zufriedenheit unserer Kunden.</p>

                    <dl class="mt-10 space-y-10">
                        <div v-for="item in transferFeatures" :key="item.id" class="relative">
                            <dt>
                                <div class="absolute flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500 text-white">
                                    <component :is="item.icon" class="h-6 w-6" aria-hidden="true" />
                                </div>
                                <p class="ml-16 text-lg font-medium leading-6 text-gray-900">{{ item.name }}</p>
                            </dt>
                            <dd class="mt-2 ml-16 text-base text-gray-500">{{ item.description }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="relative -mx-4 mt-10 lg:mt-0" aria-hidden="true">
                    <img class="relative mx-auto w-full" src="/preview-consumption.svg" alt="" />
                </div>
            </div>

            <svg class="absolute right-full hidden translate-x-1/2 translate-y-12 transform lg:block" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
                <defs>
                    <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                        <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                    </pattern>
                </defs>
                <rect width="404" height="784" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
            </svg>

            <div class="relative mt-12 sm:mt-16 lg:mt-24">
                <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:items-center lg:gap-8">
                    <div class="lg:col-start-2">
                        <h3 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Den Kunde im Blick</h3>
                        <p class="mt-3 text-lg text-gray-500">Die Erfüllung der Anforderungen an Nachweise im Baubereich kann mitunter stressig sein. Aus diesem Grund bieten wir Ihnen eine unkomplizierte Lösung, um diese Herausforderungen zu minimieren.</p>

                        <dl class="mt-10 space-y-10">
                            <div v-for="item in communicationFeatures" :key="item.id" class="relative">
                                <dt>
                                    <div class="absolute flex h-12 w-12 items-center justify-center rounded-xl bg-blue-500 text-white">
                                        <component :is="item.icon" class="h-6 w-6" aria-hidden="true" />
                                    </div>
                                    <p class="ml-16 text-lg font-medium leading-6 text-gray-900">{{ item.name }}</p>
                                </dt>
                                <dd class="mt-2 ml-16 text-base text-gray-500">{{ item.description }}</dd>
                            </div>
                        </dl>
                    </div>

                    <div class="relative -mx-4 mt-10 lg:col-start-1 lg:mt-0">
                        <svg class="absolute left-1/2 -translate-x-1/2 translate-y-16 transform lg:hidden" width="784" height="404" fill="none" viewBox="0 0 784 404" aria-hidden="true">
                            <defs>
                                <pattern id="e80155a9-dfde-425a-b5ea-1f6fadd20131" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                                    <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
                                </pattern>
                            </defs>
                            <rect width="784" height="404" fill="url(#e80155a9-dfde-425a-b5ea-1f6fadd20131)" />
                        </svg>
                        <img class="relative mx-auto" width="490" src="https://tailwindui.com/img/features/feature-example-2.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {
    BoltIcon,
    ScaleIcon,
    ShieldCheckIcon,
    ForwardIcon,
    CloudIcon,
    CreditCardIcon,
} from '@heroicons/vue/24/outline'

const transferFeatures = [
    {
        id: 1,
        name: 'Höchste Sicherheit',
        description:
            'Wir bieten Ihnen die höchste Sicherheit, sowohl in technischer als auch in rechtlicher Hinsicht. Von der Zahlung bis zur Ausstellung des Energieausweises.',
        icon: ShieldCheckIcon,
    },
    {
        id: 2,
        name: 'Keine versteckten Kosten',
        description:
            'Bei uns müssen Sie sich keine Sorgen über versteckte Kosten machen. Wir legen alle Preise und Gebühren offen und transparent dar, sodass Sie von Anfang an genau wissen, was Sie erwartet.',
        icon: ScaleIcon,
    },
    {
        id: 3,
        name: 'Sofortige Ausstellung',
        description:
            'Wir bearbeiten Ihren Auftrag mit höchster Priorität und gewährleisten eine effiziente Bearbeitung. Unsere qualifizierten Experten überprüfen jeden Ausweis gemäß geltender Gesetzgebung, um sicherzustellen, dass alle Anforderungen erfüllt werden.',
        icon: BoltIcon,
    },
]
const communicationFeatures = [
    {
        id: 1,
        name: 'Schnelle Erfassung',
        description:
            'Unser oberstes Ziel ist es, die Zufriedenheit unserer Kunden sicherzustellen. Um dies zu erreichen, haben wir unsere Datenerfassungsprozesse optimiert, um unseren Kunden ein reibungsloses und angenehmes Erlebnis zu bieten.',
        icon: ForwardIcon,
    },
    {
        id: 2,
        name: 'Cloud-basiert',
        description:
            'Wir haben unsere Plattform in die Cloud migriert, um unseren Kunden die Möglichkeit zu geben, von überall aus auf ihre Daten zuzugreifen. Sie können Ihre Daten jederzeit und überall einsehen, ohne sich Gedanken über die Sicherheit Ihrer Daten machen zu müssen.',
        icon: CloudIcon,
    },
    {
        id: 2,
        name: 'Einfache Bezahlung',
        description:
            'Wir bieten Ihnen eine Reihe von Zahlungsmöglichkeiten, um Ihren Bedürfnissen gerecht zu werden. Sie können zwischen Kreditkarte, Lastschrift, PayPal, Sofortüberweisung und Klarna (Rechnung) wählen.',
        icon: CreditCardIcon,
    },
]
</script>
