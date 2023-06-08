<template>
    <GuestLayout>
        <div class="relative bg-white">
            <div class="absolute inset-0">
                <div class="absolute inset-y-0 left-0 w-1/2 bg-slate-50" />
            </div>
            <div class="relative mx-auto max-w-7xl lg:grid lg:grid-cols-5">
                <div
                    class="bg-slate-50 py-16 px-6 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12">
                    <div class="mx-auto max-w-lg">
                        <h2
                            class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">
                            Find my {{ animated }}{{ blinking ? '|' : '' }}
                        </h2>
                        <p class="mt-3 text-lg leading-6 text-gray-500">
                            Unser einzigartiger "Find My Energieausweis" Service
                            garantiert, dass Sie Ihren Energieausweis niemals
                            wieder verlieren oder verlegen können.
                        </p>
                        <p class="mt-3 text-lg leading-6 text-gray-500">
                            Selbst wenn Sie die Bestellnummer nicht mehr kennen,
                            können Sie Ihren Ausweis einfach durch die Angabe
                            Ihrer E-Mail-Adresse in Verbindung mit der
                            Postleitzahl des Gebäudes auffinden. Mit dieser
                            innovativen Lösung haben Sie jederzeit und von
                            überall Zugriff auf Ihren wichtigen Energieausweis.
                        </p>
                        <dl class="mt-8 text-base text-gray-500">
                            <div class="mt-3">
                                <dt class="">Trotzdem nicht gefunden?</dt>
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
                    </div>
                </div>
                <div
                    class="bg-white py-16 px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
                    <div class="mx-auto max-w-lg lg:max-w-none">
                        <el-tabs tab-position="top">
                            <el-tab-pane label="Order ID" class="pt-4">
                                <h2
                                    class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                                    Via Order ID
                                </h2>

                                <p class="mt-3 text-lg leading-6 text-gray-500">
                                    Bitte geben Sie Ihre Bestellnummer ein, die
                                    Sie bei der Bestellung erhalten haben.
                                </p>
                                <p
                                    class="mt-3 text-lg leading-6 text-gray-500 mb-6">
                                    Keine Email erhalten? Schauen Sie auch im
                                    Spam Ordner.
                                </p>
                                <el-form size="large" label-position="top">
                                    <el-form-item
                                        label="Order ID"
                                        :error="orderForm.errors.slug">
                                        <el-input
                                            v-model="orderForm.slug"
                                            placeholder="9 Stellige Order ID" />
                                    </el-form-item>

                                    <el-form-item>
                                        <el-button
                                            type="primary"
                                            @click="findOrderById"
                                            >Finden</el-button
                                        >
                                    </el-form-item>
                                </el-form>
                            </el-tab-pane>
                            <el-tab-pane label="Ohne" class="pt-4">
                                <h2
                                    class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                                    Ohne Order ID
                                </h2>

                                <p class="mt-3 text-lg leading-6 text-gray-500">
                                    Bitte geben Sie Ihre Email Adresse und die
                                    Postleitzahl des Gebäudes an.
                                </p>
                                <p
                                    class="mt-3 text-lg leading-6 text-gray-500 mb-6">
                                    Beachten Sie, die Email Adresse anzugeben,
                                    mit der Sie den Ausweis beantragt haben.
                                </p>

                                <el-form size="large" label-position="top">
                                    <el-form-item label="Email">
                                        <el-input
                                            v-model="emailForm.email"
                                            placeholder="Email Adresse" />
                                    </el-form-item>

                                    <el-form-item label="Postleitzahl">
                                        <el-input
                                            v-model="emailForm.zip"
                                            placeholder="PLZ" />
                                    </el-form-item>

                                    <el-form-item>
                                        <el-button
                                            type="primary"
                                            @click="findOrderByEmail"
                                            >Finden</el-button
                                        >
                                    </el-form-item>
                                </el-form>
                            </el-tab-pane>
                        </el-tabs>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import { EnvelopeIcon, ChevronLeftIcon } from '@heroicons/vue/24/outline';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { onMounted, ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { InertiaLink } from '@inertiajs/inertia-vue3';

const orderForm = useForm({
    slug: '',
});

const emailForm = useForm({
    email: '',
    zip: '',
});

const findOrderById = async () => {
    orderForm.get(route('find.slug'));
};

const findOrderByEmail = () => {
    emailForm.get(route('find.show'));
};

const animated = ref('');
const blinking = ref(true);
const waiting = ref(true);

setInterval(() => {
    if (animated.value === 'Energieausweis' && waiting.value) {
        blinking.value = !blinking.value;
    }
}, 500);

onMounted(() => {
    'Energieausweis'.split('').forEach((letter, index) => {
        setTimeout(() => {
            animated.value += letter;
        }, 150 * index);
    });

    setTimeout(() => {
        waiting.value = false;
    }, 150 * 'Energieausweis'.length + 3000);
});
</script>
