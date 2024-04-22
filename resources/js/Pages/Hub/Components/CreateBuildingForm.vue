<script setup>
import { useForm } from '@inertiajs/vue3';
import { onMounted, ref, watch } from 'vue';
import { Loader } from '@googlemaps/js-api-loader';
import BzButton from '../../../Components/BzButton.vue';

const props = defineProps({
    building: Object,
});

const form = useForm({
    new_building: props.building?.data.new_building ?? false,
    street: props.building?.data.street ?? null,
    house_number: props.building?.data.house_number ?? null,
    postal_code: props.building?.data.postal_code ?? null,
    city: props.building?.data.city ?? null,
    place_id: props.building?.data.place_id ?? null,
    type: props.building?.data.type ?? null,
    additional_type: props.building?.data.additional_type ?? null,
    construction_year: props.building?.data.construction_year ?? null,
    construction_year_heating:
        props.building?.data.construction_year_heating ?? null,
    floor_area: props.building?.data.floor_area ?? null,
    land_area: props.building?.data.land_area ?? null,
    floors: props.building?.data.floors ?? null,
    floor: props.building?.data.floor ?? null,
    rooms: props.building?.data.rooms ?? null,
    housing_units: props.building?.data.housing_units ?? null,
    ventilation: props.building?.data.ventilation ?? null,
    cellar: props.building?.data.cellar ?? null,
    cooling: props.building?.data.cooling ?? null,
    cooling_count: props.building?.data.cooling_count ?? 0,
    cooling_service: props.building?.data.cooling_service ?? null,
});

const street = ref(null);
const searchActive = ref(true);
const hasCooling = ref(form.cooling !== null);

watch(hasCooling, (value) => {
    if (!value) {
        form.cooling = null;
        form.cooling_count = 0;
        form.cooling_service = null;
    }
});

const API_KEY = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

const loader = new Loader({
    apiKey: API_KEY,
    version: 'weekly',
    libraries: ['places'],
});

const google = await loader.load();

onMounted(() => {
    const autocomplete = new google.maps.places.Autocomplete(
        street.value.input,
        {
            componentRestrictions: { country: 'de' },
            fields: ['address_components', 'geometry', 'place_id'],
            types: ['address'],
        }
    );

    autocomplete.addListener('place_changed', () => {
        form.place_id = autocomplete.getPlace()?.place_id;
        let address1 = '';
        for (const component of autocomplete.getPlace()?.address_components) {
            const addressType = component.types[0];

            switch (addressType) {
                case 'street_number':
                    form.house_number = `${address1}${
                        ' ' + component.long_name
                    }`;
                    break;
                case 'route':
                    address1 = `${component.long_name}${address1}`;
                    break;
                case 'postal_code':
                    form.postal_code = component.long_name;
                    break;
                case 'locality':
                    form.city = component.long_name;
                    break;
            }
        }

        street.value.input.value = address1;
        form.street = address1;
        searchActive.value = false;
    });
});

const submit = () => {
    form.post(route('buildings.store'));
};

const update = () => {
    form.put(route('buildings.update', props.building?.data.id));
};

watch(
    () => form.type,
    (value) => {
        if (value === 'Wohnung') {
            form.floors = null;
            form.housing_units = null;
            form.land_area = null;
            form.additional_type = null;
        } else {
            form.floor = null;
        }
    }
);
</script>

<template>
    <el-form
        :model="form"
        label-position="top"
        size="large"
        @submit.prevent="submit">
        <div
            class="flex flex-col items-center py-4 sm:col-span-2 border-b border-gray-100">
            <span class="text-gray-900 font-semibold">Neues Gebäude</span>
            <el-switch
                v-model="form.new_building"
                active-text="Neubau"
                inactive-text="Bestand"
                size="large" />
        </div>
        <div
            class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
            <el-form-item
                v-if="searchActive"
                label="Adresse suchen"
                class="col-span-2">
                <el-input
                    ref="street"
                    placeholder="Suchen Sie Ihre Adresse"
                    v-model="form.street" />
            </el-form-item>

            <template v-else>
                <el-form-item
                    :error="form.errors.street"
                    :required="true"
                    label="Straße">
                    <el-input ref="street" v-model="form.street" />
                </el-form-item>

                <!-- Spacer-->
                <el-form-item
                    :error="form.errors.house_number"
                    label="Hausnummer"
                    required>
                    <el-input v-model="form.house_number" />
                </el-form-item>

                <el-form-item
                    id="postal_code"
                    :error="form.errors.postal_code"
                    label="Postleitzahl"
                    required>
                    <el-input
                        ref="zip"
                        v-model="form.postal_code"
                        autocomplete="zip" />
                </el-form-item>

                <el-form-item
                    id="city"
                    :error="form.errors.city"
                    label="Stadt / Gemeinde"
                    required>
                    <el-input
                        ref="city"
                        v-model="form.city"
                        autocomplete="city" />
                </el-form-item>
            </template>

            <el-form-item
                :error="form.errors.type"
                :required="true"
                label="Gebäudetyp">
                <el-select
                    v-model="form.type"
                    class="w-full"
                    placeholder="Bitte auswählen">
                    <el-option
                        default-first-option
                        label="Einfamilienhaus"
                        value="Einfamilienhaus" />
                    <el-option
                        default-first-option
                        label="Mehrfamilienhaus"
                        value="Mehrfamilienhaus" />
                    <el-option
                        default-first-option
                        label="Wohnung"
                        value="Wohnung" />
                    <el-option
                        default-first-option
                        label="Bürogebäude"
                        value="Bürogebäude" />
                </el-select>
            </el-form-item>

            <el-form-item
                v-if="form.type !== 'Wohnung'"
                :error="form.errors.additional_type"
                :required="true"
                label="Gebäudeart">
                <el-select
                    v-model="form.additional_type"
                    class="w-full"
                    placeholder="Bitte auswählen">
                    <el-option
                        default-first-option
                        label="Freistehend"
                        value="Freistehend" />
                    <el-option
                        default-first-option
                        label="Doppelhaushälfte"
                        value="Doppelhaushälfte" />
                    <el-option
                        default-first-option
                        label="Reiheneckhaus"
                        value="Reiheneckhaus" />
                    <el-option
                        default-first-option
                        label="Reihenmittelhaus"
                        value="Reihenmittelhaus" />
                </el-select>
            </el-form-item>
            <el-form-item
                v-else
                :error="form.errors.floor"
                :required="true"
                label="Etage">
                <el-input-number v-model="form.floor" :controls="false" />
            </el-form-item>
        </div>

        <div
            class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
            <el-form-item
                :error="form.errors.construction_year"
                label="Baujahr"
                required>
                <el-input-number
                    v-model="form.construction_year"
                    :controls="false"></el-input-number>
            </el-form-item>

            <el-form-item :error="form.errors.rooms" label="Anzahl Zimmer">
                <el-input-number
                    v-model="form.rooms"
                    :controls="false"></el-input-number>
            </el-form-item>

            <el-form-item
                :error="form.errors.floor_area"
                label="Wohnfläche"
                required>
                <el-input v-model="form.floor_area">
                    <template #append>m²</template>
                </el-input>
            </el-form-item>

            <el-form-item
                v-if="form.type !== 'Wohnung'"
                :error="form.errors.land_area"
                label="Grundstücksfläche">
                <el-input v-model="form.land_area">
                    <template #append>m²</template>
                </el-input>
            </el-form-item>

            <el-form-item
                v-if="form.type !== 'Wohnung'"
                :error="form.errors.floors"
                label="Stockwerke"
                required>
                <el-input-number v-model="form.floors"></el-input-number>
            </el-form-item>

            <el-form-item
                v-if="form.type !== 'Wohnung'"
                :error="form.errors.housing_units"
                label="Anzahl Wohneinheiten"
                required>
                <el-input-number v-model="form.housing_units"></el-input-number>
            </el-form-item>
        </div>
        <div
            class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
            <el-form-item
                :error="form.errors.ventilation"
                label="Lüftung"
                required>
                <el-select
                    v-model="form.ventilation"
                    class="w-full"
                    placeholder="Bitte auswählen">
                    <el-option
                        default-first-option
                        label="Fensterlüftung"
                        value="Fensterlüftung" />
                    <el-option label="Schachtlüftung" value="Schachtlüftung" />
                    <el-option
                        label="Anlage mit Wärmerückgewinnung"
                        value="Anlage mit Wärmerückgewinnung" />
                    <el-option
                        label="Anlage ohne Wärmerückgewinnung"
                        value="Anlage ohne Wärmerückgewinnung" />
                </el-select>
            </el-form-item>
        </div>

        <div
            class="grid sm:grid-cols-2 sm:gap-x-8 px-6 py-4 border-b border-gray-100">
            <div class="flex flex-col items-center sm:col-span-2">
                <span class="text-gray-900 font-semibold">Gebäudekühlung</span>
                <el-switch
                    v-model="hasCooling"
                    active-text="Vorhanden"
                    inactive-text="Nicht vorhanden"
                    size="large" />
            </div>

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
        </div>
        <div class="flex px-6 py-4 justify-end">
            <bz-button
                v-if="!building"
                :disabled="!form.isDirty"
                :loading="form.processing"
                @click="submit">
                Gebäude anlegen
            </bz-button>
            <bz-button
                v-else
                :disabled="!form.isDirty"
                :loading="form.processing"
                @click="update">
                speichern
            </bz-button>
        </div>
    </el-form>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
