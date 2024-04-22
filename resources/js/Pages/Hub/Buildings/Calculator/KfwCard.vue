<script setup>
import { ref, watch } from 'vue';
import { neubau, sanierung } from './calculator';
import TargetCard from './TargetCard.vue';
import EnergyCertificateCard from './EnergyCertificateCard.vue';
import {
    ArrowDownTrayIcon,
    ArrowTopRightOnSquareIcon,
} from '@heroicons/vue/24/outline';
import BzCard from '../../Components/BzCard.vue';
import CustomerCard from './CustomerCard.vue';
import { InformationCircleIcon } from '@heroicons/vue/20/solid';
import ReasonCard from './ReasonCard.vue';
import StandardCard from './StandardCard.vue';
import BzButton from '../../../../Components/BzButton.vue';
import Badge from '../../../../Components/Badge.vue';

const props = defineProps({
    building: Object,
    credits: Object,
});

const reason = ref(null);
const hasEnergyCertificate = ref(null);
const targetKnown = ref(null);

const energyClass = ref(null);
const target = ref(null);

const hasBuilding = ref(false);
const salary = ref(90_000);
const kids = ref(0);
const eh = ref(false);
const la = ref(false);
const qng = ref(false);

const result = ref({
    programs: [],
    grants: [],
});

watch(reason, (value) => {
    if (value && value.name === 'Sanierung') {
        result.value = sanierung(
            target.value,
            energyClass.value,
            props.building.data.housing_units,
        );
    }
    if (value && value.name === 'Neubau') {
        result.value = neubau(
            hasBuilding.value,
            salary.value,
            kids.value,
            eh.value,
            la.value,
            qng.value,
            props.building.data.housing_units,
        );
    }
});

watch(energyClass, (value) => {
    result.value = sanierung(
        target.value,
        value,
        props.building.data.housing_units,
    );
});

watch(target, (value) => {
    result.value = sanierung(
        value,
        energyClass.value,
        props.building.data.housing_units,
    );
});

watch(hasBuilding, () => {
    computeNeubau();
});

watch(salary, () => {
    computeNeubau();
});

watch(kids, () => {
    computeNeubau();
});

watch(eh, () => {
    computeNeubau();
});

watch(la, () => {
    computeNeubau();
});

watch(qng, () => {
    computeNeubau();
});

const computeNeubau = () => {
    result.value = neubau(
        hasBuilding.value,
        salary.value,
        kids.value,
        eh.value,
        la.value,
        qng.value,
        props.building.data.housing_units,
    );
};

const foo = 1000;
</script>

<template>
    <bz-card>
        <template #title>KFW</template>
        <template #subtitle>Mögliche Förderkredite der KFW Bank</template>
        <template #content>
            <div
                class="px-6 py-4 grid grid-cols-3 gap-4 border-b border-gray-100">
                <reason-card v-model:reason="reason" :building="building" />

                <template v-if="reason?.name === 'Sanierung'">
                    <energy-certificate-card
                        :building="building"
                        v-model:has-energy-certificate="hasEnergyCertificate"
                        @energy-class="(e) => (energyClass = e)" />

                    <target-card
                        :building="building"
                        @target="(e) => (target = e)"
                        v-model:target-known="targetKnown" />
                </template>
                <template v-else>
                    <customer-card
                        :building="building"
                        v-model:has-building="hasBuilding"
                        v-model:salary="salary"
                        v-model:kids="kids" />
                    <standard-card
                        :building="building"
                        v-model:eh="eh"
                        v-model:la="la"
                        v-model:qng="qng" />
                </template>
            </div>

            <!-- Neubau -->
            <template v-if="result.programs?.length > 0">
                <div class="flex px-6 py-4 justify-between">
                    <div class="flex flex-col">
                        <span class="text-gray-900 font-semibold"
                        >Mögliche Förderungen</span
                        >
                        <p class="text-xs text-gray-500">
                            Kontaktieren Sie und bzgl. einer BzA. In diesem Zuge
                            werden Sie über mögliche zusätzliche und
                            individuelle Förderungen informiert.
                        </p>
                    </div>
                    <bz-button type="secondary">
                        <arrow-down-tray-icon class="w-4 h-4 mr-2" />
                        PDF Ausdruck
                    </bz-button
                    >
                </div>
                <div class="px-6 pb-4">
                    <div class="bg-gray-100 p-6 sm:rounded-lg sm:p-8">
                        <div>
                            <dl class="-my-4 divide-y divide-gray-200 text-sm">
                                <div
                                    v-for="program in credits.credits"
                                    class="flex items-center justify-between py-4">
                                    <dt
                                        class="text-gray-600 font-semibold flex items-baseline">
                                        Summe
                                        <badge
                                            class="ml-2"
                                            :label="
                                                'ab ' +
                                                program.credit_conditions[0]
                                                    .interest +
                                                '%'
                                            "
                                            size="sm" />
                                        <a
                                            class="text-primary flex text-xs hover:underline ml-2"
                                            :href="program.link"
                                            target="_blank">
                                            {{ program.name }}
                                            <arrow-top-right-on-square-icon
                                                class="w-3 h-3 ml-1" />
                                        </a>
                                    </dt>
                                    <dd class="font-medium text-gray-900">
                                        {{
                                            parseFloat(
                                                program.amount,
                                            ).toLocaleString('de-DE', {
                                                style: 'currency',
                                                currency: 'EUR',
                                            })
                                        }}
                                    </dd>
                                </div>
                                <div
                                    v-for="grant in result.grants"
                                    class="flex items-center justify-between py-4">
                                    <dt class="text-gray-600 font-semibold">
                                        Zuschuss
                                        <badge
                                            class="ml-2"
                                            :label="grant.tag"
                                            size="sm" />
                                    </dt>
                                    <dd class="font-medium text-gray-900">
                                        {{
                                            grant.summe.toLocaleString(
                                                'de-DE',
                                                {
                                                    style: 'currency',
                                                    currency: 'EUR',
                                                },
                                            )
                                        }}
                                    </dd>
                                </div>
                                <div
                                    class="flex items-center justify-between py-4">
                                    <dt
                                        class="text-base font-bold text-gray-900">
                                        Gesamt Summe
                                    </dt>
                                    <dd
                                        class="text-base font-bold text-gray-900">
                                        {{
                                            result?.programs
                                                .reduce(
                                                    (acc, cur) =>
                                                        (acc += cur.summe),
                                                    0,
                                                )
                                                .toLocaleString('de-DE', {
                                                    style: 'currency',
                                                    currency: 'EUR',
                                                })
                                        }}
                                    </dd>
                                </div>
                                <div
                                    class="flex items-center justify-between py-4">
                                    <dt
                                        class="text-base font-bold text-gray-900">
                                        Davon Zuschuss
                                    </dt>
                                    <dd
                                        class="text-base font-bold text-gray-900">
                                        {{
                                            result.grants
                                                .reduce(
                                                    (acc, cur) =>
                                                        (acc += cur.summe),
                                                    0,
                                                )
                                                .toLocaleString('de-DE', {
                                                    style: 'currency',
                                                    currency: 'EUR',
                                                })
                                        }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>

                <div class="rounded-md bg-blue-50 p-4 mx-6 mb-4">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <InformationCircleIcon
                                class="h-5 w-5 text-blue-400"
                                aria-hidden="true" />
                        </div>
                        <div class="ml-3 flex-1 md:flex md:justify-between">
                            <p
                                v-if="reason.name === 'Sanierung'"
                                class="text-sm text-blue-700">
                                Bei serieller Sanierung kommen weitere 15%
                                Zuschuss hinzu. Zudem wird die Baubegleitung
                                noch einmal extra gefördert (bis zu 20.000,00€).
                            </p>
                            <template v-else>
                                <p class="text-sm text-blue-700">
                                    Die Nachhaltigkeitszertifizierung wird
                                    ebenso gefördert wie die Energieberatung.
                                </p>
                                <p class="mt-3 text-sm md:ml-6 md:mt-0">
                                    <a
                                        href="#"
                                        class="whitespace-nowrap font-medium text-blue-700 hover:text-primary">
                                        Jetzt Termin vereinbaren
                                        <span aria-hidden="true"> &rarr;</span>
                                    </a>
                                </p>
                            </template>
                        </div>
                    </div>
                </div>

                <div v-for="program in result.programs" :key="program.key">
                    <span class="text-gray-500 text-xs px-6"
                    >Kreditkonditionen {{ program.key }}</span
                    >
                    <div class="px-6 pb-4 flex flex-col space-y-1">
                        <div
                            v-for="condition in program.conditions"
                            class="px-6 py-2 rounded-lg bg-gray-50 flex items-center justify-between">
                            <badge
                                size="sm"
                                :label="condition.zins + '%'"
                                type="success" />
                            <span class="text-xs text-gray-500"
                            >Laufzeit {{ condition.laufzeit }}</span
                            >
                            <span class="text-xs text-gray-500"
                            >Zinsbindung
                                {{ condition.zinsbindung }}</span
                            >
                            <span class="text-xs text-gray-500"
                            >Tilgungsfreie Zeit
                                {{ condition.tilgungsfrei }}
                            </span>
                        </div>
                    </div>
                </div>
            </template>
        </template>
    </bz-card>
</template>
