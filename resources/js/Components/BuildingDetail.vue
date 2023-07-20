<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';

import FormHeader from './FormHeader.vue';
import BzButton from './BzButton.vue';

const props = defineProps({
    order: {
        type: Object,
    },
    renewables: Boolean,
    cooling: Boolean,
});

const form = useForm({
    construction_year: null,
    construction_year_heating: null,
    floor_area: null,
    housing_units: null,
    ventilation: null,
    cellar: null,
    renewables: null,
    renewables_reason: null,
    cooling: null,
    cooling_count: 0,
    cooling_service: null,
    suggestion_check: {
        led: false,
        attic: false,
        windows: false,
        external_wall: false,
        cellar_ceiling: false,
    },
});

if (props.order) {
    const { certificate } = props.order;

    form.construction_year = certificate.construction_year;
    form.construction_year_heating = certificate.construction_year_heating;
    form.floor_area = certificate.floor_area;
    form.housing_units = parseInt(certificate.housing_units);
    form.ventilation = certificate.ventilation;
    form.cellar = certificate.cellar ?? 'Kein Keller';
    form.renewables = certificate.renewables;
    form.renewables_reason = certificate.renewables_reason;
    form.cooling = certificate.cooling;
    form.cooling_count = certificate.cooling_count
        ? parseInt(certificate.cooling_count)
        : null;
    form.cooling_service = certificate.cooling_service;

    form.suggestion_check = JSON.parse(certificate.suggestion_check ?? '{}');
}

const submit = () => {
    form.put(
        route(`certificate.update`, {
            order: props.order.slug,
            page: 'details',
            signature: route().params.signature,
        })
    );
};

const hasCooling = ref(form.cooling !== null);
const hasRenewables = ref(form.renewables !== null);

watch(hasCooling, (value) => {
    if (!value) {
        form.cooling = null;
        form.cooling_count = 0;
        form.cooling_service = null;
    }
});

watch(hasRenewables, (value) => {
    if (!value) {
        form.renewables = null;
        form.renewables_reason = null;
    }
});
</script>

<template>
    <el-form
        :model="form"
        class="grid sm:grid-cols-2 sm:gap-x-8"
        label-position="top"
        size="large"
        @submit.prevent="submit">
        <form-header
            subtitle="Detaillierte Informationen zum Gebäude"
            title="Gebäude" />

        <el-form-item :error="form.errors.construction_year" label="Baujahr">
            <el-input v-model="form.construction_year"></el-input>
        </el-form-item>

        <el-form-item
            :error="form.errors.construction_year_heating"
            label="Baujahr Wärmeerzeuger">
            <el-input v-model="form.construction_year_heating"></el-input>
        </el-form-item>

        <el-form-item :error="form.errors.floor_area" label="Wohnfläche">
            <el-input v-model="form.floor_area">
                <template #append>m²</template>
            </el-input>
        </el-form-item>

        <el-form-item
            :error="form.errors.housing_units"
            label="Anzahl Wohneinheiten">
            <el-input-number v-model="form.housing_units"></el-input-number>
        </el-form-item>

        <el-form-item :error="form.errors.ventilation" label="Lüftung">
            <el-select
                v-model="form.ventilation"
                class="w-full"
                placeholder="Bitte auswählen">
                <el-option
                    default-first-option
                    label="Fensterlüftung"
                    value="Fensterlüftung" />
                <el-option
                    default-first-option
                    label="Schachtlüftung"
                    value="Schachtlüftung" />
                <el-option
                    default-first-option
                    label="Anlage mit Wärmerückgewinnung"
                    value="Anlage mit Wärmerückgewinnung" />
                <el-option
                    default-first-option
                    label="Anlage ohne Wärmerückgewinnung"
                    value="Anlage ohne Wärmerückgewinnung" />
            </el-select>
        </el-form-item>

        <template v-if="order.certificate_type?.includes('Vrbr')">
            <el-form-item :error="form.errors.cellar" label="Keller">
                <el-select
                    v-model="form.cellar"
                    class="w-full"
                    placeholder="Bitte auswählen"
                    :default-first-option="true">
                    <el-option
                        default-first-option
                        label="Kein Keller"
                        value="Kein Keller" />
                    <el-option
                        default-first-option
                        label="Beheizter Keller"
                        value="Beheizter Keller" />
                    <el-option
                        default-first-option
                        label="Unbeheizter Keller"
                        value="Unbeheizter Keller" />
                </el-select>
            </el-form-item>
        </template>

        <template v-if="renewables">
            <el-divider class="sm:col-span-2" />

            <form-header
                :switcher="hasRenewables"
                subtitle="Angaben zu erneuerbaren Energien des Gebäudes"
                title="Erneuerbare Energien"
                @update:switcher="hasRenewables = $event" />

            <template v-if="hasRenewables">
                <el-form-item
                    :error="form.errors.renewables"
                    label="Erneuerbare Energien">
                    <el-select
                        v-model="form.renewables"
                        class="w-full"
                        placeholder="Bitte auswählen">
                        <el-option
                            default-first-option
                            label="Solar"
                            value="Solar" />
                        <el-option
                            default-first-option
                            label="Solarthermie"
                            value="Solarthermie" />
                        <el-option
                            default-first-option
                            label="Wärmepumpe"
                            value="Wärmepumpe" />
                        <el-option
                            default-first-option
                            label="Wasserkraft"
                            value="Wasserkraft" />
                        <el-option
                            default-first-option
                            label="Windkraft"
                            value="Windkraft" />
                        <el-option
                            default-first-option
                            label="Biomasse"
                            value="Biomasse" />
                    </el-select>
                </el-form-item>

                <el-form-item
                    :error="form.errors.renewables_reason"
                    label="Verwendung">
                    <el-select
                        v-model="form.renewables_reason"
                        class="w-full"
                        placeholder="Bitte auswählen">
                        <el-option
                            default-first-option
                            label="Heizen"
                            value="Heizen" />
                        <el-option
                            default-first-option
                            label="Heizen und Warmwasser"
                            value="Heizen und Warmwasser" />
                        <el-option
                            default-first-option
                            label="Warmwasser"
                            value="Warmwasser" />
                        <el-option
                            default-first-option
                            label="Stromerzeugung"
                            value="Stromerzeugung" />
                        <el-option
                            default-first-option
                            label="Sonstiges"
                            value="Sonstiges" />
                    </el-select>
                </el-form-item>
            </template>
        </template>

        <el-divider class="sm:col-span-2" />

        <form-header
            :switcher="hasCooling"
            subtitle="Angaben zur Kühlung des Gebäudes"
            title="Kühlung"
            @update:switcher="hasCooling = $event" />

        <template v-if="hasCooling">
            <el-form-item :error="form.errors.cooling" label="Kühlung">
                <el-select
                    v-model="form.cooling"
                    class="w-full"
                    placeholder="Bitte auswählen">
                    <el-option
                        default-first-option
                        label="Aus Strom"
                        value="Aus Strom" />
                    <el-option
                        default-first-option
                        label="Passiv"
                        value="Passiv" />
                    <el-option
                        default-first-option
                        label="Aus Wärme"
                        value="Aus Wärme" />
                    <el-option
                        default-first-option
                        label="Geliefert"
                        value="Geliefert" />
                </el-select>
            </el-form-item>

            <div class="hidden sm:block"></div>

            <el-form-item
                :error="form.errors.cooling_count"
                label="Inspektionspflichtige Klimaanlage">
                <el-input-number
                    v-model="form.cooling_count"
                    :max="100"
                    :min="0"
                    class="inline-block w-full">
                </el-input-number>
            </el-form-item>

            <el-form-item
                :error="form.errors.cooling_service"
                label="Nächste Inspektion">
                <el-date-picker
                    v-model="form.cooling_service"
                    :disabled-date="(date) => date < new Date()"
                    class="w-full"
                    format="DD.MM.YYYY"
                    placeholder="Bitte auswählen"
                    type="date"></el-date-picker>
            </el-form-item>
        </template>

        <el-divider class="sm:col-span-2" />

        <form-header
            subtitle="Machen Sie Angaben zu bereits erfolgten Energiesparmaßnahmen"
            title="Energetische Zusatzinformationen" />

        <div class="flex flex-col">
            <el-checkbox
                v-model="form.suggestion_check.attic"
                label="Dach-/Dachbodendämmung"></el-checkbox>
            <el-checkbox
                v-model="form.suggestion_check.external_wall"
                label="Außenwanddämmung"></el-checkbox>
            <el-checkbox
                v-model="form.suggestion_check.windows"
                label="Wärmeschutz-/Isolierverglasung"></el-checkbox>
            <el-checkbox
                v-model="form.suggestion_check.cellar_ceiling"
                label="Kellerdeckendämmung"></el-checkbox>
            <el-checkbox
                v-model="form.suggestion_check.led"
                label="Ausschließlich LED Leuchtmittel"></el-checkbox>
        </div>

        <el-divider class="sm:col-span-2" />

        <div class="grid sm:flex sm:justify-between sm:col-span-2 gap-4">
            <div class="grid sm:block">
                <bz-button
                    as="link"
                    type="secondary"
                    :href="
                        route('certificate.show', {
                            signature: route().params.signature,
                            order: order.slug,
                            page: 'general',
                        })
                    ">
                    Zurück
                </bz-button>
            </div>
            <div class="grid sm:block">
                <bz-button as="button" type="primary" @click="submit">
                    Speichern & Weiter
                </bz-button>
            </div>
        </div>
    </el-form>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
