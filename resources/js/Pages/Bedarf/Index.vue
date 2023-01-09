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
            street_address: null,
            zip: null,
            city: null,
            phone: null,
            type: null,
            additional_type: null,
            construction_year: null,
            housing_units: null,
        });

        const submit = () => {
            Inertia.post(route('bedarf.create'), form);
        };

        const agreed = ref(true);
        return {form, submit, agreed};
    },
};

</script>
<template>

    <StepperWrapper>


        <div class="overflow-hidden bg-white rounded-md px-4 py-8 sm:px-6 lg:px-8 lg:py-24">
            <div class="relative mx-auto max-w-xl">

                <div class="text-center">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-800 sm:text-4xl">Bedarfsausweis
                        erstellen</h2>
                    <p class="mt-4 text-lg leading-6 text-gray-500">Erstelle deinen Bedarfsausweis online mit
                        Möglichkeit
                        zum Pausieren und Verfolgen des Bearbeitungsstatus</p>
                </div>
                <form @submit.prevent="submit" class="mt-12">
                    <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">

                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <div class="mt-1">
                                <input v-model="form.name" type="text" name="name" id="name" autocomplete="give-name"
                                       class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            </div>
                            <div class="text-xs text-red-500" v-if="errors.name">{{ errors.name }}</div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <div class="mt-1">
                                <input v-model="form.email" id="email" name="email" type="email" autocomplete="email"
                                       class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            </div>
                            <div class="text-xs text-red-500" v-if="errors.email">{{ errors.email }}</div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="phone-number" class="flex justify-between text-sm font-medium text-gray-700">Telefonnummer
                                <span class="ml-1 text-xs text-gray-400 self-center">Optional</span>
                            </label>
                            <div class="relative mt-1 rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 flex items-center">
                                    <label for="country" class="sr-only">Country</label>
                                    <select id="country" name="country"
                                            class="h-full rounded-md border-transparent bg-transparent py-0 pl-4 pr-8 text-gray-500 focus:border-blue-500 focus:ring-blue-500">
                                        <option>DE</option>
                                    </select>
                                </div>
                                <input v-model="form.phone" type="text" name="phone-number" id="phone-number"
                                       autocomplete="tel"
                                       class="block w-full rounded-md border-gray-300 py-3 px-4 pl-20 focus:border-blue-500 focus:ring-blue-500"
                                       placeholder="+49 170 2345678" />
                            </div>
                            <div class="text-xs text-red-500" v-if="errors.phone">{{ errors.phone }}</div>
                        </div>

                        <div class="border-b my-4 border-gray-200 sm:col-span-2"></div>

                        <div class="sm:col-span-2 text-center">
                            <p class="text-lg leading-6 text-gray-500">Angaben zum Gebäude</p>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="street_address" class="block text-sm font-medium text-gray-700">Straße &
                                Hausnummer</label>
                            <div class="mt-1">
                                <input v-model="form.street_address" type="text" name="street_address"
                                       id="street_address"
                                       autocomplete="street_address"
                                       class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            </div>
                            <div class="text-xs text-red-500" v-if="errors.street_address">{{ errors.street_address }}
                            </div>
                        </div>

                        <div>
                            <label for="zip" class="block text-sm font-medium text-gray-700">Postleitzahl</label>
                            <div class="mt-1">
                                <input v-model="form.zip" type="text" name="zip" id="zip"
                                       autocomplete="zip"
                                       class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            </div>
                            <div class="text-xs text-red-500" v-if="errors.zip">{{ errors.zip }}</div>
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">Stadt / Gemeinde</label>
                            <div class="mt-1">
                                <input v-model="form.city" type="text" name="city" id="city"
                                       autocomplete="city"
                                       class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            </div>
                            <div class="text-xs text-red-500" v-if="errors.city">{{ errors.city }}</div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="type" class="block text-sm font-medium text-gray-700">Gebäudetyp</label>
                            <select v-model="form.type" id="type" name="type"
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option>Einfamilienhaus</option>
                                <option>Mehrfamilienhaus</option>
                                <option>Bürogebäude</option>
                            </select>
                            <div class="text-xs text-red-500" v-if="errors.type">{{ errors.type }}</div>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="additional_type"
                                   class="block text-sm font-medium text-gray-700">Gebäudeart</label>
                            <select v-model="form.additional_type" id="additional_type" name="additional_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option>Freistehend</option>
                                <option>Doppelhaushälfte</option>
                                <option>Reiheneckhaus</option>
                                <option>Reihenmittelhaus</option>
                            </select>
                            <div class="text-xs text-red-500" v-if="errors.additional_type">
                                {{ errors.additional_type }}
                            </div>
                        </div>

                        <div>
                            <label for="construction_year"
                                   class="block text-sm font-medium text-gray-700">Baujahr</label>
                            <div class="mt-1">
                                <input v-model="form.construction_year" type="text" name="construction_year"
                                       id="construction_year"
                                       autocomplete="construction_year"
                                       class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            </div>
                            <div class="text-xs text-red-500" v-if="errors.construction_year">
                                {{ errors.construction_year }}
                            </div>
                        </div>

                        <div>
                            <label for="housing_units"
                                   class="block text-sm font-medium text-gray-700">Wohneinheiten</label>
                            <div class="mt-1">
                                <input v-model="form.housing_units" type="text" name="housing_units" id="housing_units"
                                       autocomplete="housing_units"
                                       class="block w-full rounded-md border-gray-300 py-3 px-4 shadow-sm focus:border-blue-500 focus:ring-blue-500" />
                            </div>
                            <div class="text-xs text-red-500" v-if="errors.housing_units">{{ errors.housing_units }}
                            </div>
                        </div>

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
                                    <p class="text-base text-gray-500">
                                        Sie stimmen zu, dass wir Sie bezüglich Ihres Energieausweises kontaktieren
                                        dürfen und das wir
                                        {{ ' ' }}
                                        <a href="#" class="font-medium text-gray-700 underline">Cookies</a>
                                        {{ ' ' }}
                                        verwenden.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-2">
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
                </form>
            </div>
        </div>
    </StepperWrapper>
</template>

