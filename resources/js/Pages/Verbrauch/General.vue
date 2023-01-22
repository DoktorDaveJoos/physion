<script>
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import AppLayout from '../../Layouts/GuestLayout.vue';
import { reactive } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: { StepperWrapper },
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
            name: props.customer.name ?? null,
            email: props.customer.email ?? null,
            phone: props.customer.phone ?? null,
            street_address: props.product.street_address ?? null,
            zip: props.product.zip ?? null,
            city: props.product.city ?? null,
            type: props.product.type ?? null,
            additional_type: props.product.additional_type ?? null,
            reason: props.product.reason,
        });

        const handleSubmit = () => {
            Inertia.put(
                route('verbrauch.general.update', props.order.id),
                form
            );
        };

        return {
            handleSubmit,
            form,
        };
    },
};
</script>

<template>
    <StepperWrapper>
        <el-form
            @submit.prevent="handleSubmit"
            label-position="top"
            class="grid sm:grid-cols-2 gap-4">
            <div class="sm:col-span-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Auftraggeber
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Informationen zum Auftraggeber
                </p>
            </div>

            <el-form-item label="Name" :error="errors.name">
                <el-input v-model="form.name" size="large"></el-input>
            </el-form-item>

            <el-form-item label="Email" :error="errors.email">
                <el-input v-model="form.email" size="large" disabled></el-input>
            </el-form-item>

            <el-form-item label="Telefon" :error="errors.phone">
                <el-input v-model="form.phone" size="large"></el-input>
            </el-form-item>

            <el-divider class="sm:col-span-2" />

            <div class="sm:col-span-2">
                <h3 class="text-lg font-medium leading-6 text-gray-900">
                    Gebäude
                </h3>
                <p class="mt-1 text-sm text-gray-500">
                    Allgemeine Informationen zum Gebäude
                </p>
            </div>

            <el-form-item
                label="Straße & Hausnummer"
                :error="errors.street_address">
                <el-input v-model="form.street_address" size="large"></el-input>
            </el-form-item>

            <div class="hidden sm:block"></div>

            <el-form-item label="Postleitzahl" :error="errors.zip">
                <el-input v-model="form.zip" size="large"></el-input>
            </el-form-item>

            <el-form-item label="Stadt / Gemeinde" :error="errors.city">
                <el-input v-model="form.city" size="large"></el-input>
            </el-form-item>

            <el-form-item label="Gebäudetyp" :error="errors.type">
                <el-select
                    v-model="form.type"
                    size="large"
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

            <el-form-item label="Gebäudeart" :error="errors.additional_type">
                <el-select
                    v-model="form.additional_type"
                    placeholder="Bitte auswählen"
                    size="large"
                    class="w-full">
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

            <el-divider class="sm:col-span-2" />

            <div class="sm:col-span-2 flex justify-end">
                <button
                    type="submit"
                    class="inline-flex mt-3 justify-center rounded-md border border-transparent bg-blue-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Speichern & Weiter
                </button>
            </div>
        </el-form>
    </StepperWrapper>
</template>
