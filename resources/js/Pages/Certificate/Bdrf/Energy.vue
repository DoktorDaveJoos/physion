<script setup>
import FormHeader from '../../../Components/FormHeader.vue';
import InformationBox from '../../../Components/InformationBox.vue';
import Badge from '../../../Components/Badge.vue';
import { computed, reactive, ref } from 'vue';
import BzButton from '../../../Components/BzButton.vue';
import { useForm, router, usePage } from '@inertiajs/vue3';
import { ElDrawer, ElNotification } from 'element-plus';
import { BoltIcon, FireIcon, TrashIcon } from '@heroicons/vue/24/outline';
import PageWrapper from '../../../Wrappers/PageWrapper.vue';

const props = defineProps({
    order: Object,
});

const active = ref('wall');
const drawer = reactive({
    energy_systems: false,
    renewables: false,
});

const form = useForm({
    heating: [],
    type: null,
    system: null,
    is_main: false,
    construction_year: null,
    water_included: false,
    comment: null,
});

const rForm = useForm({
    type: null,
    area: null,
    construction_year: null,
    electricity: false,
    heating: false,
    water: false,
    comment: null,
});

const cancelSource = () => {
    form.reset();
    drawer.energy_systems = false;
};

const cancelRenewable = () => {
    rForm.reset();
    drawer.renewables = false;
};

const submit = () => {
    const url = usePage().props.user
        ? route('hub.certificates.update', {
              order: props.order.slug,
              page: 'energy',
          })
        : route('certificate.store', {
              order: props.order.slug,
              page: 'energy',
              signature: route().params.signature,
          });

    router.put(url);
};

const addHeatingSystem = () => {
    form.transform((data) => ({
        ...data,
        type: data.heating[0],
        system: data.heating[1],
        is_main: props.order.certificate.heating_systems.length === 0,
    })).put(
        route('bdrf.heating', {
            bdrf: props.order.certificate.id,
            signature: route().params.signature,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                drawer.energy_systems = false;
                form.reset();
                ElNotification({
                    title: 'Gespeichert',
                    message: 'Heizung erfolgreich gespeichert',
                    type: 'success',
                });
            },
            onError: () => {
                ElNotification({
                    title: 'Fehler',
                    message: 'Heizung konnte nicht gespeichert werden',
                    type: 'error',
                });
            },
        }
    );
};

const addRenewables = () => {
    rForm.put(
        route('bdrf.renewable', {
            bdrf: props.order.certificate.id,
            signature: route().params.signature,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                drawer.renewables = false;
                rForm.reset();
                ElNotification({
                    title: 'Gespeichert',
                    message: 'Erneuerbare Energien erfolgreich gespeichert',
                    type: 'success',
                });
            },
            onError: () => {
                ElNotification({
                    title: 'Fehler',
                    message:
                        'Erneuerbare Energie konnte nicht gespeichert werden',
                    type: 'error',
                });
            },
        }
    );
};

const deleteHeatingSystem = (id) => {
    form.delete(
        route('bdrf.heating.delete', {
            bdrf: props.order.certificate.id,
            signature: route().params.signature,
            heatingSystem: id,
        }),
        {
            preserveScroll: true,
            onError: () => {
                ElNotification({
                    title: 'Fehler',
                    message: 'Heizung konnte nicht gelöscht werden',
                    type: 'error',
                });
            },
        }
    );
};
const deleteRenewable = (id) => {
    form.delete(
        route('bdrf.renewable.delete', {
            bdrf: props.order.certificate.id,
            signature: route().params.signature,
            renewableEnergyInstallation: id,
        }),
        {
            preserveScroll: true,
            onError: () => {
                ElNotification({
                    title: 'Fehler',
                    message:
                        'Erneuerbare Energien konnte nicht gelöscht werden',
                    type: 'error',
                });
            },
        }
    );
};

const waterCovered = computed(
    () =>
        props.order.certificate.heating_systems.filter(
            (item) => item.water_included
        ).length > 0 ||
        props.order.certificate.renewable_energy_installations.filter(
            (item) => item.water
        ).length > 0
);

const options = [
    {
        value: 'Gasheizung',
        label: 'Gasheizung',
        children: [
            {
                value: 'Erdgas-Brennwertkessel',
                label: 'Erdgas-Brennwertkesselgel',
            },
            {
                value: 'Erdgas-Niedertemperaturkessel',
                label: 'Erdgas-Niedertemperaturkessel',
            },
            {
                value: 'Gas-Brennwerttherme',
                label: 'Gas-Brennwerttherme',
            },
            {
                value: 'Kombitherme (für Heizung und Warmwasserbereitung)',
                label: 'Kombitherme (für Heizung und Warmwasserbereitung)',
            },
        ],
    },
    {
        value: 'Ölheizung',
        label: 'Ölheizung',
        children: [
            {
                value: 'Öl-Brennwertkessel',
                label: 'Öl-Brennwertkessel',
            },
            {
                value: 'Öl-Niedertemperaturkessel',
                label: 'Öl-Niedertemperaturkessel',
            },
        ],
    },
    {
        value: 'Fernwärme',
        label: 'Fernwärme',
        children: [
            {
                value: 'Blockheizkraftwerk (BHKW) mit Fernwärmeanschluss',
                label: 'Blockheizkraftwerk (BHKW) mit Fernwärmeanschluss',
            },
            {
                value: 'Wärmepumpe mit Fernwärme',
                label: 'Wärmepumpe mit Fernwärme',
            },
        ],
    },
    {
        value: 'Holzheizung',
        label: 'Holzheizung',
        children: [
            {
                value: 'Holzpelletkessel',
                label: 'Holzpelletkessel',
            },
            {
                value: 'Holzvergaserkessel',
                label: 'Holzvergaserkessel',
            },
            {
                value: 'Kamin- und Kachelöfen mit Wassertasche (Wasserführende Kaminöfen)',
                label: 'Kamin- und Kachelöfen mit Wassertasche (Wasserführende Kaminöfen)',
            },
        ],
    },
    {
        value: 'Wärmepumpe',
        label: 'Wärmepumpe',
        children: [
            {
                value: 'Luft-Wasser-Wärmepumpe',
                label: 'Luft-Wasser-Wärmepumpe',
            },
            {
                value: 'Erdwärmepumpe (Geothermie)',
                label: 'Erdwärmepumpe (Geothermie)',
            },
            {
                value: 'Wasser-Wasser-Wärmepumpe',
                label: 'Wasser-Wasser-Wärmepumpe',
            },
        ],
    },
    {
        value: 'Wärmepumpe',
        label: 'Wärmepumpe',
        children: [
            {
                value: 'Luft-Wasser-Wärmepumpe',
                label: 'Luft-Wasser-Wärmepumpe',
            },
            {
                value: 'Erdwärmepumpe (Geothermie)',
                label: 'Erdwärmepumpe (Geothermie)',
            },
            {
                value: 'Wasser-Wasser-Wärmepumpe',
                label: 'Wasser-Wasser-Wärmepumpe',
            },
        ],
    },
    {
        value: 'Elektroheizung',
        label: 'Elektroheizung',
        children: [
            {
                value: 'Elektroheizkessel',
                label: 'Elektroheizkessel',
            },
            {
                value: 'Nachtspeicherheizung',
                label: 'Nachtspeicherheizung',
            },
            {
                value: 'Infrarotheizung',
                label: 'Infrarotheizung',
            },
            {
                value: 'Elektro-Wärmepumpe',
                label: 'Elektro-Wärmepumpe',
            },
        ],
    },
];
</script>

<template>
    <page-wrapper>
        <information-box to="#infobox">
            <div v-if="active === 'wall'" class="flex flex-col">
                <Badge dot label="Energieträger"></Badge>
                <p class="text-xs text-gray-500 mt-2">
                    Geben Sie den Energieträger Ihres Gebäudes an. Stellen Sie
                    sicher, dass mindestens ein Energieträger für Warmwasser
                    zuständig ist.
                </p>
            </div>
        </information-box>

        <form-header
            subtitle="Angaben zur Heizung und Warmwasser"
            title="Energie" />

        <template v-if="order.certificate.heating_systems?.length === 0">
            <el-empty description="Noch keine Heizungsanlage angelegt">
                <bz-button @click="drawer.energy_systems = true"
                    >Heizungsanlage anlegen</bz-button
                >
            </el-empty>
        </template>
        <template v-else>
            <div class="space-y-2">
                <span class="text-gray-500 text-xs font-semibold"
                    >Heizungsanlage(n)</span
                >
                <div
                    v-for="heatingSystem in order.certificate.heating_systems"
                    class="flex rounded-md bg-white border border-gray-200 p-2 items-center shadow-sm">
                    <div
                        class="h-12 w-12 mr-4 bg-gray-100 rounded flex justify-center items-center">
                        <FireIcon class="h-6 w-6 text-gray-300" />
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <h3 class="text-gray-800 text-sm font-bold">
                                {{ heatingSystem.type }}
                            </h3>
                            <Badge
                                size="sm"
                                label="Hauptenergieträger"
                                v-if="heatingSystem.is_main" />

                            <Badge
                                size="sm"
                                v-if="heatingSystem.water_included"
                                label="Warmwasser" />
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ heatingSystem.system }} - Bj.
                            {{ heatingSystem.construction_year }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <el-button
                            size="small"
                            text
                            @click="deleteHeatingSystem(heatingSystem.id)">
                            <trash-icon class="h-4 w-4" />
                        </el-button>
                    </div>
                </div>
            </div>
            <el-divider />
            <bz-button type="secondary" @click="drawer.energy_systems = true">
                + Heizungsanlage hinzufügen
            </bz-button>
        </template>

        <el-divider />
        <form-header
            title="Energiegewinnung"
            subtitle="Energie aus regenerativen Resourcen" />

        <template
            v-if="
                order.certificate.renewable_energy_installations?.length === 0
            ">
            <bz-button type="secondary" @click="drawer.renewables = true">
                + Erneuerbare Energien anlegen
            </bz-button>
        </template>
        <template v-else>
            <div class="space-y-2">
                <span class="text-gray-500 text-xs font-semibold"
                    >Erneuerbare Energie(en)</span
                >
                <div
                    v-for="renewable in order.certificate
                        .renewable_energy_installations"
                    class="flex rounded-md bg-white border border-gray-200 p-2 items-center shadow-sm">
                    <div
                        class="h-12 w-12 mr-4 bg-gray-100 rounded flex justify-center items-center">
                        <BoltIcon class="h-6 w-6 text-gray-300" />
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center space-x-2">
                            <h3 class="text-gray-800 text-sm font-bold">
                                {{ renewable.type }}
                            </h3>
                            <Badge
                                label="Strom"
                                size="sm"
                                v-if="renewable.electricity" />
                            <Badge
                                label="Heizung"
                                size="sm"
                                v-if="renewable.heating" />
                            <Badge
                                label="Warmwasser"
                                size="sm"
                                v-if="renewable.water" />
                        </div>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ renewable.area }} m² - Bj.
                            {{ renewable.construction_year }}
                        </p>
                    </div>
                    <div class="flex-shrink-0">
                        <el-button
                            size="small"
                            text
                            @click="deleteRenewable(renewable.id)">
                            <trash-icon class="h-4 w-4" />
                        </el-button>
                    </div>
                </div>
            </div>
            <el-divider />
            <bz-button type="secondary" @click="drawer.renewables = true">
                + Erneuerbare Energie hinzufügen
            </bz-button>
        </template>

        <el-drawer
            v-model="drawer.energy_systems"
            direction="rtl"
            :before-close="(e) => cancelSource()">
            <template #header>
                <div class="flex flex-col">
                    <h4 class="text-lg font-medium text-gray-900">
                        Energieträger anlegen
                    </h4>
                    <p class="text-xs text-gray-500">
                        Falls Sie über mehrere Energiequellen verfügen, können
                        Sie diese im Anschluss ebenfalls anlegen.
                    </p>
                </div>
            </template>
            <template #default>
                <div class="flex flex-col space-y-4">
                    <el-form
                        :model="form"
                        class=""
                        label-position="top"
                        size="large">
                        <el-form-item label="Energieträger & Heizung" required>
                            <el-cascader-panel
                                v-model="form.heating"
                                :options="options"
                                :props="{ expandTrigger: 'hover' }"
                                class="w-full"
                                placeholder="Bitte wählen" />
                        </el-form-item>
                        <el-form-item label="Baujahr Heizung" required>
                            <el-input-number
                                v-model="form.construction_year"
                                :min="1900"
                                :max="new Date().getFullYear()"
                                :precision="0"
                                :controls="false"
                                placeholder="2012"
                                class="w-full" />
                        </el-form-item>
                        <el-form-item label="Warmwasseraufbereitung" required>
                            <el-switch
                                active-text="Inklusive"
                                inactive-text="Exklusive"
                                v-model="form.water_included" />
                        </el-form-item>

                        <el-form-item label="Kommentar">
                            <el-input
                                type="textarea"
                                v-model="form.comment"
                                placeholder="Kommentar"
                                rows="3"
                                maxlength="500"
                                show-word-limit />
                        </el-form-item>
                    </el-form>
                </div>
            </template>
            <template #footer>
                <div class="flex items-center justify-end space-x-2">
                    <bz-button type="secondary" @click="() => cancelSource()"
                        >Abbrechen</bz-button
                    >
                    <bz-button
                        @click="addHeatingSystem"
                        :loading="drawer.loading"
                        >Anlegen</bz-button
                    >
                </div>
            </template>
        </el-drawer>

        <el-drawer
            v-model="drawer.renewables"
            direction="rtl"
            :before-close="() => cancelRenewable()">
            <template #header>
                <div class="flex flex-col">
                    <h4 class="text-lg font-medium text-gray-900">
                        Erneuerbare Energien anlegen
                    </h4>
                    <p class="text-xs text-gray-500">
                        Falls Sie über mehrere Erneuerbare verfügen, können Sie
                        diese im Anschluss ebenfalls anlegen.
                    </p>
                </div>
            </template>
            <template #default>
                <div class="flex flex-col space-y-4">
                    <el-form
                        :model="rForm"
                        class=""
                        label-position="top"
                        size="large">
                        <el-form-item label="Anlage" required>
                            <el-select
                                v-model="rForm.type"
                                class="w-full"
                                placeholder="Bitte wählen">
                                <el-option
                                    label="Photovoltaik"
                                    value="Photovoltaik" />
                                <el-option
                                    label="Solarthermie"
                                    value="Solarthermie" />
                            </el-select>
                        </el-form-item>
                        <el-form-item label="Fläche in m²" required>
                            <el-input-number
                                v-model="rForm.area"
                                :min="0"
                                :max="new Date().getFullYear()"
                                :precision="2"
                                :controls="false"
                                placeholder="10 m²"
                                class="w-full" />
                        </el-form-item>
                        <el-form-item label="Baujahr der Anlage" required>
                            <el-input-number
                                v-model="rForm.construction_year"
                                :min="1900"
                                :max="new Date().getFullYear()"
                                :precision="0"
                                :controls="false"
                                placeholder="2012"
                                class="w-full" />
                        </el-form-item>
                        <el-form-item label="Nutzung" required>
                            <el-checkbox
                                v-model="rForm.electricity"
                                label="Strom"
                                size="large" />
                            <el-checkbox
                                v-model="rForm.heating"
                                label="Heizung"
                                size="large" />
                            <el-checkbox
                                v-model="rForm.water"
                                label="Warmwasser"
                                size="large" />
                        </el-form-item>

                        <el-form-item label="Kommentar">
                            <el-input
                                type="textarea"
                                v-model="rForm.comment"
                                placeholder="Kommentar"
                                rows="3"
                                maxlength="500"
                                show-word-limit />
                        </el-form-item>
                    </el-form>
                </div>
            </template>
            <template #footer>
                <div class="flex items-center justify-end space-x-2">
                    <bz-button type="secondary" @click="() => cancelRenewable()"
                        >Abbrechen</bz-button
                    >
                    <bz-button @click="addRenewables" :loading="drawer.loading"
                        >Anlegen</bz-button
                    >
                </div>
            </template>
        </el-drawer>

        <el-divider></el-divider>

        <div class="grid sm:flex sm:justify-between sm:col-span-2 gap-4 mt-6">
            <div class="grid sm:block">
                <bz-button
                    as="link"
                    type="secondary"
                    :href="
                        route('certificate.show', {
                            signature: route().params.signature,
                            order: order.slug,
                            page: 'thermal',
                        })
                    ">
                    Zurück
                </bz-button>
            </div>
            <div class="grid sm:block">
                <bz-button :disabled="!waterCovered" @click="submit">{{
                    !waterCovered
                        ? 'Warmwasser muss abgedeckt sein'
                        : 'Speichern & Weiter'
                }}</bz-button>
            </div>
        </div>
    </page-wrapper>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
