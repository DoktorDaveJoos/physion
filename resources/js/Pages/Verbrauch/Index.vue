<script>
import {reactive, ref} from 'vue';
import {Switch} from '@headlessui/vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import {Inertia} from '@inertiajs/inertia';
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';

export default {
    components: {StepperWrapper, Switch},
    layout: [GuestLayout],
    props: {
        errors: Object,
    },
    setup() {
        const form = reactive({
            name: null,
            email: null,
            reason: null,
            street_address: null,
            zip: null,
            city: null,
            phone: null,
            type: null,
            additional_type: null,
        });

        const submit = () => {
            Inertia.post(route('verbrauch.create'), form);
        };

        const select = ref('DE');
        const agreed = ref(false);
        return {form, submit, agreed, select};
    },
};

</script>
<template>
    <StepperWrapper>
        <div class="overflow-hidden bg-white rounded-md px-4 sm:px-6 lg:px-8">
            <div class="relative w-full">

                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-center text-gray-800 sm:text-3xl">Verbrauchsausweis
                        erstellen</h2>
                    <p class="mt-4 text-lg leading-6 text-gray-500">Erstelle deinen Bedarfsausweis online mit
                        Möglichkeit
                        zum Pausieren und Verfolgen des Bearbeitungsstatus</p>
                </div>

                <el-form @submit.prevent="submit" :model="form" label-position="top" class="mt-12">
                    <div class="grid grid-cols-1 sm:grid-cols-2 sm:gap-x-8">
                        <div class="sm:col-span-2 mb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Auftraggeber
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Angaben zum Auftraggeber und Kontakt im Falle von Rückfragen
                            </p>
                        </div>

                        <el-form-item
                            label="Name"
                            :error="errors.name">
                            <el-input v-model="form.name"
                                      type="text" size="large"
                                      name="name"
                                      id="name"
                                      autocomplete="give-name"
                                      class="block w-full" />
                        </el-form-item>

                        <el-form-item
                            label="Email"
                            :error="errors.email">
                            <el-input v-model="form.email"
                                      size="large"
                                      id="email"
                                      name="email"
                                      type="email"
                                      autocomplete="email"
                                      class="block w-full" />
                        </el-form-item>

                        <el-form-item
                            label="Telefonnummer"
                            :error="errors.phone">
                            <el-input
                                size="large"
                                v-model="form.phone"
                                placeholder="172 124567"
                                class="input-with-select"
                            >
                                <template #prepend>
                                    <el-select size="large"
                                               v-model="select"
                                               placeholder="172 124567"
                                               style="width: 80px">
                                        <el-option default-first-option label="+49" value="DE" />
                                        <el-option default-first-option label="+43" value="AT" />
                                    </el-select>
                                </template>
                            </el-input>
                        </el-form-item>

                        <el-divider class="md:col-span-2" />

                        <div class="sm:col-span-2 mb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Grund für die Ausstellung
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Geben Sie den Grund für die Ausstellung des Energieausweises an
                            </p>
                        </div>

                        <el-form-item
                            label="Ausstellungsgrund"
                            :error="errors.reason">
                            <el-select v-model="form.reason"
                                       placeholder="Bitte auswählen"
                                       size="large"
                                       id="type"
                                       name="type"
                                       class="mt-1 block w-full">
                                <el-option default-first-option label="Modernisierung/Änderung" value="Modernisierung/Änderung" />
                                <el-option default-first-option label="Vermietung/Verkauf" value="Vermietung/Verkauf" />
                                <el-option default-first-option label="Sonstiges" value="Sonstiges" />
                            </el-select>
                        </el-form-item>


                        <el-divider class="md:col-span-2" />

                        <div class="sm:col-span-2 mb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">
                                Angaben zum Gebäude
                            </h3>
                            <p class="mt-1 text-sm text-gray-500">
                                Das Gebäude für den Energieausweis
                            </p>
                        </div>

                        <el-form-item
                            label="Straße & Hausnummer"
                            :error="errors.street_address">
                            <el-input size="large"
                                      v-model="form.street_address"
                                      type="text"
                                      name="street_address"
                                      id="street_address"
                                      autocomplete="street_address"
                                      class="block w-full" />
                        </el-form-item>

                        <!--                        Spacer-->
                        <div class="hidden md:block"></div>

                        <el-form-item label="Postleitzahl"
                                      :error="errors.zip">
                            <el-input v-model="form.zip"
                                      size="large" type="text"
                                      name="zip"
                                      id="zip"
                                      autocomplete="zip"
                                      class="block w-full" />
                        </el-form-item>

                        <el-form-item label="Stadt / Gemeinde"
                                      :error="errors.city">
                            <el-input v-model="form.city"
                                      size="large"
                                      type="text"
                                      name="city"
                                      id="city"
                                      autocomplete="city"
                                      class="block w-full" />
                        </el-form-item>

                        <el-form-item
                            label="Gebäudetyp"
                            :error="errors.type">
                            <el-select v-model="form.type"
                                       placeholder="Bitte auswählen"
                                       size="large"
                                       id="type"
                                       name="type"
                                       class="mt-1 block w-full">
                                <el-option default-first-option label="Einfamilienhaus" value="Einfamilienhaus" />
                                <el-option default-first-option label="Mehrfamilienhaus" value="Mehrfamilienhaus" />
                                <el-option default-first-option label="Bürogebäude" value="Bürogebäude" />
                            </el-select>
                        </el-form-item>

                        <el-form-item
                            label="Gebäudeart"
                            :error="errors.additional_type">
                            <el-select v-model="form.additional_type"
                                       placeholder="Bitte auswählen"
                                       size="large"
                                       id="additional_type"
                                       name="additional_type"
                                       class="mt-1 block w-full">
                                <el-option default-first-option label="Freistehend" value="Freistehend" />
                                <el-option default-first-option label="Doppelhaushälfte" value="Doppelhaushälfte" />
                                <el-option default-first-option label="Reiheneckhaus" value="Reiheneckhaus" />
                                <el-option default-first-option label="Reihenmittelhaus" value="Reihenmittelhaus" />
                            </el-select>
                        </el-form-item>

                        <div class="sm:col-span-2 mt-6">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <Switch v-model="agreed"
                                            :class="[agreed ? 'bg-blue-600' : 'bg-gray-200', 'relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2']">
                                        <span class="sr-only">Agree to policies</span>
                                        <span aria-hidden="true"
                                              :class="[agreed ? 'translate-x-5' : 'translate-x-0', 'inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out']" />
                                    </Switch>
                                </div>
                                <div class="ml-3">
                                    <p class="text-xs text-gray-500">
                                        Sie stimmen zu, dass wir Sie bei Rückfragen bzgl des Auftrags kontaktieren dürfen.
                                        Sie stimmen der Nutzung von
                                        {{ ' ' }}
                                        <a href="#" class="font-medium text-gray-700 underline">Cookies</a>
                                        {{ ' ' }}
                                        zu.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-2 mt-8">
                            <button type="submit"
                                    :disabled="form.processing || !agreed"
                                    class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:bg-gray-400">

                                <span v-if="form.processing" class="animate-spin mr-3">
                                    <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                </span>
                                {{ !agreed ? 'Zustimmung erforderlich' : 'Speichern & Weiter' }}
                            </button>
                        </div>
                    </div>
                </el-form>
            </div>
        </div>
    </StepperWrapper>
</template>

