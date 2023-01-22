<template>
    <GuestLayout>
        <div class="relative bg-white">
            <div class="absolute inset-0">
                <div class="absolute inset-y-0 left-0 w-1/2 bg-gray-50" />
            </div>
            <div class="relative mx-auto max-w-7xl lg:grid lg:grid-cols-5">
                <div
                    class="bg-gray-50 py-16 px-6 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12">
                    <div class="mx-auto max-w-lg">
                        <h2
                            class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            Immer für Sie da
                        </h2>
                        <p class="mt-3 text-lg leading-6 text-gray-500">
                            Unser Team steht Ihnen jederzeit zur Verfügung, um
                            Ihre Fragen zu beantworten und Ihnen bestmöglich zu
                            helfen. Wir legen großen Wert auf eine herzliche und
                            persönliche Betreuung unserer Kunden und werden uns
                            bemühen, Ihnen schnell und zufriedenstellend zu
                            antworten.
                        </p>
                        <dl class="mt-8 text-base text-gray-500">
                            <div>
                                <dt class="sr-only">Anschrift</dt>
                                <dd>
                                    <p>Edensbach</p>
                                    <p>88289 Waldburg</p>
                                </dd>
                            </div>
                            <div class="mt-3">
                                <dt class="sr-only">Email</dt>
                                <dd class="flex items-center">
                                    <EnvelopeIcon
                                        class="h-6 w-6 flex-shrink-0 text-gray-400"
                                        aria-hidden="true" />
                                    <span class="ml-3"
                                        >support@bauzertifikate.de</span
                                    >
                                </dd>
                            </div>
                        </dl>
                        <p class="mt-6 text-base text-gray-500">
                            Anfragen über das Kontaktformular werden innerhalb
                            von 24 Stunden bearbeitet. Bei Anfragen per Email
                            bitten wir um Verständnis, dass es zu einer
                            Verzögerung kommen kann.
                        </p>
                    </div>
                </div>
                <div
                    class="bg-white py-16 px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
                    <div class="mx-auto max-w-lg lg:max-w-none">
                        <el-form size="large" label-position="top">
                            <el-form-item
                                :required="true"
                                label="Name"
                                :error="form.errors.name">
                                <el-input
                                    v-model="form.name"
                                    placeholder="Name" />
                            </el-form-item>

                            <el-form-item
                                :required="true"
                                label="Email"
                                :error="form.errors.email">
                                <el-input
                                    v-model="form.email"
                                    placeholder="Email" />
                            </el-form-item>

                            <el-form-item
                                label="Telefon"
                                :error="form.errors.phone">
                                <el-input
                                    v-model="form.phone"
                                    placeholder="Name" />
                            </el-form-item>

                            <el-form-item
                                :required="true"
                                label="Nachricht"
                                :error="form.errors.message">
                                <el-input
                                    :rows="4"
                                    type="textarea"
                                    v-model="form.message"
                                    placeholder="Nachricht" />
                            </el-form-item>

                            <el-form-item>
                                <el-button type="primary" @click="submit"
                                    >Absenden</el-button
                                >
                            </el-form-item>
                        </el-form>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { EnvelopeIcon, PhoneIcon } from '@heroicons/vue/24/outline';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ElNotification } from 'element-plus';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    message: '',
});

const submit = () => {
    form.post(route('contact.store'), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset('name', 'email', 'phone', 'message');
            ElNotification({
                title: 'Erfolg',
                message:
                    'Wir haben Ihre Nachricht erhalten und werden uns schnellstmöglich bei Ihnen melden.',
                type: 'success',
            });
        },
    });
};
</script>
