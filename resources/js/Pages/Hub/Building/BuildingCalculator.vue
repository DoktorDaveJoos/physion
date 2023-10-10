<script setup>
import { Head } from '@inertiajs/vue3';
import BuildingShowWrapper from './Show/BuildingShowWrapper.vue';
import BzCard from '../Components/BzCard.vue';
import Badge from '../../../Components/Badge.vue';
import dayjs from 'dayjs';
import IsfpCard from './Calculator/IsfpCard.vue';
import HeatingCard from './Calculator/HeatingCard.vue';
import KfwCard from './Calculator/KfwCard.vue';
import { filterActions } from './Calculator/calculator';
import { computed, ref, watch } from 'vue';
import RenewableCard from './Calculator/RenewableCard.vue';
import { InformationCircleIcon, XCircleIcon } from '@heroicons/vue/20/solid';

const props = defineProps({
    building: Object,
});

const isfpExists = ref(!!props.building.data.products.isfp.id);

const getActions = ref(
    filterActions(
        props.building.data.construction_year,
        props.building.data.ventilation,
        props.building.data.heatingSystems,
        props.building.data.renewableEnergyInstallations,
        isfpExists.value,
        null
    )
);

watch(isfpExists, (value) => {
    getActions.value = filterActions(
        props.building.data.construction_year,
        props.building.data.ventilation,
        props.building.data.heatingSystems,
        props.building.data.renewableEnergyInstallations,
        isfpExists.value,
        null
    );
});

const getClusterTotal = (cluster) => {
    return cluster.reduce((a, b) => a + b.price, 0);
};

const getClusterCustomerPays = (cluster) => {
    return (
        cluster.reduce((a, b) => a + b.price, 0) -
        cluster.reduce((a, b) => a + b.grant, 0)
    );
};

const getClusterTotalGrant = (cluster) => {
    return cluster.reduce((a, b) => a + b.grant, 0);
};

const mapping = {
    heating: 'Heizungssysteme',
    envelope: 'Gebäudehülle',
    system: 'Anlagentechnik',
    consulting: 'Beratung',
};
</script>

<template>
    <Head>
        <title>Förderung & Zuschuss</title>
    </Head>

    <building-show-wrapper :building="building">
        <kfw-card class="mt-4" :building="building" />

        <bz-card class="mt-4">
            <template #title
                >Bafa
                <badge
                    v-if="building.data.construction_year >= dayjs().year()"
                    type="error"
                    label="Kein Neubau"
                    size="sm" />
            </template>
            <template #subtitle>Mögliche Zuschüsse durch die Bafa</template>
            <template #content>
                <el-empty
                    v-if="building.data.construction_year >= dayjs().year()"
                    description="Keine Einzelmaßnahmen für Neubauten" />
                <template v-else>
                    <div
                        class="px-6 py-4 grid grid-cols-3 gap-4 border-b border-gray-100">
                        <isfp-card
                            :building="building"
                            v-model:isfp="isfpExists" />
                        <heating-card :building="building" />
                        <renewable-card :building="building" />
                    </div>
                    <div class="py-4 space-y-4 px-6">
                        <div
                            v-if="!isfpExists"
                            class="rounded-md bg-red-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <XCircleIcon
                                        class="h-5 w-5 text-red-400"
                                        aria-hidden="true" />
                                </div>
                                <div class="ml-3">
                                    <h3
                                        class="text-sm font-medium text-red-800">
                                        Ein Sanierungsfahrplan (iSFP) sollte
                                        unbedingt erstellt werden um auf
                                        Einzelmaßnahmen weitere
                                        <strong>5%</strong> Zuschuss zu
                                        erhalten.
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="rounded-md bg-blue-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <InformationCircleIcon
                                        class="h-5 w-5 text-blue-400"
                                        aria-hidden="true" />
                                </div>
                                <div
                                    class="ml-3 flex-1 flex flex-col md:justify-between">
                                    <p class="text-sm text-blue-700">
                                        Die förderfähige Summe für dieses
                                        Gebäude entspricht
                                        <strong>
                                            maximal
                                            {{
                                                parseInt(
                                                    '60000'
                                                ).toLocaleString('DE-de', {
                                                    style: 'currency',
                                                    currency: 'EUR',
                                                })
                                            }}
                                        </strong>
                                        pro Jahr.
                                    </p>
                                    <p class="text-sm text-blue-700">
                                        Die
                                        <strong>folgenden Auflistungen</strong>
                                        sind mögliche Maßnahmen für dieses
                                        Gebäude mit
                                        <strong
                                            >geschätzten
                                            Aufwendungskosten</strong
                                        >. Keine Gewähr für die Genauigkeit der
                                        Angaben.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div v-for="(cluster, idx) in getActions" :key="idx">
                            <div class="px-4 pb-1">
                                <span
                                    class="text-sm font-semibold text-gray-700"
                                    >{{ mapping[idx] }}</span
                                >
                            </div>
                            <div v-if="cluster.length > 0">
                                <div
                                    class="px-4 sm:px-6 lg:px-8 py-4 rounded-lg bg-gray-50">
                                    <div class="-mx-4 flow-root sm:mx-0">
                                        <table class="min-w-full">
                                            <colgroup>
                                                <col class="w-full sm:w-1/2" />
                                                <col class="sm:w-1/6" />
                                                <col class="sm:w-1/6" />
                                                <col class="sm:w-1/6" />
                                            </colgroup>
                                            <thead
                                                class="border-b border-gray-300 text-gray-900">
                                                <tr>
                                                    <th
                                                        scope="col"
                                                        class="pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">
                                                        Maßnahme
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="hidden px-3 text-right text-sm font-semibold text-gray-900 sm:table-cell">
                                                        Geschätzter Gesamtpreis
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="hidden px-3 text-right text-sm font-semibold text-gray-900 sm:table-cell">
                                                        Zuschüsse
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="pl-3 pr-4 text-right text-sm font-semibold text-gray-900 sm:pr-0">
                                                        Auszahlung
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="project in cluster"
                                                    :key="project.id"
                                                    class="border-b border-gray-200">
                                                    <td
                                                        class="max-w-0 py-2 pl-4 pr-3 text-sm sm:pl-0">
                                                        <div
                                                            class="font-semibold text-gray-900">
                                                            {{ project.name }}
                                                        </div>
                                                        <div
                                                            class="mt-1 truncate text-gray-500">
                                                            {{
                                                                project.description
                                                            }}
                                                        </div>
                                                    </td>
                                                    <td
                                                        class="hidden px-3 py-2 text-right text-sm text-gray-500 sm:table-cell">
                                                        {{
                                                            project.price.toLocaleString(
                                                                'DE-de',
                                                                {
                                                                    style: 'currency',
                                                                    currency:
                                                                        'EUR',
                                                                }
                                                            )
                                                        }}
                                                    </td>
                                                    <td
                                                        class="hidden px-3 py-2 text-right text-sm text-gray-500 sm:table-cell space-x-1">
                                                        <badge
                                                            v-for="percent in project.percent"
                                                            :label="
                                                                percent * 100 +
                                                                '%'
                                                            "
                                                            size="sm" />
                                                    </td>
                                                    <td
                                                        class="py-2 pl-3 pr-4 text-right text-sm text-gray-500 sm:pr-0">
                                                        {{
                                                            project.grant.toLocaleString(
                                                                'DE-de',
                                                                {
                                                                    style: 'currency',
                                                                    currency:
                                                                        'EUR',
                                                                }
                                                            )
                                                        }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th
                                                        scope="row"
                                                        colspan="3"
                                                        class="hidden pl-4 pr-3 pt-2 text-right text-sm font-normal text-gray-500 sm:table-cell sm:pl-0">
                                                        Gesamtkosten
                                                    </th>
                                                    <th
                                                        scope="row"
                                                        class="pl-4 pr-3 pt-2 text-left text-sm font-normal text-gray-500 sm:hidden">
                                                        Gesamtkosten
                                                    </th>
                                                    <td
                                                        class="pl-3 pr-4 pt-2 text-right text-sm text-gray-500 sm:pr-0">
                                                        {{
                                                            getClusterTotal(
                                                                cluster
                                                            ).toLocaleString(
                                                                'DE-de',
                                                                {
                                                                    style: 'currency',
                                                                    currency:
                                                                        'EUR',
                                                                }
                                                            )
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th
                                                        scope="row"
                                                        colspan="3"
                                                        class="hidden pl-4 pr-3 pt-2 text-right text-sm font-normal text-gray-500 sm:table-cell sm:pl-0">
                                                        Antragsteller zahlt
                                                    </th>
                                                    <th
                                                        scope="row"
                                                        class="pl-4 pr-3 pt-2 text-left text-sm font-normal text-gray-500 sm:hidden">
                                                        Antragsteller zahlt
                                                    </th>
                                                    <td
                                                        class="pl-3 pr-4 pt-2 text-right text-sm text-gray-500 sm:pr-0">
                                                        {{
                                                            getClusterCustomerPays(
                                                                cluster
                                                            ).toLocaleString(
                                                                'DE-de',
                                                                {
                                                                    style: 'currency',
                                                                    currency:
                                                                        'EUR',
                                                                }
                                                            )
                                                        }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th
                                                        scope="row"
                                                        colspan="3"
                                                        class="hidden pl-4 pr-3 pt-2 text-right text-sm font-semibold text-gray-900 sm:table-cell sm:pl-0">
                                                        Zuschuss Bafa
                                                    </th>
                                                    <th
                                                        scope="row"
                                                        class="pl-4 pr-3 pt-2 text-left text-sm font-semibold text-gray-900 sm:hidden">
                                                        Zuschuss Bafa
                                                    </th>
                                                    <td
                                                        class="pl-3 pr-4 pt-2 text-right text-sm font-bold text-gray-900 sm:pr-0">
                                                        {{
                                                            getClusterTotalGrant(
                                                                cluster
                                                            ).toLocaleString(
                                                                'DE-de',
                                                                {
                                                                    style: 'currency',
                                                                    currency:
                                                                        'EUR',
                                                                }
                                                            )
                                                        }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </bz-card>
    </building-show-wrapper>
</template>
