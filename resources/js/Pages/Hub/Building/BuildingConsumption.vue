<script setup>
import { Head, router, useForm } from '@inertiajs/vue3';
import SidebarLayout from '../../../Layouts/SidebarLayout.vue';

import { computed, ref } from 'vue';
import BzBreadcrumbs from '../Components/BzBreadcrumbs.vue';
import BzCard from '../Components/BzCard.vue';
import BzButton from '../../../Components/BzButton.vue';
import { ElDrawer } from 'element-plus';
import dayjs from 'dayjs';
import { BoltIcon, TrashIcon, FireIcon } from '@heroicons/vue/24/outline';
import Badge from '../../../Components/Badge.vue';
import BuildingShowWrapper from './Show/BuildingShowWrapper.vue';

const props = defineProps({
    building: Object,
});

const drawer = ref(false);

const form = useForm({
    energy_source: null,
    water_included: false,
    start: null,
    end: null,
    consumption: null,
    vacancy: null,
    comment: null,
});

const addConsumption = () => {
    form.transform((data) => ({
        ...data,
        start: data.start ? dayjs(data.start).format('YYYY-MM-DD') : null,
        end: data.end ? dayjs(data.end).format('YYYY-MM-DD') : null,
    })).put(
        route('building.consumption', {
            building: route().params.building,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                drawer.value = false;
                form.reset();
            },
        }
    );
};

const deleteConsumption = (id) => {
    router.delete(
        route('building.consumption.delete', {
            building: route().params.building,
            consumption: id,
        }),
        {
            preserveScroll: true,
        }
    );
};

const totalMonths = computed(() => {
    return props.building.data.consumptions.reduce((acc, cur) => {
        return acc + cur.period;
    }, 0);
});

const cancel = () => {
    drawer.value = false;
    form.reset();
};

const steps = [
    {
        name: 'Gebäude',
        route: route('hub.buildings.index'),
    },
    {
        name:
            props.building.data.address +
            ', ' +
            props.building.data.postal_code +
            ' ' +
            props.building.data.city,
        route: route('hub.buildings.show.index', {
            building: props.building.data.id,
        }),
    },

    {
        name: 'Verbrauch',
        route: route('hub.buildings.show.consumption', {
            building: route().params.building,
        }),
    },
];
</script>

<template>
    <Head>
        <title>Verbrauch</title>
    </Head>

    <building-show-wrapper :building="building" sub-tabs-active>
        <bz-card>
            <template #title>Verbrauch</template>
            <template #subtitle>Angaben zum Verbrauch des Gebäudes</template>
            <template #button>
                <bz-button type="secondary" @click="drawer = true"
                    >Verbrauch erfassen</bz-button
                >
            </template>
            <template #content>
                <el-empty
                    v-if="!building.data.consumptions?.length"
                    description="Es sind noch keine Verbrauchsdaten vorhanden.">
                    <bz-button type="primary" @click="drawer = true"
                        >Verbrauch erfassen</bz-button
                    >
                </el-empty>
                <template v-else>
                    <div
                        class="space-y-2 px-6 py-4 bg-gray-50 shadow-inner border-t border-gray-200">
                        <div
                            v-for="consumption in building.data.consumptions"
                            class="flex rounded-lg bg-white border border-gray-200 p-2 items-center">
                            <div
                                class="h-12 w-12 mr-4 bg-gray-100 rounded flex justify-center items-center">
                                <FireIcon class="h-6 w-6 text-gray-500" />
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-gray-800 text-sm font-bold">
                                        {{ consumption.energy_source }}
                                    </h3>
                                    <Badge
                                        v-if="consumption.water_included"
                                        label="Warmwasser"
                                        size="sm" />
                                </div>
                                <span class="text-xs text-gray-500 mt-1">
                                    {{
                                        dayjs(consumption.start).format(
                                            'DD.MM.YYYY'
                                        )
                                    }}
                                    -
                                    {{
                                        dayjs(consumption.end).format(
                                            'DD.MM.YYYY'
                                        )
                                    }}
                                </span>
                                <span
                                    class="ml-2 text-xs font-bold text-gray-500 mt-1">
                                    {{ consumption.period }} Monate
                                </span>
                            </div>
                            <div class="flex-shrink-0">
                                <el-button
                                    size="small"
                                    text
                                    @click="deleteConsumption(consumption.id)">
                                    <trash-icon class="h-4 w-4" />
                                </el-button>
                            </div>
                        </div>
                    </div>
                    <div
                        v-if="totalMonths < '36'"
                        class="flex items-baseline py-4 px-6 border-t border-gray-100">
                        <span class="text-gray-500 text-sm font-bold">
                            {{ totalMonths }}
                        </span>
                        <span class="ml-1 text-gray-500 text-xs">
                            / 36 Monaten erfasst für Verbrauchsausweis
                        </span>
                    </div>
                    <div v-else class="flex items-center py-6 px-6">
                        <bz-button
                            as="link"
                            :href="
                                route(
                                    'hub.buildings.energieausweis',
                                    building.data.id
                                )
                            "
                            type="primary">
                            Verbrauchsausweis erstellen
                        </bz-button>
                    </div>
                </template>
            </template>
        </bz-card>

        <el-drawer v-model="drawer" :before-close="cancel" direction="rtl">
            <template #header>
                <div class="flex flex-col">
                    <h4 class="text-lg font-medium text-gray-900">
                        Verbrauchsdaten erfassen
                    </h4>
                    <p class="text-xs text-gray-500">
                        Sie können die Abrechnungsepisoden Stück für Stück
                        erfassen oder übergreifend.
                    </p>
                </div>
            </template>
            <template #default>
                <div class="flex flex-col space-y-4">
                    <el-form
                        :model="form.energy_source"
                        class=""
                        label-position="top"
                        size="large">
                        <el-form-item
                            label="Energieträger"
                            :error="form.errors.energy_source"
                            required>
                            <el-select
                                v-model="form.energy_source"
                                class="w-full"
                                size="large"
                                placeholder="Energieträger auswählen">
                                <el-option
                                    label="Leichtes Heizöl EL [l]"
                                    value="Leichtes Heizöl EL [l]"></el-option>
                                <el-option
                                    label="Schweres Heizöl [kg]"
                                    value="Schweres Heizöl [kg]"></el-option>
                                <el-option
                                    label="Erdgas L [m³]"
                                    value="Erdgas L [m³]"></el-option>
                                <el-option
                                    label="Erdgas L [kWh (HS)]"
                                    value="Erdgas L [kWh (HS)]"></el-option>
                                <el-option
                                    label="Erdgas H [m³]"
                                    value="Erdgas H [m³]"></el-option>
                                <el-option
                                    label="Erdgas H [kWh (HS)]"
                                    value="Erdgas H [kWh (HS)]"></el-option>
                                <el-option
                                    label="Stadtgas [kWh]"
                                    value="Stadtgas [kWh]"></el-option>
                                <el-option
                                    label="Stadtgas [kWh (HS)]"
                                    value="Stadtgas [kWh (HS)]"></el-option>
                                <el-option
                                    label="Flüssiggas [kg]"
                                    value="Flüssiggas [kg]"></el-option>
                                <el-option
                                    label="Stückholz [kg]"
                                    value="Stückholz [kg]"></el-option>
                                <el-option
                                    label="Holzhackschnitzel [SRm]"
                                    value="Holzhackschnitzel [SRm]"></el-option>
                                <el-option
                                    label="Holzpellets [kg]"
                                    value="Holzpellets [kg]"></el-option>
                                <el-option
                                    label="Fernwärme [kWh]"
                                    value="Fernwärme [kWh]"></el-option>
                                <el-option
                                    label="Strom [kWh]"
                                    value="Strom [kWh]"></el-option>
                                <el-option
                                    label="Blockheizkraftwerk [kWh]"
                                    value="Blockheizkraftwerk [kWh]"></el-option>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="Warmwasseraufbereitung" required>
                            <el-switch
                                v-model="form.water_included"
                                active-text="Inklusive"
                                inactive-text="Exklusive" />
                        </el-form-item>
                        <el-form-item
                            label="Start des Abrechnungszeitraums"
                            :error="form.errors.start"
                            required>
                            <el-date-picker
                                v-model="form.start"
                                type="date"
                                placeholder="Startdatum"
                                format="DD.MM.YYYY"
                                style="width: 100%" />
                        </el-form-item>
                        <el-form-item
                            label="Ende des Abrechnungszeitraums"
                            :error="form.errors.end"
                            required>
                            <el-date-picker
                                v-model="form.end"
                                type="date"
                                placeholder="Enddatum"
                                style="width: 100%" />
                        </el-form-item>
                        <el-form-item
                            label="Verbrauch"
                            :error="form.errors.consumption"
                            required>
                            <el-input-number
                                v-model="form.consumption"
                                class="!w-full"
                                placeholder="0"
                                :min="0" />
                        </el-form-item>

                        <el-form-item label="Kommentar">
                            <el-input
                                v-model="form.comment"
                                maxlength="500"
                                placeholder="Kommentar"
                                rows="3"
                                show-word-limit
                                type="textarea" />
                        </el-form-item>
                    </el-form>
                </div>
            </template>
            <template #footer>
                <div class="flex items-center justify-end space-x-2">
                    <bz-button type="secondary" @click="cancel"
                        >Abbrechen
                    </bz-button>
                    <bz-button :loading="drawer.loading" @click="addConsumption"
                        >Anlegen
                    </bz-button>
                </div>
            </template>
        </el-drawer>
    </building-show-wrapper>
</template>
