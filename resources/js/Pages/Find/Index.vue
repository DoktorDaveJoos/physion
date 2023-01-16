<template>

    <GuestLayout>

        <div class="relative bg-white">
            <div class="absolute inset-0">
                <div class="absolute inset-y-0 left-0 w-1/2 bg-slate-50" />
            </div>
            <div class="relative mx-auto max-w-7xl lg:grid lg:grid-cols-5">
                <div class="bg-slate-50 py-16 px-6 lg:col-span-2 lg:px-8 lg:py-24 xl:pr-12">
                    <div class="mx-auto max-w-lg">
                        <h2 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">Find my {{ animated }}{{ blinking ? '|' : '' }}</h2>
                        <p class="mt-3 text-lg leading-6 text-gray-500">Unser einzigartiger "Find My Energieausweis" Service garantiert, dass Sie Ihren Energieausweis niemals wieder verlieren oder verlegen können.</p>
                        <p class="mt-3 text-lg leading-6 text-gray-500">Selbst wenn Sie die Bestellnummer nicht mehr kennen, können Sie Ihren Ausweis einfach durch die Angabe Ihrer E-Mail-Adresse in Verbindung mit der Postleitzahl des Gebäudes auffinden. Mit dieser innovativen Lösung haben Sie jederzeit und von überall Zugriff auf Ihren wichtigen Energieausweis.</p>
                        <dl class="mt-8 text-base text-gray-500">
                            <div class="mt-3">
                                <dt class="">Trotzdem nicht gefunden?</dt>
                                <dd class="flex items-center">
                                    <EnvelopeIcon class="h-6 w-6 flex-shrink-0 text-gray-400" aria-hidden="true" />
                                    <span class="ml-3">support@bauzertifikate.de</span>
                                </dd>
                            </div>
                        </dl>
                    </div>
                </div>
                <div class="bg-white py-16 px-6 lg:col-span-3 lg:py-24 lg:px-8 xl:pl-12">
                    <div class="mx-auto max-w-lg lg:max-w-none">

                        <el-tabs v-if="doSearch" tab-position="top">
                            <el-tab-pane label="Order ID" class="pt-4">

                                <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">Via Order ID</h2>

                                <p class="mt-3 text-lg leading-6 text-gray-500">Bitte geben Sie Ihre Bestellnummer ein, die Sie bei der Bestellung erhalten haben.</p>
                                <p class="mt-3 text-lg leading-6 text-gray-500 mb-6">Keine Email erhalten? Schauen Sie auch im Spam Ordner.</p>
                                <el-form size="large" label-position="top">
                                    <el-form-item label="Order ID" :error="orderForm.errors.order_id">
                                        <el-input v-model="orderForm.order_id" placeholder="9 Stellige Order ID" />
                                    </el-form-item>

                                    <el-form-item>
                                        <el-button type="primary" @click="findOrderById">Finden</el-button>
                                    </el-form-item>
                                </el-form>

                            </el-tab-pane>
                            <el-tab-pane label="Ohne" class="pt-4">

                                <h2 class="text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">Ohne Order ID</h2>

                                <p class="mt-3 text-lg leading-6 text-gray-500">Bitte geben Sie Ihre Email Adresse und die Postleitzahl des Gebäudes an.</p>
                                <p class="mt-3 text-lg leading-6 text-gray-500 mb-6">Beachten Sie, die Email Adresse anzugeben, mit der Sie den Ausweis beantragt haben.</p>

                                <el-form size="large" label-position="top">
                                    <el-form-item label="Email">
                                        <el-input v-model="emailForm.email" placeholder="Email Adresse" />
                                    </el-form-item>

                                    <el-form-item label="Postleitzahl">
                                        <el-input v-model="emailForm.plz" placeholder="PLZ" />
                                    </el-form-item>

                                    <el-form-item>
                                        <el-button type="primary" @click="findOrderByEmail">Finden</el-button>
                                    </el-form-item>
                                </el-form>

                            </el-tab-pane>
                        </el-tabs>

                        <div v-else>
                            <div class="mt-6 flow-root">
                                <InertiaLink :href="route('find.show')" class="text-blue-600 hover:text-blue-500 flex items-center mb-4">
                                    <ChevronLeftIcon class="h-4 w-4 mr-1" aria-hidden="true" />
                                    Zurück
                                </InertiaLink>
                                <h2 class="text-xl font-bold tracking-tight mb-10 text-gray-900 sm:text-2xl">Ergebnis der Suche</h2>
                                <ul role="list" class="-my-5 divide-y divide-gray-200">
                                    <li v-for="result in orders" :key="result.id" class="py-4 border border-gray-300 rounded shadow px-6">
                                        <div class="flex items-center space-x-4">

                                            <div class="min-w-0 flex-1">
                                                <p class="truncate text-sm font-medium text-gray-900">{{ result.type[0].toUpperCase() + result.type.slice(1) }}</p>
                                                <span class="inline-flex items-center rounded bg-blue-100 px-3 py-0.5 text-sm font-medium text-blue-800">
                                                    <svg class="-ml-1 mr-1.5 h-2 w-2 text-blue-400" fill="currentColor" viewBox="0 0 8 8">
                                                        <circle cx="4" cy="4" r="3" />
                                                    </svg>
                                                    {{ result.id }}
                                                </span>
                                            </div>
                                            <div>
                                                <InertiaLink :href="route('order.show', result.id)" class="inline-flex items-center rounded border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">Anzeigen</InertiaLink>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import {EnvelopeIcon, ChevronLeftIcon} from '@heroicons/vue/24/outline';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import {onMounted, ref} from 'vue';
import {useForm} from '@inertiajs/inertia-vue3';
import {InertiaLink} from '@inertiajs/inertia-vue3';

const props = defineProps({
    orders: {
        type: Array,
        default: [],
    },
});

const doSearch = ref(props.orders.length === 0);

const orderForm = useForm({
    order_id: '',
});

const emailForm = useForm({
    email: '',
    plz: '',
});

const findOrderById = async () => {
    orderForm.get(route('find.show'));
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
})

</script>
