<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import { Loader } from '@googlemaps/js-api-loader';
import FormHeader from './FormHeader.vue';
import { onMounted, ref } from 'vue';
import { ElNotification } from 'element-plus';
import BzButton from './BzButton.vue';

const props = defineProps({
    category: {
        type: String,
        default: null,
    },
    order: {
        type: Object,
        default: null,
    },
});

const form = useForm({
    name: null,
    email: null,
    phone: null,
    street_address: null,
    zip: null,
    city: null,
    place_id: null,
    reason: null,
    type: null,
    additional_type: null,
});

if (props.order) {
    const { certificate, customer } = props.order;

    form.name = customer.name;
    form.email = customer.email;
    form.phone = customer.phone;

    form.reason = certificate.reason;
    form.street_address = certificate.street_address;
    form.zip = certificate.zip;
    form.city = certificate.city;
    form.type = certificate.type;
    form.additional_type = certificate.additional_type;
}

const agreed = ref(false);
const select = ref('DE');
const street_address = ref(null);
const zip = ref(null);
const city = ref(null);

const API_KEY = import.meta.env.VITE_GOOGLE_MAPS_API_KEY;

const loader = new Loader({
    apiKey: API_KEY,
    version: 'weekly',
    libraries: ['places'],
});

const google = await loader.load();

onMounted(() => {
    const autocomplete = new google.maps.places.Autocomplete(
        street_address.value.input,
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
                    address1 = `${address1}${' ' + component.long_name}`;
                    break;
                case 'route':
                    address1 = `${component.long_name}${address1}`;
                    break;
                case 'postal_code':
                    form.zip = component.long_name;
                    break;
                case 'locality':
                    form.city = component.long_name;
                    break;
            }
        }

        street_address.value.input.value = address1;
    });
});

const submit = () => {
    if (props.category) {
        form.post(route('order.create', { category: props.category }));
        return;
    }

    form.put(
        route('certificate.update', {
            order: props.order.slug,
            page: 'general',
            signature: route().params.signature,
        })
    );
};
</script>

<template>
    <el-form
        :class="category ? 'py-16' : ''"
        :model="form"
        class="grid sm:grid-cols-2 sm:gap-x-8"
        label-position="top"
        size="large"
        @submit.prevent="submit">
        <form-header
            subtitle="Angaben zum Auftraggeber und Kontakt im Falle von Rückfragen."
            title="Auftraggeber" />

        <el-form-item
            :error="form.errors.name"
            :required="true"
            label="Vorname">
            <el-input v-model="form.name" autocomplete="give-name" />
        </el-form-item>

        <el-form-item :error="form.errors.email" :required="true" label="Email">
            <el-input
                v-model="form.email"
                :disabled="!category"
                autocomplete="email" />
        </el-form-item>

        <el-form-item :error="form.errors.phone" label="Telefonnummer">
            <el-input v-model="form.phone" placeholder="172 124567">
                <template #prepend>
                    <el-select
                        v-model="select"
                        placeholder="172 124567"
                        style="width: 80px">
                        <el-option
                            default-first-option
                            label="+49"
                            value="DE" />
                        <el-option
                            default-first-option
                            label="+43"
                            value="AT" />
                    </el-select>
                </template>
            </el-input>
        </el-form-item>

        <el-divider class="md:col-span-2" />

        <form-header
            subtitle="Geben Sie den Grund für die Ausstellung des Energieausweises an"
            title="Grund für die Ausstellung" />

        <el-form-item
            :error="form.errors.reason"
            :required="true"
            label="Ausstellungsgrund">
            <el-select
                v-model="form.reason"
                class="w-full"
                placeholder="Bitte auswählen">
                <el-option
                    default-first-option
                    label="Modernisierung/Änderung"
                    value="Modernisierung/Änderung" />
                <el-option
                    default-first-option
                    label="Vermietung/Verkauf"
                    value="Vermietung/Verkauf" />
                <el-option
                    default-first-option
                    label="Sonstiges"
                    value="Sonstiges" />
            </el-select>
        </el-form-item>

        <el-divider class="md:col-span-2" />

        <form-header
            subtitle="Das Gebäude für den Energieausweis"
            title="Angaben zum Gebäude" />

        <el-form-item
            :error="form.errors.street_address"
            :required="true"
            label="Straße & Hausnummer">
            <el-input
                ref="street_address"
                v-model="form.street_address"
                autocomplete="street_address" />
        </el-form-item>

        <!-- Spacer-->
        <div class="hidden md:block"></div>

        <el-form-item
            id="zip"
            :error="form.errors.zip"
            :required="true"
            label="Postleitzahl">
            <el-input ref="zip" v-model="form.zip" autocomplete="zip" />
        </el-form-item>

        <el-form-item
            id="city"
            :error="form.errors.city"
            :required="true"
            label="Stadt / Gemeinde">
            <el-input ref="city" v-model="form.city" autocomplete="city" />
        </el-form-item>

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
                    label="Bürogebäude"
                    value="Bürogebäude" />
            </el-select>
        </el-form-item>

        <el-form-item
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

        <template v-if="category">
            <div class="sm:col-span-2 mt-6">
                <div class="flex items-center">
                    <el-switch v-model="agreed" />
                    <span class="text-xs ml-4 text-gray-500">
                        Sie stimmen zu, dass wir Sie bezüglich Ihrer Anfrage
                        kontaktieren dürfen.
                    </span>
                </div>
            </div>

            <div class="sm:col-span-2 mt-8">
                <button
                    :disabled="form.processing || !agreed"
                    class="inline-flex w-full items-center justify-center rounded-md border border-transparent bg-blue-600 px-6 py-3 text-base font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:bg-gray-400"
                    @click="submit">
                    <span v-if="form.processing" class="animate-spin mr-3">
                        <svg
                            class="h-5 w-5 text-white"
                            fill="none"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4"></circle>
                            <path
                                class="opacity-75"
                                d="M4 12a8 8 0 018-8v8H4z"
                                fill="currentColor"></path>
                        </svg>
                    </span>
                    {{
                        !agreed
                            ? 'Zustimmung erforderlich'
                            : 'Speichern & Weiter'
                    }}
                </button>
            </div>
        </template>

        <template v-else>
            <el-divider class="sm:col-span-2" />

            <div
                class="flex flex-col sm:flex-row sm:col-span-2 w-full justify-end">
                <bz-button class="" type="primary" @click="submit"
                    >Speichern & Weiter
                </bz-button>
            </div>
        </template>
    </el-form>
</template>
