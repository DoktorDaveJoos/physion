<script setup>
import axios from 'axios';
import { computed, ref, watch } from 'vue';
import { UsersIcon, ClipboardIcon } from '@heroicons/vue/24/outline';
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
import { router } from '@inertiajs/vue3';

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
            console.log(response.data);
            results.value = response.data;
        })
        .catch((error) => {
            console.log(error);
        });
});

const select = (value) => {
    router.get(
        route('hub.certificates', {
            query: value.data.id,
            type: value.type,
        })
    );
};
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
                                v-if="results.length > 0"
                                static
                                class="-mb-2 max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800">
                                <template v-for="result in results">
                                    <ComboboxOption
                                        v-if="result.type === 'bdrfs'"
                                        :key="result.data.id"
                                        :value="result"
                                        as="template"
                                        v-slot="{ active }">
                                        <li
                                            :class="[
                                                'cursor-default select-none rounded-md px-4 py-2',
                                                active &&
                                                    'bg-blue-600 text-white',
                                            ]">
                                            <div class="flex justify-between">
                                                <div>
                                                    <p>
                                                        {{
                                                            result.data
                                                                .street_address
                                                        }}
                                                    </p>
                                                    <p>
                                                        {{ result.data.zip }},
                                                        {{ result.data.city }}
                                                    </p>
                                                </div>
                                                <div class="flex items-center">
                                                    <Badge
                                                        label="Bedarfsausweis" />
                                                </div>
                                            </div>
                                        </li>
                                    </ComboboxOption>
                                    <ComboboxOption
                                        v-if="result.type === 'vrbrs'"
                                        :key="result.data.id"
                                        :value="result"
                                        as="template"
                                        v-slot="{ active }">
                                        <li
                                            :class="[
                                                'cursor-default select-none rounded-md px-4 py-2',
                                                active &&
                                                    'bg-blue-600 text-white',
                                            ]">
                                            <div class="flex justify-between">
                                                <div>
                                                    <p>
                                                        {{
                                                            result.data
                                                                .street_address
                                                        }}
                                                    </p>
                                                    <p>
                                                        {{ result.data.zip }},
                                                        {{ result.data.city }}
                                                    </p>
                                                </div>
                                                <div class="flex items-center">
                                                    <Badge
                                                        label="Verbrauchsausweis" />
                                                </div>
                                            </div>
                                        </li>
                                    </ComboboxOption>
                                </template>
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
