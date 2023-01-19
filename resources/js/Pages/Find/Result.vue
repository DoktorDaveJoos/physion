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

                        <div>
                            <div class="mt-6 flow-root">
                                <ul role="list" class="divide-y divide-gray-200">
<!--                                    <li v-for="result in results" :key="result.id" class="py-4">-->
<!--                                        <div class="flex items-center space-x-4">-->
<!--                                            <div class="min-w-0 flex-1">-->
<!--                                                <p class="truncate text-sm font-medium text-gray-900">{{ result.type }}</p>-->
<!--                                                <p class="truncate text-sm text-gray-500">{{ result.id }}</p>-->
<!--                                            </div>-->
<!--                                            <div>-->
<!--                                                <a href="#" class="inline-flex items-center rounded-full border border-gray-300 bg-white px-2.5 py-0.5 text-sm font-medium leading-5 text-gray-700 shadow-sm hover:bg-gray-50">View</a>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </li>-->
                                </ul>
                            </div>
                            <div class="mt-6">
                                <a href="#" class="flex w-full items-center justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50">View all</a>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import {EnvelopeIcon} from '@heroicons/vue/24/outline';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import {onMounted, ref} from 'vue';
import {useForm} from '@inertiajs/inertia-vue3';

defineProps(['results']);

const orderForm = useForm({
    order_id: '',
});

const emailForm = useForm({
    email: '',
    plz: '',
});

const findOrderById = () => {
    orderForm.post(route('find.order'), {
        preserveScroll: true,
        onSuccess: () => {
            orderForm.reset();
        },
    });
};

const findOrderByEmail = () => {
    emailForm.post(route('find.email'), {
        preserveScroll: true,
        onSuccess: () => {
            emailForm.reset();
        },
    });
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
