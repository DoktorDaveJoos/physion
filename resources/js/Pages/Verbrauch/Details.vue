<script>
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import AppLayout from '../../Layouts/GuestLayout.vue';
import {reactive, ref, watch} from 'vue';
import {Inertia} from '@inertiajs/inertia';

export default {
    components: {StepperWrapper},
    // Using the shorthand
    layout: [AppLayout],

    props: {
        title: String,
        subtitle: String,
        order: Object,
        customer: Object,
        product: Object,
        errors: Object,
    },

    setup(props) {

        const form = reactive({
            construction_year: props.product.construction_year ?? null,
            construction_year_heating: props.product.construction_year_heating ?? null,
            floor_area: props.product.floor_area ?? null,
            housing_units: props.product.housing_units ?? null,
            ventilation: props.product.ventilation ?? null,
            cellar: props.product.cellar ?? null,
            renewables: props.product.renewables ?? null,
            renewables_reason: props.product.renewables_reason ?? null,
            suggestion_check: props.product.suggestion_check ? JSON.parse(props.product.suggestion_check)
                : {'led': false, 'attic': false, 'windows': false, 'external_wall': false, 'cellar_ceiling': false},
            cooling: props.product.cooling ?? null,
            cooling_count: props.product.cooling_count ?? 0,
            cooling_service: props.product.cooling_service ?? null,
        });

        const handleSubmit = () => {

            console.log(form);

            Inertia.put(route('verbrauch.details.update', props.order.id), form);
        };

        const hasCooling = ref(form.cooling !== null);
        const hasRenewables = ref(form.renewables !== null);

        // watch hasCooling and reset form.cooling_count, form.cooling_service and form.cooling if false
        watch(hasCooling, (value) => {
            if (!value) {
                form.cooling = null;
                form.cooling_count = 0;
                form.cooling_service = null;
            }
        });

        // watch hasRenewables and reset form.renewables_reason if false
        watch(hasRenewables, (value) => {
            if (!value) {
                form.renewables = null;
                form.renewables_reason = null;
            }
        });

        return {
            handleSubmit,
            form,
            hasCooling,
            hasRenewables,
        };

    },
};
</script>

<template>
    <StepperWrapper>

        <el-form @submit.prevent="handleSubmit" label-position="top" class="grid sm:grid-cols-2 gap-4">

            <div class="sm:col-span-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Gebäude
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Detaillierte Informationen zum Gebäude
                </p>
            </div>

            <el-form-item label="Baujahr" :error="errors.construction_year">
                <el-input v-model="form.construction_year" size="large"></el-input>
            </el-form-item>

            <el-form-item label="Baujahr Wärmeerzeuger" :error="errors.construction_year_heating">
                <el-input v-model="form.construction_year_heating" size="large"></el-input>
            </el-form-item>

            <el-form-item label="Wohnfläche" :error="errors.floor_area">
                <el-input v-model="form.floor_area" size="large">
                    <template #append>m²</template>
                </el-input>
            </el-form-item>

            <el-form-item label="Anzahl Wohneinheiten" :error="errors.housing_units">
                <el-input-number v-model="form.housing_units" size="large"></el-input-number>
            </el-form-item>

            <el-form-item label="Lüftung" :error="errors.ventilation">
                <el-select v-model="form.ventilation" size="large" class="w-full" placeholder="Bitte auswählen">
                    <el-option default-first-option label="Fensterlüftung" value="Fensterlüftung" />
                    <el-option default-first-option label="Schachtlüftung" value="Schachtlüftung" />
                    <el-option default-first-option label="Anlage mit Wärmerückgewinnung"
                               value="Anlage mit Wärmerückgewinnung" />
                    <el-option default-first-option label="Anlage ohne Wärmerückgewinnung"
                               value="Anlage ohne Wärmerückgewinnung" />
                </el-select>
            </el-form-item>

            <el-form-item label="Keller" :error="errors.cellar">
                <el-select v-model="form.cellar" size="large" class="w-full" placeholder="Bitte auswählen">
                    <el-option default-first-option label="Kein Keller" value="Kein Keller" />
                    <el-option default-first-option label="Beheizter Keller" value="Beheizter Keller" />
                    <el-option default-first-option label="Unbeheizter Keller" value="Unbeheizter Keller" />
                </el-select>
            </el-form-item>

            <el-divider class="sm:col-span-2" />

            <div class="sm:col-span-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Erneuerbare Energien
                    <el-switch v-model="hasRenewables" size="large" class="ml-2"></el-switch>
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Angaben zu erneuerbaren Energien des Gebäudes
                </p>
            </div>

            <template v-if="hasRenewables">
                <el-form-item label="Erneuerbare Energien" :error="errors.renewables">
                    <el-select v-model="form.renewables" size="large" class="w-full" placeholder="Bitte auswählen">
                        <el-option default-first-option label="Solar" value="Solar" />
                        <el-option default-first-option label="Solarthermie" value="Solarthermie" />
                        <el-option default-first-option label="Wärmepumpe" value="Wärmepumpe" />
                        <el-option default-first-option label="Wasserkraft" value="Wasserkraft" />
                        <el-option default-first-option label="Windkraft" value="Windkraft" />
                        <el-option default-first-option label="Biomasse" value="Biomasse" />
                    </el-select>
                </el-form-item>

                <el-form-item label="Verwendung" :error="errors.renewables_reason">
                    <el-select v-model="form.renewables_reason" size="large" class="w-full"
                               placeholder="Bitte auswählen">
                        <el-option default-first-option label="Heizen" value="Heizen" />
                        <el-option default-first-option label="Heizen und Warmwasser" value="Heizen und Warmwasser" />
                        <el-option default-first-option label="Warmwasser" value="Warmwasser" />
                        <el-option default-first-option label="Stromerzeugung" value="Stromerzeugung" />
                        <el-option default-first-option label="Sonstiges" value="Sonstiges" />
                    </el-select>
                </el-form-item>

            </template>

            <el-divider class="sm:col-span-2" />

            <div class="sm:col-span-2">
                <div class="flex items-center">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Kühlung
                    </h3>
                    <el-switch v-model="hasCooling" size="large" class="ml-2"></el-switch>
                </div>
                <p class="mt-1 text-sm text-gray-500">
                    Angaben zur Kühlung des Gebäudes
                </p>
            </div>

            <template v-if="hasCooling">

                <el-form-item label="Kühlung" :error="errors.cooling">
                    <el-select v-model="form.cooling" size="large" class="w-full"
                               placeholder="Bitte auswählen">
                        <el-option default-first-option label="Aus Strom" value="Aus Strom" />
                        <el-option default-first-option label="Passiv" value="Passiv" />
                        <el-option default-first-option label="Aus Wärme" value="Aus Wärme" />
                        <el-option default-first-option label="Geliefert" value="Geliefert" />
                    </el-select>
                </el-form-item>

                <div class="hidden sm:block"></div>


                <el-form-item label="Inspektionspflichtige Klimaanlage" :error="errors.cooling_count">
                    <el-input-number v-model="form.cooling_count"
                                     size="large"
                                     class="inline-block w-full"
                                     :min="0"
                                     :max="100">

                    </el-input-number>
                </el-form-item>

                <el-form-item label="Nächste Inspektion" :error="errors.cooling_service">
                    <el-date-picker
                        class="w-full"
                        v-model="form.cooling_service"
                        size="large"
                        type="date"
                        placeholder="Bitte auswählen"
                        format="DD.MM.YYYY"
                        :disabled-date="date => date < new Date()"
                    ></el-date-picker>
                </el-form-item>

            </template>

            <el-divider class="sm:col-span-2" />

            <div class="sm:col-span-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Energetische Zusatzinformationen
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Machen Sie Angaben zu bereits erfolgten Energiesparmaßnahmen
                </p>
            </div>

            <div class="flex flex-col">
                <el-checkbox v-model="form.suggestion_check.attic" label="Dach-/Dachbodendämmung"
                             size="large"></el-checkbox>
                <el-checkbox v-model="form.suggestion_check.external_wall" label="Außenwanddämmung"
                             size="large"></el-checkbox>
                <el-checkbox v-model="form.suggestion_check.windows" label="Wärmeschutz-/Isolierverglasung"
                             size="large"></el-checkbox>
                <el-checkbox v-model="form.suggestion_check.cellar_ceiling" label="Kellerdeckendämmung"
                             size="large"></el-checkbox>
                <el-checkbox v-model="form.suggestion_check.led" label="Ausschließlich LED Leuchtmittel"
                             size="large"></el-checkbox>
            </div>

            <el-divider class="sm:col-span-2" />

            <div class="sm:col-span-2 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex mt-3 justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                >
                    Speichern & Weiter
                </button>
            </div>


        </el-form>

    </StepperWrapper>

</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>

