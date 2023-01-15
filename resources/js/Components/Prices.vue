<!-- This example requires Tailwind CSS v3.0+ -->
<template>
    <section id="prices" class="bg-blue-600">
        <div class="relative overflow-hidden pt-32 pb-96 lg:pt-40">
            <div><img class="absolute bottom-0 left-1/2 w-[1440px] max-w-none -translate-x-1/2" src="/background-call-to-action%20Kopie.jpg" alt="" /></div>
            <div class="relative mx-auto max-w-7xl px-6 text-center lg:px-8">
                <div class="mx-auto max-w-2xl lg:max-w-4xl">
                    <h2 class="text-lg font-semibold leading-8 text-blue-400">Produktkategorie</h2>
                    <p class="mt-2 text-4xl font-bold tracking-tight text-white">Energieausweise</p>
                    <p class="mt-6 text-lg leading-8 text-white/60">Die Produktkategorie Energieausweise bietet eine umfassende Dokumentation über den Energieverbrauch von Gebäuden und dient als offizielles Dokument für die Energieeffizienz von Gebäuden.</p>
                </div>
            </div>
        </div>
        <div class="flow-root bg-white pb-24 lg:pb-24">
            <div class="relative -mt-80">
                <div class="relative z-10 mx-auto max-w-7xl px-6 lg:px-8">
                    <div class="mx-auto grid max-w-md grid-cols-1 gap-8 lg:max-w-4xl lg:grid-cols-2 lg:gap-8">
                        <div v-for="tier in tiers" :key="tier.name" class="flex flex-col rounded-3xl bg-white shadow-xl ring-1 ring-black/10">
                            <div class="p-8 sm:p-10">
                                <h3 class="text-lg font-semibold leading-8 tracking-tight text-blue-600" :id="tier.id">{{ tier.name }}</h3>
                                <div class="mt-4 flex text-5xl font-bold tracking-tight text-gray-900">
                                    € {{ tier.priceMonthly.split(',')[0] }}
                                    <span class="text-2xl mt-1 ml-1">{{ tier.priceMonthly.split(',')[1] }}</span>
                                </div>
                                <p class="mt-6 text-base leading-7 text-gray-600">{{ tier.description }}</p>
                            </div>
                            <div class="flex flex-1 flex-col p-2">
                                <div class="flex flex-1 flex-col justify-between rounded-2xl bg-gray-50 p-6 sm:p-8">
                                    <ul role="list" class="space-y-6">
                                        <li v-for="feature in tier.features" :key="feature" class="flex items-start">
                                            <div class="flex-shrink-0">
                                                <CheckIcon class="h-6 w-6 text-blue-600" aria-hidden="true" />
                                            </div>
                                            <p class="ml-3 text-sm leading-6 text-gray-600">{{ feature }}</p>
                                        </li>
                                    </ul>
                                    <div class="mt-8">
                                        <a :href="tier.href" class="inline-block w-full rounded-lg bg-blue-600 px-4 py-4 text-center text-sm font-semibold leading-5 text-white shadow-md hover:bg-blue-700" :aria-describedby="tier.id">Jetzt erstellen</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="relative mx-auto mt-8 max-w-7xl px-6 lg:px-8">
                <div class="mx-auto max-w-md lg:max-w-4xl">
                    <div class="flex flex-col gap-6 rounded-3xl p-8 ring-1 ring-gray-900/10 sm:p-10 lg:flex-row lg:items-center lg:gap-8">
                        <div class="lg:min-w-0 lg:flex-1">
                            <h3 class="text-lg font-semibold leading-8 tracking-tight text-blue-600">Unklar?</h3>
                            <div class="mt-2 text-base leading-7 text-gray-600">Finden Sie ganz einfach heraus welchen der Ausweise Sie brauchen mit unserem Energieausweis-Check Tool</div>
                        </div>
                        <div>
                            <a href="#" class="inline-block rounded-lg bg-blue-50 px-4 py-2.5 text-center text-sm font-semibold leading-5 text-blue-700 hover:bg-blue-100">Energieausweis-Check <span aria-hidden="true">&rarr;</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { CheckIcon } from '@heroicons/vue/24/outline'

const tiers = [
    {
        id: 'tier-hobby',
        name: 'Verbrauchsausweis',
        href: route('verbrauch.create'),
        priceMonthly: '79,90',
        description: 'Energieausweis, der auf Basis der Verbrauchswerte erstellt wird.',
        features: [
            'Einfache Erfassung in 3 Minuten',
            'Umgehende Bearbeitung',
            'Rechtsgültig für 10 Jahre',
            'Rechnung & Zahlungsbeleg',
        ],
    },
    {
        id: 'tier-team',
        name: 'Bedarfsausweis',
        href: route('bedarf.create'),
        priceMonthly: '149,90',
        description: 'Energieausweis, der den Energiebedarf des Gebäudes rechnerisch ermittelt.',
        features: [
            'Einfache Erfassung in 5 Minuten',
            'Keine Verbrauchsdaten erforderlich',
            'Umgehende Bearbeitung',
            'Rechtsgültig für 10 Jahre',
            'Rechnung & Zahlungsbeleg',
        ],
    },
]
</script>
