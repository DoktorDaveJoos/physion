<script setup>
import SidebarLayout from '../../../Layouts/SidebarLayout.vue';

import BzButton from '../../../Components/BzButton.vue';
import {
    ArrowDownTrayIcon,
    PaperAirplaneIcon,
    PencilSquareIcon,
    PlusIcon,
    TrashIcon,
} from '@heroicons/vue/24/outline';
import Badge from '../../../Components/Badge.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import Pagination from '../../../Components/Pagination.vue';
import { ElMessageBox, ElNotification } from 'element-plus';
import DialogModal from '../../../Components/DialogModal.vue';
import { ref } from 'vue';

defineProps({
    orders: Array,
});

const sendForm = useForm({
    order: null,
    email: null,
});

const showSendForm = ref(false);

const closeSendForm = () => {
    sendForm.reset();
    showSendForm.value = false;
};

const openSendFormFor = (slug) => {
    sendForm.order = slug;
    showSendForm.value = true;
};

const sendCertificate = () => {
    sendForm.post(
        route('hub.certificates.send', {
            order: sendForm.order,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                ElNotification({
                    title: 'Erfolgreich',
                    message: 'Zertifikat wurde versendet',
                    type: 'success',
                });
                closeSendForm();
            },
            onError: () => {
                ElNotification({
                    title: 'Fehler',
                    message: 'Zertifikat konnte nicht versendet werden',
                    type: 'error',
                });
            },
        }
    );
};

const tabs = [
    { name: 'Alle', filter: null },
    { name: 'Offen', filter: 'open' },
    { name: 'Abgeschlossen', filter: 'shipped' },
];

const handleFilter = (filter) => {
    if (filter) {
        router.get(route('hub.certificates'), { filter: filter });
    } else {
        router.get(route('hub.certificates'));
    }
};

const deleteOrder = (orderSlug) => {
    ElMessageBox.confirm(
        'Wollen Sie diesen Auftrag wirklich löschen?',
        'Warnung',
        {
            confirmButtonText: 'Ja',
            cancelButtonText: 'Nein',
            type: 'warning',
        }
    )
        .then(() => {
            router.delete(route('hub.orders.destroy', { order: orderSlug }), {
                preserveScroll: true,
                onSuccess: () => {
                    ElNotification({
                        title: 'Erfolgreich',
                        message: 'Auftrag wurde gelöscht',
                        type: 'success',
                    });
                },
                onError: () => {
                    ElNotification({
                        title: 'Fehler',
                        message: 'Auftrag konnte nicht gelöscht werden',
                        type: 'error',
                    });
                },
            });
        })
        .catch((err) => {
            console.log(err);
            // catch error
        });
};

const mapper = {
    'App\\Models\\Bdrf': 'Bedarfsausweis',
    'App\\Models\\Vrbr': 'Verbrauchsausweis',
};
</script>

<template>
    <Head title="Bestellungen" />
    <sidebar-layout>
        <template v-if="!$page.props.user?.current_team_id">
            <el-empty
                description="Sie müssen zuerst einem Team beitreten!"></el-empty>

            <div class="flex justify-center">
                <div class="max-w-lg text-sm text-gray-500">
                    Schau in der Navigation links unter
                    <span class="font-bold">"Deine Teams"</span> ob du dort ein
                    Team findest. Wende Dich sonst gerne an das Bauzertifikate
                    Team. Danke! Und schön, dass Du bei Uns bist!
                </div>
            </div>
        </template>
        <template v-else>
            <div
                class="rounded-lg shadow bg-white px-6 py-4 flex items-center justify-between">
                <div>
                    <div class="sm:hidden">
                        <label class="sr-only" for="tabs">Select a tab</label>
                        <!-- Use an "onChange" listener to redirect the user to the selected tab URL. -->
                        <select
                            id="tabs"
                            class="block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                            name="tabs">
                            <option
                                v-for="tab in tabs"
                                :key="tab.name"
                                :selected="tab.current">
                                {{ tab.name }}
                            </option>
                        </select>
                    </div>
                    <div class="hidden sm:block">
                        <nav aria-label="Tabs" class="flex space-x-4">
                            <button
                                v-for="tab in tabs"
                                :key="tab.name"
                                :aria-current="tab.current ? 'page' : undefined"
                                :class="[
                                    (route().params?.filter ?? null) ===
                                    tab.filter
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'text-gray-500 hover:text-gray-700',
                                    'rounded-md px-3 py-2 text-xs font-bold tracking-wider uppercase',
                                ]"
                                type="button"
                                @click="handleFilter(tab.filter)">
                                {{ tab.name }}
                            </button>
                        </nav>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <bz-button
                        :href="
                            route('hub.orders.create', {
                                category: 'vrbr_partner',
                            })
                        "
                        as="link"
                        type="secondary">
                        <plus-icon class="w-4 h-4 mr-1 -ml-1" />
                        Verbrauchsausweis
                    </bz-button>
                    <bz-button
                        :href="
                            route('hub.orders.create', {
                                category: 'bdrf_partner',
                            })
                        "
                        as="link"
                        type="secondary">
                        <plus-icon class="w-4 h-4 mr-1 -ml-1" />
                        Bedarfsausweis
                    </bz-button>
                </div>
            </div>

            <div class="mt-8 flow-root">
                <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div
                        class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                        <div class="overflow-hidden shadow rounded-t-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-white">
                                    <tr>
                                        <th
                                            class="py-3.5 pl-4 pr-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wide text-gray-900 sm:pl-6"
                                            scope="col">
                                            Objekt
                                        </th>
                                        <th
                                            class="px-3 py-3.5 text-left text-xs font-bold text-gray-800 font-bold uppercase tracking-wide text-gray-900"
                                            scope="col">
                                            Typ
                                        </th>
                                        <th
                                            class="px-3 py-3.5 text-left text-xs font-bold text-gray-800 font-bold uppercase tracking-wide text-gray-900"
                                            scope="col">
                                            Erstellt von
                                        </th>
                                        <th
                                            class="px-3 py-3.5 text-left text-xs font-bold text-gray-800 font-bold uppercase tracking-wide text-gray-900"
                                            scope="col">
                                            Status
                                        </th>
                                        <th
                                            class="px-3 py-3.5 text-left text-xs font-bold text-gray-800 font-bold uppercase tracking-wide text-gray-900"
                                            scope="col">
                                            Aktion
                                        </th>
                                    </tr>
                                </thead>
                                <tbody
                                    class="divide-y divide-gray-200 bg-white">
                                    <tr
                                        v-for="order in orders.data"
                                        :key="order.id">
                                        <td
                                            class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            <p class="font-bold text-gray-900">
                                                {{
                                                    order.certificate
                                                        .street_address
                                                }}
                                            </p>
                                            <p class="font-bold text-gray-900">
                                                {{ order.certificate.zip }}
                                                {{ order.certificate.city }}
                                            </p>
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ mapper[order.certificate_type] }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            {{ order.owner.first_name }}
                                            {{ order.owner.last_name }}
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <Badge
                                                :label="order.status"
                                                :type="
                                                    order.status === 'created'
                                                        ? 'warning'
                                                        : order.status ===
                                                          'shipped'
                                                        ? 'success'
                                                        : 'default'
                                                "
                                                size="sm" />
                                        </td>
                                        <td
                                            class="whitespace-nowrap px-3 py-4 text-sm">
                                            <div
                                                class="flex items-center space-x-1.5">
                                                <template
                                                    v-if="
                                                        order.status !==
                                                            'shipped' &&
                                                        order.status !== 'open'
                                                    ">
                                                    <Link
                                                        :href="
                                                            route(
                                                                'hub.certificates.show',
                                                                {
                                                                    order: order.slug,
                                                                }
                                                            )
                                                        "
                                                        class="flex items-center">
                                                        <pencil-square-icon
                                                            class="w-5 h-5 text-gray-500 hover:text-blue-600" />
                                                    </Link>
                                                    <button
                                                        class="flex items-center"
                                                        type="button"
                                                        @click="
                                                            deleteOrder(
                                                                order.slug
                                                            )
                                                        ">
                                                        <trash-icon
                                                            class="w-5 h-5 text-gray-500 hover:text-blue-600" />
                                                    </button>
                                                </template>
                                                <template
                                                    v-if="
                                                        order.status ===
                                                        'shipped'
                                                    ">
                                                    <a
                                                        v-for="attachment in order.attachments"
                                                        :href="
                                                            attachment.links
                                                                .self
                                                        "
                                                        target="_blank">
                                                        <ArrowDownTrayIcon
                                                            class="w-5 h-5 text-gray-500 hover:text-blue-600" />
                                                    </a>
                                                    <button
                                                        type="button"
                                                        @click="
                                                            openSendFormFor(
                                                                order.slug
                                                            )
                                                        ">
                                                        <paper-airplane-icon
                                                            class="w-5 h-5 text-gray-500 hover:text-blue-600" />
                                                    </button>
                                                </template>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div
                            class="w-full bg-white rounded-b-lg border-t border-gray-300 py-1 shadow">
                            <Pagination
                                :meta="orders.meta"
                                :links="orders.links" />
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </sidebar-layout>

    <dialog-modal :show="showSendForm">
        <template #title>
            <span class="font-bold font-display"
                >Zertifikat senden</span
            ></template
        >
        <template #content>
            <div class="p-4">
                <p class="text-gray-800 text-sm mb-4">
                    Senden Sie das Zertifikat bequem an den Empfänger. Einfach
                    E-Mail Adresse eingeben und absenden.
                </p>
                <el-form label-position="top" size="large">
                    <el-form-item label="E-Mail Empfänger">
                        <el-input v-model="sendForm.email" />
                    </el-form-item>
                </el-form>
            </div>
        </template>
        <template #footer>
            <bz-button type="secondary" @click="closeSendForm">
                Abbrechen</bz-button
            >
            <bz-button type="primary" @click="sendCertificate">
                Senden</bz-button
            >
        </template>
    </dialog-modal>
</template>

<style scoped></style>
