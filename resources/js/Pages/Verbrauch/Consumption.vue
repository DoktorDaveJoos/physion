<script>
import {PlusIcon, TrashIcon, CheckIcon} from '@heroicons/vue/24/outline';
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import AppLayout from '../../Layouts/GuestLayout.vue';
import {computed, reactive, ref, watch} from 'vue';
import {Inertia} from '@inertiajs/inertia';

import {ElDrawer, ElMessageBox} from 'element-plus';
import dayjs from 'dayjs';
import {useForm} from '@inertiajs/inertia-vue3';

export default {
    methods: {dayjs},
    components: {StepperWrapper, PlusIcon, TrashIcon, ElDrawer, ElMessageBox, CheckIcon},
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

        const addSourceForm = useForm({
            source: null,
            water: null,
        });

        const addPeriodForm = useForm({
            period: null,
            consumption: null,
            water: null,
        });

        const addVacancyForm = useForm({
            period: null,
        });

        const markDoneForm = useForm({
            percentage: props.product.vacancy_percentage ?? null,
        })

        const drawer = reactive({
            visible: false,
            loading: false,
        });

        const hasVacancy = ref(props.product.vacancies.length > 0 || props.product.vacancy_percentage !== null);
        const activeName = ref(props.product.vacancies.length > 0 ? 'period' : 'percentage');

        const cancelSource = () => {
            addSourceForm.reset();
            drawer.visible = false;
        };

        const showDrawer = () => {
            drawer.visible = true;
        };

        const addSource = () => {
            Inertia.put(route('verbrauch.consumption.source.update', props.order.id), addSourceForm, {
                onProgress: () => {
                    drawer.loading = true;
                },
                onSuccess: () => {
                    drawer.visible = false;
                    addSourceForm.reset();
                },
            });
        };

        const addPeriod = (sourceId) => {
            Inertia.post(route('verbrauch.consumption.period.create', {
                order: props.order.id,
                source: sourceId,
            }), addPeriodForm, {
                onSuccess: () => {
                    addPeriodForm.reset();
                },
                preserveScroll: true,
            });
        };

        const deletePeriod = (sourceId, periodId) => {
            Inertia.delete(route('verbrauch.consumption.period.delete', {
                order: props.order.id,
                source: sourceId,
                period: periodId,
            }), {
                preserveScroll: true,
            });
        };

        const deleteSource = (sourceId) => {
            ElMessageBox.confirm('Energieträger wirklich löschen?', 'Löschen', {
                confirmButtonText: 'Ja',
                cancelButtonText: 'Nein',
            }).then(() => {
                Inertia.delete(route('verbrauch.consumption.source.delete', {
                    order: props.order.id,
                    source: sourceId,
                }), {
                    preserveScroll: true,
                });
            }).catch(() => {
                // do nothing
            });
        };

        const addVacancy = () => {

            if (!addVacancyForm.period) return;

            addVacancyForm.period[1] = dayjs(addVacancyForm.period[1]).endOf('month').toISOString();

            Inertia.post(route('verbrauch.consumption.vacancy.create', props.order.id), addVacancyForm, {
                preserveScroll: true,
                onSuccess: () => {
                    addVacancyForm.reset();
                    markDoneForm.percentage = null;
                },
                onError: () => {
                    addVacancyForm.reset();
                },
            });
        };

        const deleteVacancy = (vacancyId) => {
            Inertia.delete(route('verbrauch.consumption.vacancy.delete', {
                order: props.order.id,
                vacancy: vacancyId,
            }), {
                preserveScroll: true,
            });
        };

        const getMonths = (source) => {
            let months = 0;

            source.periods.forEach((period) => {
                months += (dayjs(period.start).diff(dayjs(period.end), 'month') * -1) + 1;
            });

            return months;
        };

        const mainSourceHas36Months = computed(() => {
            let has36Months = false;

            props.product.sources.forEach((source) => {
                if (source.main) {
                    if (getMonths(source) >= 36) {
                        has36Months = true;
                    }
                }
            });

            return has36Months;
        });

        const shortcuts = [2022, 2021, 2020, 2019, 2018, 2017, 2016, 2015, 2014].map(year => {
                return {
                    text: year.toString(),
                    value: () => {
                        const end = Date.UTC(year, 11, 31);
                        const start = Date.UTC(year, 0, 1);
                        return [start, end];
                    },
                };
            },
        );

        const markDone = () => {
            Inertia.put(route('verbrauch.consumption.done', props.order.id), markDoneForm, {
                preserveScroll: true
            });
        };

        return {
            shortcuts,
            drawer,
            cancelSource,
            addSource,
            addSourceForm,
            showDrawer,
            addPeriodForm,
            addPeriod,
            deletePeriod,
            deleteSource,
            getMonths,
            mainSourceHas36Months,
            addVacancyForm,
            addVacancy,
            deleteVacancy,
            markDone,
            hasVacancy,
            activeName,
            markDoneForm
        };
    },
}
;
</script>

<template>


    <el-drawer v-model="drawer.visible" direction="rtl" :before-close="cancelSource">
        <template #header>
            <div class="flex flex-col">
                <h4 class="text-lg font-medium text-gray-900">Energieträger anlegen</h4>
                <p class="text-xs text-gray-500">
                    Falls Sie über mehrere Energiequellen verfügen, können Sie diese im Anschluss ebenfalls anlegen.
                </p>
            </div>
        </template>
        <template #default>
            <div class="flex flex-col space-y-4">
                <el-form label-position="top">
                    <el-form-item label="Energieträger" :error="errors.source">
                        <el-select v-model="addSourceForm.source" class="w-full" size="large"
                                   placeholder="Energieträger auswählen">
                            <el-option label="Leichtes Heizöl EL [l]" value="Leichtes Heizöl EL [l]"></el-option>
                            <el-option label="Schweres Heizöl [kg]" value="Schweres Heizöl [kg]"></el-option>
                            <el-option label="Erdgas L [m³]" value="Erdgas L [m³]"></el-option>
                            <el-option label="Erdgas L [kWh (HS)]" value="Erdgas L [kWh (HS)]"></el-option>
                            <el-option label="Erdgas H [m³]" value="Erdgas H [m³]"></el-option>
                            <el-option label="Erdgas H [kWh (HS)]" value="Erdgas H [kWh (HS)]"></el-option>
                            <el-option label="Stadtgas [kWh]" value="Stadtgas [kWh]"></el-option>
                            <el-option label="Stadtgas [kWh (HS)]" value="Stadtgas [kWh (HS)]"></el-option>
                            <el-option label="Flüssiggas [kg]" value="Flüssiggas [kg]"></el-option>
                            <el-option label="Stückholz [kg]" value="Stückholz [kg]"></el-option>
                            <el-option label="Holzhackschnitzel [SRm]" value="Holzhackschnitzel [SRm]"></el-option>
                            <el-option label="Holzpellets [kg]" value="Holzpellets [kg]"></el-option>
                            <el-option label="Fernwärme [kWh]" value="Fernwärme [kWh]"></el-option>
                            <el-option label="Strom [kWh]" value="Strom [kWh]"></el-option>
                            <el-option label="Blockheizkraftwerk [kWh]" value="Blockheizkraftwerk [kWh]"></el-option>
                        </el-select>
                    </el-form-item>
                    <el-form-item label="Warmwasser" :error="errors.water">
                        <el-select v-model="addSourceForm.water" size="large" class="w-full"
                                   placeholder="Bitte auswählen">
                            <el-option default-first-option label="Im Verbrauch enthalten - Genaue Werte unbekannt"
                                       value="Im Verbrauch enthalten - Genaue Werte unbekannt" />
                            <el-option default-first-option label="Im Verbrauch enthalten - Genaue Werte bekannt"
                                       value="Im Verbrauch enthalten - Genaue Werte bekannt" />
                            <el-option default-first-option
                                       label="Nicht im Verbrauch enthalten - Genaue Werte unbekannt"
                                       value="Nicht im Verbrauch enthalten - Genaue Werte unbekannt" />
                            <el-option default-first-option label="Nicht im Verbrauch enthalten - Genaue Werte bekannt"
                                       value="Nicht im Verbrauch enthalten - Genaue Werte bekannt" />
                        </el-select>
                    </el-form-item>
                </el-form>
            </div>
        </template>
        <template #footer>
            <div style="flex: auto">
                <el-button @click="cancelSource">Abbrechen</el-button>
                <el-button type="primary" @click="addSource" :loading="drawer.loading">Anlegen</el-button>
            </div>
        </template>
    </el-drawer>
    <StepperWrapper>

        <el-form label-position="top" class="grid sm:grid-cols-2 gap-4">

            <div class="sm:col-span-2 mb-4">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Verbrauch
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Im Folgenden können Sie die Energieträger und die zugehörigen Abrechnungszeiträume dafür erfassen.
                    Dafür brauchen Sie die Rechnungen Ihres Energieversorgers - geschätzte Werte sind nicht zulässig.
                </p>
                <p class="mt-1 text-sm text-gray-500">
                    Für den Verbrauchsausweis müssen mindestens 36 Monate erfasst werden.
                </p>
            </div>

            <template v-if="product.sources.length > 0">

                <template v-for="source in product.sources" :key="source.id">

                    <div class="sm:col-span-2 px-6 py-4 bg-slate-50 shadow border border-gray-100 rounded-md">
                        <div class="sm:flex sm:items-center">
                            <div class="sm:flex-auto">
                                <div class="flex items-center">
                                    <h5 class="text-xl font-semibold text-gray-900">
                                        {{ source.source.replace(/\[(.*?)\]/gm.exec(source.source)[0], '') }}
                                    </h5>

                                    <el-button text type="danger" class="group ml-2" @click="deleteSource(source.id)">
                                        <TrashIcon class="h-5 w-5 text-gray-400 group-hover:text-red-500" />
                                    </el-button>
                                    <span v-if="source.main"
                                          class="ml-2 inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-xs font-medium text-blue-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor"
                                             viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Hauptenergieträger
                                    </span>
                                </div>
                                <p class="mt-2 text-sm text-gray-700">Warmwasser: {{ source.water }}</p>
                            </div>

                            <div>
                                <el-progress
                                    type="dashboard"
                                    :percentage="getMonths(source) <= 36 ? 100 / 36 * getMonths(source) : 100"
                                    width="80"
                                    :color="getMonths(source) < 36 ? '#3b82f6' : '#10b981'"
                                >
                                    <template #default="{ percentage }">
                                        <div class="flex flex-col">
                                            <span class="font-semibold">{{ getMonths(source) }}</span>
                                            <span class="text-xs">Monate</span>
                                        </div>
                                    </template>
                                </el-progress>
                            </div>
                        </div>
                        <div class="mt-4 flex flex-col">
                            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead>
                                        <tr>
                                            <th scope="col"
                                                class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">
                                                Abrechnungszeitraum
                                            </th>
                                            <th scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">
                                                Verbrauch
                                            </th>
                                            <th v-if="source.water_enabled" scope="col"
                                                class="py-3.5 px-3 text-left text-sm font-semibold text-gray-900">Anteil
                                                Wasser
                                            </th>
                                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
                                                <span class="sr-only">
                                                    Aktion
                                                </span>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-200">
                                        <tr v-for="period in source.periods" :key="period.id">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 md:pl-0">
                                                {{ dayjs(period.start).locale('de').format('MMM YYYY') }} -
                                                {{ dayjs(period.end).locale('de').format('MMM YYYY') }}
                                            </td>
                                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                                {{ period.consumption }} {{ /\[(.*?)\]/gm.exec(source.source)[1] }}
                                            </td>
                                            <td v-if="source.water_enabled"
                                                class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                                {{ period.water }} {{ /\[(.*?)\]/gm.exec(source.source)[1] }}
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                                                <el-button text type="danger" class="group"
                                                           @click="deletePeriod(source.id, period.id)">
                                                    <TrashIcon class="h-5 w-5 text-gray-400 group-hover:text-red-500" />
                                                </el-button>
                                            </td>
                                        </tr>
                                        <tr v-if="getMonths(source) < 36">
                                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 md:pl-0">
                                                <el-form-item :error="errors.period">
                                                    <el-date-picker v-model="addPeriodForm.period"
                                                                    type="monthrange"
                                                                    range-separator=" - " start-placeholder="Von"
                                                                    end-placeholder="Bis" format="MMM YYYY"
                                                                    :disabled-date="date => date > new Date() || date < new Date(2008, 0 , 1)"
                                                                    :shortcuts="shortcuts">
                                                    </el-date-picker>
                                                </el-form-item>
                                            </td>
                                            <td class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">

                                                <el-form-item :error="errors.consumption">
                                                    <el-input v-model="addPeriodForm.consumption">
                                                        <template #append>
                                                            <span class="text-xs">
                                                                {{ /\[(.*?)\]/gm.exec(source.source)[1] }}
                                                            </span>
                                                        </template>
                                                    </el-input>

                                                </el-form-item>
                                            </td>
                                            <td v-if="source.water_enabled"
                                                class="whitespace-nowrap py-4 px-3 text-sm text-gray-500">
                                                <el-form-item :error="errors.water">

                                                    <el-input v-model="addPeriodForm.water">
                                                        <template #append>
                                                            <span class="text-xs">
                                                                {{ /\[(.*?)\]/gm.exec(source.source)[1] }}
                                                            </span>
                                                        </template>
                                                    </el-input>

                                                </el-form-item>
                                            </td>
                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                                                <el-form-item>
                                                    <el-button text type="primary" @click="addPeriod(source.id)">
                                                        <PlusIcon class="h-4 w-4 mr-2 group-hover:text-green-500" />
                                                        Hinzufügen
                                                    </el-button>
                                                </el-form-item>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>

                                    <el-alert v-if="errors.error" :title="errors.error" type="error" show-icon />
                                </div>
                            </div>
                        </div>
                    </div>
                    <el-divider class="sm:col-span-2"></el-divider>
                </template>

                <div class="flex items-center">

                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Weitere Energieträger?
                    </h3>

                </div>
                <div class="flex justify-end">
                    <el-button type="default" @click="showDrawer">Weiterer Energieträger</el-button>
                </div>
            </template>

            <template v-else>
                <div class="flex sm:col-span-2 justify-center">
                    <el-empty description="Noch keinen Energieträger angelegt">
                        <el-button size="large" type="primary" @click="showDrawer">Energieträger anlegen</el-button>
                    </el-empty>

                </div>
            </template>


            <el-divider class="sm:col-span-2"></el-divider>

            <div class="sm:col-span-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Leerstand
                    <el-switch v-model="hasVacancy" size="large" class="ml-2"></el-switch>
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Angaben zum Leerstand in oben erfassten Abrechnungszeiträumen
                </p>
            </div>

            <template v-if="hasVacancy" class="sm:col-span-2">
                <el-tabs v-model="activeName" class="sm:col-span-2">
                    <el-tab-pane label="Prozentual" name="percentage">
                        <el-form-item class="w-full sm:w-1/2" label="Mittlerer Leerstand" :error="errors.percentage">
                            <el-input v-model="markDoneForm.percentage" size="large">
                                <template #append>%</template>
                            </el-input>
                        </el-form-item>
                        <el-alert v-if="product.vacancies.length > 0" type="info" show-icon>
                            Falls ein prozentualer Wert eingetragen wird, führt dies zur Löschung sämtlicher
                            Zeiträume unter "Genauer Zeitraum".
                        </el-alert>
                    </el-tab-pane>
                    <el-tab-pane label="Genauer Zeitraum" name="period">

                        <table class="min-w-full divide-y divide-gray-300">
                            <thead>
                            <tr>
                                <th scope="col"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6 md:pl-0">
                                    Leerstandszeitraum
                                </th>
                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6 md:pr-0">
                                    <span class="sr-only">
                                        Aktion
                                    </span>
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            <tr v-for="period in product.vacancies" :key="period.id">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 md:pl-0">
                                    {{ dayjs(period.start).locale('de').format('MMM YYYY') }} -
                                    {{ dayjs(period.end).locale('de').format('MMM YYYY') }}
                                </td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                                    <el-button text type="danger" class="group"
                                               @click="deleteVacancy(period.id)">
                                        <TrashIcon class="h-5 w-5 text-gray-400 group-hover:text-red-500" />
                                    </el-button>
                                </td>
                            </tr>
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6 md:pl-0">
                                    <div class="flex">
                                        <el-form-item :error="errors.period">
                                            <el-date-picker v-model="addVacancyForm.period"
                                                            type="monthrange"
                                                            range-separator=" - "
                                                            start-placeholder="Von"
                                                            end-placeholder="Bis" format="MMM YYYY"
                                                            :disabled-date="date => date > new Date() || date < new Date(2008, 0 , 1)"
                                                            :shortcuts="shortcuts">
                                            </el-date-picker>
                                        </el-form-item>

                                    </div>
                                </td>

                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6 md:pr-0">
                                    <div class="flex justify-end">
                                        <el-form-item>
                                            <el-button text type="primary" @click="addVacancy">
                                                <PlusIcon class="h-4 w-4 mr-2 group-hover:text-green-500" />
                                                Hinzufügen
                                            </el-button>
                                        </el-form-item>
                                    </div>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                        <el-alert v-if="errors['vacancy.error']" :title="errors['vacancy.error']" type="error"
                                  show-icon />
                        <el-alert v-if="product.vacancy_percentage" title="Durch das Hinzufügen von Leerstandszeiträumen wird der eingetragene prozentuale Wert gelöscht" type="info"
                                  show-icon />
                    </el-tab-pane>
                </el-tabs>
            </template>

            <el-divider class="sm:col-span-2"></el-divider>

            <div class="sm:col-span-2 flex justify-end">
                <el-button type="primary" size="large" @click="markDone" :disabled="!mainSourceHas36Months">
                    {{ !mainSourceHas36Months ? 'Nicht genügend Daten' : 'Speichern & Weiter' }}
                </el-button>
            </div>

        </el-form>

    </StepperWrapper>

</template>
