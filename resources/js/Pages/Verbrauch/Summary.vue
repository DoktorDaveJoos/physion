<script>
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
import GuestLayout from '../../Layouts/GuestLayout.vue';
import { PaperClipIcon } from '@heroicons/vue/24/outline';
import { Link, useForm } from '@inertiajs/inertia-vue3';
import dayjs from 'dayjs';
import PaypalButton from '../../Components/PaypalButton.vue';

export default {
    name: 'Summary',
    methods: { dayjs, route: window.route },
    components: { PaypalButton, StepperWrapper, PaperClipIcon, Link },
    layout: GuestLayout,
    props: {
        order: Object,
        customer: Object,
        product: Object,
    },
    setup() {
        const feedbackForm = useForm({
            feedback: null,
        });

        return {
            feedbackForm,
        };
    },
};
</script>

<template>
    <StepperWrapper>
        <div>
            <h3 class="text-lg font-medium leading-6 text-gray-900">
                Zusammenfassung
            </h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                Überprüfen Sie die Bestellung und nutzen Sie das Feedback-Feld
                für Informationen die Sie uns mitteilen möchten
            </p>
        </div>
        <div class="mt-5 border-t border-gray-200">
            <div class="divide-y divide-gray-200">
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Allgemein</dt>
                    <dd
                        class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div class="flex-grow">
                            <div class="flex flex-col">
                                <span class="font-medium text-xs text-gray-400"
                                    >Auftraggeber</span
                                >
                                <span>{{ customer.name }}</span>
                                <span>{{ customer.email }}</span>
                                <span v-if="customer.phone">{{
                                    customer.phone
                                }}</span>

                                <span
                                    class="font-medium text-xs text-gray-400 mt-4"
                                    >Gebäude</span
                                >
                                <span>{{ product.street_address }}</span>
                                <span
                                    >{{ product.zip }}, {{ product.city }}</span
                                >
                                <span
                                    >{{ product.type }},
                                    {{ product.additional_type }}</span
                                >
                            </div>
                        </div>
                        <Link
                            :href="route('verbrauch.general', order.id)"
                            class="ml-4 flex-shrink-0">
                            <button
                                type="button"
                                class="rounded-md bg-white font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Bearbeiten
                            </button>
                        </Link>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Gebäudedetails
                    </dt>
                    <dd
                        class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div class="flex-grow">
                            <div class="flex flex-col">
                                <span class="font-medium text-xs text-gray-400"
                                    >Gebäude</span
                                >
                                <span
                                    >Baujahr (Heizung):
                                    {{ product.construction_year }} ({{
                                        product.construction_year_heating
                                    }})</span
                                >
                                <span
                                    >{{
                                        product.housing_units
                                    }}
                                    Wohneinheit/en</span
                                >
                                <span>{{ product.floor_area }} m²</span>
                                <span
                                    >{{ product.ventilation }},
                                    {{ product.cellar }}</span
                                >

                                <span
                                    v-if="product.renewables"
                                    class="font-medium text-xs text-gray-400 mt-4"
                                    >Erneuerbare Energien</span
                                >
                                <span
                                    >{{ product.renewables }},
                                    {{ product.renewables_reason }}</span
                                >

                                <span
                                    v-if="product.cooling"
                                    class="font-medium text-xs text-gray-400 mt-4"
                                    >Kühlung</span
                                >
                                <span>{{ product.cooling }}</span>
                                <span v-if="product.cooling_count"
                                    >Servicepflichte Klima:
                                    {{ product.cooling_count }}, Nächster
                                    Service:
                                    {{
                                        dayjs(product.cooling_service).format(
                                            'DD.MM.YYYY'
                                        )
                                    }}</span
                                >
                            </div>
                        </div>
                        <Link
                            :href="route('verbrauch.details', order.id)"
                            class="ml-4 flex-shrink-0">
                            <button
                                type="button"
                                class="rounded-md bg-white font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Bearbeiten
                            </button>
                        </Link>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">
                        Verbrauchsdaten
                    </dt>
                    <dd
                        class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <div class="flex-grow">
                            <div class="flex flex-col space-y-4">
                                <template
                                    v-for="source in product.sources"
                                    :key="source.id">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-medium text-xs text-gray-400"
                                            >{{
                                                source.source.replace(
                                                    /\[(.*?)\]/gm.exec(
                                                        source.source
                                                    )[0],
                                                    ''
                                                )
                                            }}</span
                                        >
                                        <span v-for="period in source.periods"
                                            >{{
                                                dayjs(period.start)
                                                    .locale('de')
                                                    .format('MMM YYYY')
                                            }}
                                            -
                                            {{
                                                dayjs(period.end)
                                                    .locale('de')
                                                    .format('MMM YYYY')
                                            }}: {{ period.consumption }}
                                            {{
                                                /\[(.*?)\]/gm.exec(
                                                    source.source
                                                )[1]
                                            }}
                                            {{
                                                source.water_enabled
                                                    ? ', (Wasser) ' +
                                                      period.water +
                                                      /\[(.*?)\]/gm.exec(
                                                          source.source
                                                      )[1]
                                                    : null
                                            }}</span
                                        >
                                    </div>
                                </template>

                                <template v-if="product.vacancy_percentage">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-medium text-xs text-gray-400"
                                            >Leerstand</span
                                        >
                                        <span
                                            >{{
                                                product.vacancy_percentage
                                            }}%</span
                                        >
                                    </div>
                                </template>
                                <template
                                    v-else-if="product.vacancies.length > 0">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-medium text-xs text-gray-400"
                                            >Leerstand</span
                                        >
                                        <span
                                            v-for="vacancy in product.vacancies">
                                            {{
                                                dayjs(vacancy.start)
                                                    .locale('de')
                                                    .format('MMM YYYY')
                                            }}
                                            -
                                            {{
                                                dayjs(vacancy.end)
                                                    .locale('de')
                                                    .format('MMM YYYY')
                                            }}
                                        </span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        <Link
                            :href="route('verbrauch.consumption', order.id)"
                            class="ml-4 flex-shrink-0">
                            <button
                                type="button"
                                class="rounded-md bg-white font-medium text-blue-600 hover:text-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Bearbeiten
                            </button>
                        </Link>
                    </dd>
                </div>
                <div class="py-4 sm:grid sm:grid-cols-3 sm:gap-4 sm:py-5">
                    <dt class="text-sm font-medium text-gray-500">Feedback</dt>
                    <dd
                        class="mt-1 flex text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                        <el-input
                            v-model="feedbackForm.feedback"
                            :rows="4"
                            type="textarea"
                            placeholder="Möchten Sie uns noch etwas mitteilen?" />
                    </dd>
                </div>
            </div>
        </div>

        <el-divider />

        <div class="flex flex-col">
            <span class="text-sm text-gray-500">
                Zahlung per
                <strong> Kreditkarte,</strong>
                <strong> Rechnung (Klarna),</strong>
                <strong> Giropay,</strong>
                <strong> ApplePay,</strong>
                <strong> GooglePay</strong> wählen Sie
                <strong> Zur Kasse</strong>
            </span>
            <span class="mt-4 text-sm text-gray-500 sm:mt-0">
                Zahlung per
                <strong> PayPal</strong> wählen Sie
                <strong> Mit PayPal</strong>
            </span>
        </div>

        <el-divider />

        <Link :href="route('checkout.show', order.id)">
            <el-button
                type="primary"
                size="large"
                class="rounded-md bg-blue-600 font-medium text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Zur Kasse
            </el-button>
        </Link>
    </StepperWrapper>
</template>
