<template>
    <blinking-wrapper>
        <div
            class="bg-white flex md:justify-start md:w-7/12 py-16 px-6 lg:py-24 lg:px-8 xl:pl-12">
            <div class="w-full max-w-2xl">
                <el-tabs tab-position="top">
                    <el-tab-pane class="pt-4" label="Order ID">
                        <h2
                            class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                            Via Order ID
                        </h2>

                        <p class="mt-3 text-lg leading-6 text-gray-500">
                            Bitte geben Sie Ihre Bestellnummer ein, die Sie bei
                            der Bestellung erhalten haben.
                        </p>
                        <p class="mt-3 text-lg leading-6 text-gray-500 mb-6">
                            Keine Email erhalten? Schauen Sie auch im Spam
                            Ordner.
                        </p>
                        <el-form label-position="top" size="large">
                            <el-form-item
                                :error="orderForm.errors.slug"
                                label="Order ID">
                                <el-input
                                    v-model="orderForm.slug"
                                    placeholder="6 Stellige Order ID" />
                            </el-form-item>

                            <el-form-item>
                                <el-button type="primary" @click="findOrderById"
                                    >Finden
                                </el-button>
                            </el-form-item>
                        </el-form>
                    </el-tab-pane>
                    <el-tab-pane class="pt-4" label="Email">
                        <h2
                            class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">
                            Via Email
                        </h2>

                        <p class="mt-3 text-lg leading-6 text-gray-500">
                            Bitte geben Sie Ihre Email Adresse an.
                        </p>
                        <p class="mt-3 text-lg leading-6 text-gray-500 mb-6">
                            Beachten Sie, die Email Adresse anzugeben, mit der
                            Sie den Ausweis beantragt haben.
                        </p>

                        <el-form label-position="top" size="large">
                            <el-form-item
                                :error="emailForm.errors.email"
                                label="Email">
                                <el-input
                                    v-model="emailForm.email"
                                    placeholder="Email Adresse" />
                            </el-form-item>

                            <el-button type="primary" @click="findOrderByEmail"
                                >Finden
                            </el-button>
                        </el-form>
                    </el-tab-pane>
                </el-tabs>
            </div>
        </div>
    </blinking-wrapper>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import BlinkingWrapper from './Components/BlinkingWrapper.vue';

const orderForm = useForm({
    slug: '',
});

const emailForm = useForm({
    email: '',
});

const findOrderById = async () => {
    orderForm.get(route('find.slug'), {
        preserveState: true,
    });
};

const findOrderByEmail = () => {
    emailForm.get(route('find.email'), {
        preserveState: true,
    });
};
</script>
