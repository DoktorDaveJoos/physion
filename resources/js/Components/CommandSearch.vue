<script setup>
import axios from 'axios';
import { computed, ref, watch } from 'vue';
import {
    ClipboardIcon,
    DocumentPlusIcon,
    ArrowRightOnRectangleIcon,
} from '@heroicons/vue/24/outline';
import {
    Combobox,
    ComboboxInput,
    ComboboxOptions,
    ComboboxOption,
    Dialog,
    DialogPanel,
    TransitionChild,
    TransitionRoot,
} from '@headlessui/vue';
import Badge from './Badge.vue';
import { router, Link } from '@inertiajs/vue3';

const emits = defineEmits(['close']);

const props = defineProps({
    open: Boolean,
});

const open = computed({
    get: () => {
        return props.open;
    },
    set: () => {
        emits('close');
    },
});
const query = ref('');

const results = ref([]);

watch(query, (value) => {
    if (value.length < 3) {
        return;
    }

    axios
        .get(route('hub.search', { query: value }))
        .then((response) => {
            results.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
});

const select = (value) => {
    if (value.shortcut) {
        router.get(value.url);
    } else {
        router.get(
            route('hub.certificates', {
                query: value.id,
                type: value.type,
            })
        );
    }
};

const quickActions = [
    {
        name: 'Neuer Bedarfsausweis...',
        icon: DocumentPlusIcon,
        shortcut: 'N',
        url: route('hub.orders.create', { category: 'bdrf_partner' }),
    },
    {
        name: 'Neuer Verbrauchsausweis...',
        icon: DocumentPlusIcon,
        shortcut: 'F',
        url: route('hub.orders.create', { category: 'vrbr_partner' }),
    },
    {
        name: 'Gehe zu Bestellungen...',
        icon: ArrowRightOnRectangleIcon,
        shortcut: 'H',
        url: route('hub.certificates'),
    },
];
</script>

<template>
    <TransitionRoot :show="open" as="template" @after-leave="query = ''" appear>
        <Dialog as="div" class="relative z-50" @close="open = false">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0">
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-25 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 overflow-y-auto p-4 sm:p-6 md:p-20">
                <TransitionChild
                    as="template"
                    enter="ease-out duration-300"
                    enter-from="opacity-0 scale-95"
                    enter-to="opacity-100 scale-100"
                    leave="ease-in duration-200"
                    leave-from="opacity-100 scale-100"
                    leave-to="opacity-0 scale-95">
                    <DialogPanel
                        class="mx-auto max-w-xl transform rounded-xl bg-white p-2 shadow-2xl ring-1 ring-black ring-opacity-5 transition-all">
                        <Combobox @update:modelValue="select">
                            <ComboboxInput
                                class="w-full rounded-md border-0 bg-gray-100 px-4 py-2.5 text-gray-900 focus:ring-0 sm:text-sm"
                                placeholder="Search..."
                                @change="query = $event.target.value" />

                            <ComboboxOptions
                                v-if="Object.keys(results).length > 0"
                                static
                                class="-mb-2 max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800">
                                <h2
                                    v-if="query === ''"
                                    class="mb-2 mt-4 px-3 text-xs font-semibold text-gray-500">
                                    Zuletzt gesucht
                                </h2>
                                <template
                                    v-for="(category, key) in results"
                                    :key="key">
                                    <ComboboxOption
                                        v-for="result in category"
                                        :value="result"
                                        as="template"
                                        v-slot="{ active }">
                                        <li
                                            :class="[
                                                'cursor-pointer select-none rounded-md px-4 py-2 group',
                                                active &&
                                                    'bg-primary text-white',
                                            ]">
                                            <div class="flex justify-between">
                                                <div>
                                                    <p
                                                        class="font-bold tracking-tight group-hover:text-white">
                                                        {{
                                                            result.street_address
                                                        }}
                                                    </p>
                                                    <p class="-mt-1">
                                                        {{ result.zip }},
                                                        {{ result.city }}
                                                    </p>
                                                </div>
                                                <div
                                                    class="flex items-center space-x-1">
                                                    <Badge
                                                        :type="
                                                            result.order_status ===
                                                            'created'
                                                                ? 'warning'
                                                                : result.order_status ===
                                                                  'shipped'
                                                                ? 'success'
                                                                : 'default'
                                                        "
                                                        :label="
                                                            result.order_status
                                                        " />
                                                    <Badge
                                                        :label="
                                                            result.certificate_type
                                                        " />
                                                </div>
                                            </div>
                                        </li>
                                    </ComboboxOption>
                                </template>
                            </ComboboxOptions>
                            <ComboboxOptions
                                static
                                class="max-h-80 scroll-py-2 divide-y divide-gray-500 divide-opacity-10 overflow-y-auto">
                                <li class="p-2"></li>
                                <li v-if="query === ''" class="p-2">
                                    <h2 class="sr-only">Quick actions</h2>
                                    <ul class="text-sm text-gray-700">
                                        <ComboboxOption
                                            v-for="action in quickActions"
                                            :key="action.shortcut"
                                            :value="action"
                                            as="template"
                                            v-slot="{ active }">
                                            <li
                                                :class="[
                                                    'flex cursor-default select-none items-center rounded-md px-3 py-2',
                                                    active &&
                                                        'bg-gray-900 bg-opacity-5 text-gray-900',
                                                ]">
                                                <component
                                                    :is="action.icon"
                                                    :class="[
                                                        'h-6 w-6 flex-none text-gray-900 text-opacity-40',
                                                        active &&
                                                            'text-opacity-100',
                                                    ]"
                                                    aria-hidden="true" />
                                                <Link
                                                    :href="action.url"
                                                    class="ml-3 flex-auto truncate"
                                                    >{{ action.name }}</Link
                                                >
                                                <!--                                                <span-->
                                                <!--                                                    class="ml-3 flex-none text-xs font-semibold text-gray-500">-->
                                                <!--                                                    <kbd class="font-sans"-->
                                                <!--                                                        >⌘</kbd-->
                                                <!--                                                    >-->
                                                <!--                                                    <kbd class="font-sans">{{-->
                                                <!--                                                        action.shortcut-->
                                                <!--                                                    }}</kbd>-->
                                                <!--                                                </span>-->
                                            </li>
                                        </ComboboxOption>
                                    </ul>
                                </li>
                            </ComboboxOptions>

                            <div
                                v-if="query !== '' && results.length === 0"
                                class="px-4 py-14 text-center sm:px-14">
                                <ClipboardIcon
                                    class="mx-auto h-6 w-6 text-gray-400"
                                    aria-hidden="true" />
                                <p class="mt-4 text-sm text-gray-900">
                                    Keine Ausweise für diese Suche gefunden.
                                </p>
                            </div>
                        </Combobox>
                    </DialogPanel>
                </TransitionChild>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped></style>
