<script setup>
import { CheckCircleIcon, XCircleIcon } from '@heroicons/vue/20/solid';
import { Link, usePage } from '@inertiajs/vue3';

const { order, category, page, signature } = usePage().props;

const steps = {
    vrbr_partner: [
        {
            key: 'general',
            name: 'Allgemein',
            description: 'Auftragserfassung und allgemeine Daten',
            status: 'upcoming',
        },
        {
            key: 'details',
            name: 'Gebäudedetails',
            description: 'Spezifische Daten zum Gebäude',
            status: 'upcoming',
        },
        {
            key: 'consumption',
            name: 'Verbrauchsdaten ',
            description: 'Daten zum bisherigen Verbrauch des Gebäudes',
            status: 'upcoming',
        },
        {
            key: 'summary',
            name: 'Abschluss',
            description: 'Prüfen und schließen Sie den Auftrag ab',
            status: 'upcoming',
        },
    ],

    bdrf_partner: [
        {
            key: 'general',
            name: 'Allgemein',
            description: 'Auftragserfassung und allgemeine Daten',
            status: 'upcoming',
        },
        {
            key: 'details',
            name: 'Gebäudedetails',
            description: 'Spezifische Daten zum Gebäude',
            status: 'upcoming',
        },
        {
            key: 'position',
            name: 'Lage & Grundriss',
            description: 'Angaben zur Bemaßung und Lage des Gebäudes',
            status: 'upcoming',
        },
        {
            key: 'thermal',
            name: 'Thermische Hülle',
            description: 'Außenwand, Dach und Keller',
            status: 'upcoming',
        },
        {
            key: 'energy',
            name: 'Energie',
            description: 'Heizung, Warmwasser und Energiegewinnung',
            status: 'upcoming',
        },
        {
            key: 'summary',
            name: 'Abschluss',
            description: 'Prüfen und schließen Sie den Auftrag ab',
            status: 'upcoming',
        },
    ],
};

const to = (page) => {
    return route('hub.certificates.show', {
        order: order.slug,
        page: page,
        signature: route().params.signature,
    });
};
</script>

<template>
    <nav class="flex flex-1 flex-col" aria-label="Sidebar">
        <ul role="list" class="-mx-2 space-y-1">
            <li v-for="item in steps[category]" :key="item.name">
                <template v-if="order">
                    <Link
                        :href="to(item.key)"
                        :class="[
                            item.key === (page ?? 'general')
                                ? 'bg-gray-50 text-primary'
                                : 'text-gray-700 hover:text-primary hover:bg-gray-100',
                            'group flex gap-x-3 rounded-md p-2 pl-3 text-sm font-semibold',
                        ]">
                        <div class="flex w-full items-center">
                            <span>
                                {{ item.name }}
                            </span>
                            <CheckCircleIcon
                                v-if="order?.meta?.steps?.includes(item.key)"
                                :class="[
                                    item.key === (page ?? 'general')
                                        ? 'text-blue-500'
                                        : 'text-gray-300',
                                    'ml-2 h-5 w-5 group-hover:text-blue-400',
                                ]"></CheckCircleIcon>
                        </div>
                    </Link>
                </template>
                <template v-else>
                    <Link
                        v-if="item.key === 'general'"
                        :href="
                            route('hub.orders.create', { category: category })
                        "
                        class="bg-gray-50 text-primary group flex gap-x-3 rounded-md p-2 pl-3 text-sm leading-6 font-semibold"
                        >{{ item.name }}
                    </Link>
                    <div
                        v-else
                        class="text-gray-400 flex gap-x-3 rounded-md p-2 pl-3 text-sm leading-6 font-semibold">
                        {{ item.name }}
                    </div>
                </template>
            </li>
        </ul>
    </nav>
</template>
