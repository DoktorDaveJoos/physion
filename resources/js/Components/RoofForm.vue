<script setup>
import {
    RadioGroup,
    RadioGroupDescription,
    RadioGroupLabel,
    RadioGroupOption,
} from '@headlessui/vue';
import {
    CheckCircleIcon,
    ExclamationTriangleIcon,
} from '@heroicons/vue/20/solid';
import SatteldachForm from './SatteldachForm.vue';
import { useForm, router } from '@inertiajs/vue3';
import { computed, reactive, watch } from 'vue';
import FlachdachForm from './FlachdachForm.vue';
import { ElMessage, ElMessageBox, ElNotification } from 'element-plus';
import PultdachForm from './PultdachForm.vue';
import {
    BuildingStorefrontIcon,
    PlusIcon,
    Square3Stack3DIcon,
    SunIcon,
    TrashIcon,
} from '@heroicons/vue/24/outline';
import BzButton from './BzButton.vue';

const props = defineProps({
    order: Object,
});

const options = {
    satteldach: [
        {
            value: 'kalt',
            label: 'Kalt',
            children: [
                {
                    value: 'massiv',
                    label: 'Zwischendecke Massiv',
                },
                {
                    value: 'holzbalken',
                    label: 'Zwischendecke Holzbalkendecke',
                },
                {
                    value: 'vollholz',
                    label: 'Zwischendecke Vollholz',
                },
            ],
        },
        {
            value: 'beheizt',
            label: 'Beheizt',
            children: [
                {
                    value: 'holz',
                    label: 'Holz Dachstuhl',
                },
            ],
        },
    ],
    flachdach: [
        {
            value: 'beheizt',
            label: 'Beheizt',
            children: [
                {
                    value: 'massiv',
                    label: 'Decke Massiv',
                },
                {
                    value: 'vollholz',
                    label: 'Decke Vollholz',
                },
            ],
        },
    ],
    pultdach: [
        {
            value: 'beheizt',
            label: 'Beheizt',
            children: [
                {
                    value: 'massiv',
                    label: 'Decke Massiv',
                },
                {
                    value: 'vollholz',
                    label: 'Decke Vollholz',
                },
                {
                    value: 'gefach',
                    label: 'Decke Gefach',
                },
            ],
        },
    ],
};

const cascaderProps = {
    expandTrigger: 'hover',
};

const roofForms = [
    {
        id: 1,
        title: 'Satteldach',
        description: 'Inklusive (Krüppel-)Walmdach, Mansardendach & Zeltdach',
        image: '/satteldach.svg',
    },
    {
        id: 2,
        title: 'Flachdach',
        description: 'Auch für andere Dachformen mit Kaltdach geeignet.',
        image: '/flachdach.svg',
    },
    {
        id: 3,
        title: 'Pultdach',
        description: 'Gängig bei Bürogebäuden, Industrie- und Gewerbebauten.',
        image: '/pultdach.svg',
    },
];

const getForTitle = (title) =>
    roofForms.find((roofForm) => roofForm.title === title);

const roof = computed(() => props.order.certificate?.roof);

const form = useForm({
    roof_shape: roof.value?.roof_shape
        ? getForTitle(roof.value?.roof_shape)
        : null,
    heated: roof.value?.heated ?? null,
    construction:
        roof.value?.heated !== null
            ? [
                  `${roof.value?.heated ? 'beheizt' : 'kalt'}`,
                  roof.value?.construction,
              ]
            : [],
    u_value: roof.value?.u_value ?? null,
    knee_wall: roof.value?.knee_wall ?? null,
    pitch: roof.value?.pitch ?? null,
    ceiling: roof.value?.ceiling ?? null,
});

watch(
    () => form.roof_shape,
    async (value, oldValue) => {
        // Changing to a roof type where dormers are not allowed
        if (
            (value.title === 'Flachdach' || value.title === 'Pultdach') &&
            props.order.certificate.roof?.dormers?.length > 0
        ) {
            ElMessageBox.confirm(
                `Für diese Dachform sind keine Gauben vorgesehen. Bestehende (${props.order.certificate.roof.dormers?.length}) Gauben werden gelöscht. Fortfahren?`,
                'Achtung',
                {
                    confirmButtonText: 'Weiter',
                    cancelButtonText: 'Abbrechen',
                    type: 'warning',
                }
            )
                .then(() => {
                    props.order.certificate.roof.dormers?.forEach((dormer) => {
                        router.delete(
                            route(
                                'bdrf.roof.dormer.delete',
                                {
                                    bdrf: props.order.certificate.id,
                                    dormer: dormer.id,
                                    signature: route().params?.signature,
                                },
                                {
                                    preserveScroll: true,
                                }
                            )
                        );
                    });
                })
                .catch(() => {
                    ElMessage({
                        type: 'info',
                        message: 'Abgebrochen',
                    });

                    form.roof_shape = oldValue;
                });
        }

        if (value.title === props.order.certificate.roof?.roof_shape) {
            form.reset(
                'heated',
                'construction',
                'u_value',
                'knee_wall',
                'pitch',
                'ceiling'
            );
            return;
        }

        form.construction = [];
        form.heating = null;
        form.u_value = null;
        form.knee_wall = null;
        form.pitch = null;
        form.ceiling = null;
    },
    { deep: true }
);

const resetChildren = (value) => {
    if (value.length > 0 && value[1] === roof.value?.construction) {
        form.reset('heated', 'u_value', 'knee_wall', 'pitch', 'ceiling');
        return;
    }

    form.heated = null;
    form.u_value = null;
    form.knee_wall = null;
    form.pitch = null;
    form.ceiling = null;
};

const skylightForm = useForm({
    count: null,
    height: null,
    width: null,
    glazing: null,
});

const insulationForm = useForm({
    type: null,
    thickness: null,
});

const dormerForm = useForm({
    count: null,
    form: null,
    height: null,
    width: null,
});

const state = reactive({
    insulation: false,
    skylight: false,
    dormer: false,
    isOpen: false,
});

const prepareForm = (form) =>
    form.transform((data) => ({
        ...data,
        roof_shape: data?.roof_shape?.title,
        heated: data.construction[0] === 'beheizt',
        construction: data.construction[1],
    }));

const safe = () => {
    prepareForm(form).put(
        route('bdrf.roof', {
            bdrf: props.order.certificate.id,
            signature: route().params?.signature,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                ElNotification({
                    title: 'Gespeichert',
                    message: 'Dach erfolgreich gespeichert',
                    type: 'success',
                });
            },
        }
    );
};

const addInsulation = () => {
    insulationForm.put(
        route('bdrf.roof.insulation', {
            bdrf: props.order.certificate.id,
            signature: route().params?.signature,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                insulationForm.reset();
                state.insulation = false;
            },
        }
    );
};

const addSkylight = () => {
    skylightForm.put(
        route('bdrf.roof.skylight', {
            bdrf: props.order.certificate.id,
            signature: route().params?.signature,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                skylightForm.reset();
                state.skylight = false;
            },
        }
    );
};

const addDormer = () => {
    dormerForm.put(
        route('bdrf.roof.dormer', {
            bdrf: props.order.certificate.id,
            signature: route().params?.signature,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                dormerForm.reset();
                state.dormer = false;
            },
        }
    );
};

const deleteInsulation = (id) => {
    router.delete(
        route('bdrf.roof.insulation.delete', {
            bdrf: props.order.certificate.id,
            insulation: id,
            signature: route().params?.signature,
        }),
        {
            preserveScroll: true,
        }
    );
};

const deleteSkylight = (id) => {
    router.delete(
        route('bdrf.roof.skylight.delete', {
            bdrf: props.order.certificate.id,
            window: id,
            signature: route().params?.signature,
        }),
        {
            preserveScroll: true,
        }
    );
};

const deleteDormer = (id) => {
    router.delete(
        route('bdrf.roof.dormer.delete', {
            bdrf: props.order.certificate.id,
            dormer: id,
            signature: route().params?.signature,
        }),
        {
            preserveScroll: true,
        }
    );
};

const openDrawer = async (drawer) => {
    if (!props.order.certificate.roof || form.isDirty) {
        prepareForm(form).put(route('bdrf.roof', props.order.id), {
            preserveScroll: true,
            onSuccess: () => {
                state[drawer] = true;
            },
            onError: () => {
                ElNotification({
                    title: 'Fehler',
                    message: 'Behebe bitte zuerst alle Fehler.',
                    type: 'error',
                });
            },
        });

        return;
    }

    state[drawer] = true;
};

const hasAdditional = computed(() => {
    return (
        props.order.certificate.roof?.insulations?.length > 0 ||
        props.order.certificate.roof?.windows?.length > 0 ||
        props.order.certificate.roof?.dormers?.length > 0
    );
});
</script>

<template>
    <el-card :body-style="{ padding: '0px' }" shadow="never">
        <template #header>
            <div class="flex justify-between items-center">
                <div class="text-gray-800">
                    {{
                        form.roof_shape?.title ? form.roof_shape.title : 'Dach'
                    }}
                </div>

                <div
                    v-if="form.isDirty"
                    class="text-xs text-gray-500 flex items-center">
                    <ExclamationTriangleIcon
                        class="h-4 w-4 mr-1 text-yellow-500" />
                    es gibt nicht gespeicherte Änderungen
                </div>
                <div v-else class="text-xs text-gray-500 flex items-center">
                    <CheckCircleIcon class="h-4 w-4 mr-1 text-emerald-500" />
                    alles gespeichert
                </div>
            </div>
        </template>

        <div class="flex p-4">
            <RadioGroup v-model="form.roof_shape" class="w-full">
                <div class="grid grid-cols-1 gap-y-6 sm:grid-cols-3 sm:gap-x-4">
                    <RadioGroupOption
                        v-for="roof in roofForms"
                        :key="roof.id"
                        v-slot="{ checked, active }"
                        :value="roof"
                        as="template">
                        <div
                            :class="[
                                checked
                                    ? 'border-transparent'
                                    : 'border-gray-300',
                                active
                                    ? 'border-blue-500 ring-2 ring-blue-500'
                                    : '',
                                'relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none',
                            ]">
                            <span class="flex flex-1">
                                <span class="flex flex-col">
                                    <RadioGroupLabel
                                        as="span"
                                        class="block text-sm font-medium text-gray-900">
                                        {{ roof.title }}
                                    </RadioGroupLabel>
                                    <RadioGroupDescription
                                        as="span"
                                        class="mt-1 flex items-center text-xs text-gray-500">
                                        {{ roof.description }}
                                    </RadioGroupDescription>
                                    <RadioGroupDescription
                                        as="div"
                                        class="mt-6 flex text-sm font-medium text-gray-900">
                                        <img
                                            :alt="roof.title"
                                            :src="roof.image"
                                            class="h-8 w-8" />
                                    </RadioGroupDescription>
                                </span>
                            </span>
                            <CheckCircleIcon
                                :class="[
                                    !checked ? 'invisible' : '',
                                    'h-5 w-5 text-blue-600',
                                ]"
                                aria-hidden="true" />
                            <span
                                :class="[
                                    active ? 'border' : 'border-2',
                                    checked
                                        ? 'border-blue-500'
                                        : 'border-transparent',
                                    'pointer-events-none absolute -inset-px rounded-lg',
                                ]"
                                aria-hidden="true" />
                        </div>
                    </RadioGroupOption>
                </div>
            </RadioGroup>
        </div>

        <template v-if="form.roof_shape">
            <!--   Homemade divider   -->
            <div class="border-t border-gray-300 flex mb-5"></div>

            <el-form
                class="grid sm:grid-cols-2 gap-4 px-4"
                label-position="top"
                size="large">
                <el-form-item
                    :error="form.errors.heated || form.errors.construction"
                    label="Dachstock"
                    required>
                    <el-cascader
                        v-model="form.construction"
                        :options="options[form.roof_shape.title.toLowerCase()]"
                        :props="cascaderProps"
                        class="w-full"
                        placeholder="Bitte wählen Sie eine Option aus"
                        @change="resetChildren" />
                </el-form-item>

                <el-form-item
                    :error="form.errors.u_value"
                    label="U-Wert (falls bekannt)">
                    <el-input-number
                        v-model="form.u_value"
                        :max="10"
                        :min="0.08"
                        :precision="2"
                        :step="0.01"
                        placeholder="0" />
                </el-form-item>
            </el-form>

            <satteldach-form
                v-if="
                    form.roof_shape.title === 'Satteldach' &&
                    form.construction[0] === 'beheizt'
                "
                :form="form"
                :order="order" />
            <flachdach-form
                v-else-if="
                    form.roof_shape.title === 'Satteldach' &&
                    form.construction[0] === 'kalt'
                "
                :form="form"
                :order="order" />
            <flachdach-form
                v-else-if="
                    form.roof_shape.title === 'Flachdach' &&
                    form.construction[0]
                "
                :form="form"
                :order="order" />
            <pultdach-form
                v-else-if="
                    form.roof_shape.title === 'Pultdach' && form.construction[0]
                "
                :form="form"
                :order="order" />

            <template v-if="hasAdditional">
                <div
                    class="border-t border-gray-200 px-6 pb-6 space-y-2 bg-gray-50">
                    <div v-if="roof?.insulations?.length > 0" class="pt-4">
                        <span class="text-xs text-gray-500"
                            >Dämmung und Isolierung</span
                        >
                    </div>

                    <div
                        v-for="insulation in order.certificate.roof
                            ?.insulations"
                        class="flex rounded-md bg-white border border-gray-200 p-2 items-center shadow-sm">
                        <div
                            class="h-12 w-12 mr-4 bg-gray-100 rounded flex justify-center items-center">
                            <Square3Stack3DIcon class="h-6 w-6 text-gray-300" />
                        </div>

                        <div class="flex-1">
                            <h3 class="text-gray-800 text-sm">
                                {{ insulation.type }}
                            </h3>
                            <p class="text-xs text-gray-500">
                                {{ insulation.thickness }} cm
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <el-button
                                size="small"
                                text
                                @click="deleteInsulation(insulation.id)">
                                <trash-icon class="h-4 w-4" />
                            </el-button>
                        </div>
                    </div>

                    <div v-if="roof?.windows?.length > 0" class="pt-4">
                        <span class="text-xs text-gray-500">Dachfenster</span>
                    </div>

                    <div
                        v-for="skylight in order.certificate.roof?.windows"
                        class="flex rounded-md bg-white border border-gray-200 p-2 items-center shadow-sm">
                        <div
                            class="h-12 w-12 mr-4 bg-gray-100 rounded flex justify-center items-center">
                            <SunIcon class="h-6 w-6 text-gray-300" />
                        </div>

                        <div class="flex-1">
                            <h3 class="text-gray-800 text-sm">
                                Dachfenster - Verglasung: {{ skylight.glazing }}
                            </h3>
                            <div class="flex">
                                <span class="text-xs text-gray-500 mr-2"
                                    >{{ skylight.count }} Stück</span
                                >
                                <span class="text-xs text-gray-500 mr-2"
                                    >{{ skylight.height }}cm x
                                    {{ skylight.width }}cm</span
                                >
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <el-button
                                size="small"
                                text
                                @click="deleteSkylight(skylight.id)">
                                <trash-icon class="h-4 w-4" />
                            </el-button>
                        </div>
                    </div>

                    <div v-if="roof?.dormers?.length > 0" class="pt-4">
                        <span class="text-xs text-gray-500">Gauben</span>
                    </div>

                    <div
                        v-for="dormer in order.certificate.roof?.dormers"
                        class="flex rounded-md bg-white border border-gray-200 p-2 items-center shadow-sm">
                        <div
                            class="h-12 w-12 mr-4 bg-gray-100 rounded flex justify-center items-center">
                            <BuildingStorefrontIcon
                                class="h-6 w-6 text-gray-300" />
                        </div>

                        <div class="flex-1">
                            <h3 class="text-gray-800 text-sm">
                                Gaube - {{ dormer.form }}
                            </h3>
                            <div class="flex">
                                <span class="text-xs text-gray-500 mr-2"
                                    >{{ dormer.count }} Stück</span
                                >
                                <span class="text-xs text-gray-500 mr-2"
                                    >{{ dormer.height }}cm x
                                    {{ dormer.width }}cm</span
                                >
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            <el-button
                                size="small"
                                text
                                @click="deleteDormer(dormer.id)">
                                <trash-icon class="h-4 w-4" />
                            </el-button>
                        </div>
                    </div>
                </div>
            </template>

            <div
                v-if="roof"
                class="p-4 flex space-x-2 justify-end border-t border-gray-200">
                <bz-button type="secondary" @click="openDrawer('insulation')">
                    <plus-icon class="h-4 w-4 mr-1" />
                    <span class="text-xs">Dämmung hinzufügen</span>
                </bz-button>
                <bz-button type="secondary" @click="openDrawer('skylight')">
                    <plus-icon class="h-4 w-4 mr-1" />
                    <span class="text-xs">Dachfenster hinzufügen</span>
                </bz-button>
                <bz-button
                    v-if="form.roof_shape.title === 'Satteldach'"
                    type="secondary"
                    @click="openDrawer('dormer')">
                    <plus-icon class="h-4 w-4 mr-1" />
                    <span class="text-xs">Gaube hinzufügen</span>
                </bz-button>
            </div>

            <el-drawer v-model="state.skylight">
                <template #header>
                    <h2>Dachfenster hinzufügen</h2>
                </template>

                <el-form label-position="top" size="large">
                    <el-form-item
                        label="Anzahl"
                        :error="skylightForm.errors.count">
                        <el-input-number
                            v-model="skylightForm.count"
                            :max="20"
                            :min="0"
                            :step="1"
                            placeholder="0"></el-input-number>
                    </el-form-item>

                    <el-form-item
                        label="Höhe in cm"
                        :error="skylightForm.errors.height">
                        <el-input-number
                            v-model="skylightForm.height"
                            :max="500"
                            :min="0"
                            :step="1"
                            placeholder="0"></el-input-number>
                    </el-form-item>

                    <el-form-item
                        label="Breite in cm"
                        :error="skylightForm.errors.width">
                        <el-input-number
                            v-model="skylightForm.width"
                            :max="500"
                            :min="0"
                            :step="1"
                            placeholder="0"></el-input-number>
                    </el-form-item>

                    <el-form-item
                        label="Verglasung"
                        :error="skylightForm.errors.glazing">
                        <el-select
                            v-model="skylightForm.glazing"
                            class="w-full"
                            placeholder="Bitte auswählen">
                            <el-option
                                label="Nicht bekannt"
                                value="Nicht bekannt"></el-option>
                            <el-option
                                label="Einfach verglast"
                                value="Einfach verglast"></el-option>
                            <el-option
                                label="Doppelt verglast"
                                value="Doppelt verglast"></el-option>
                            <el-option
                                label="Dreifach verglast"
                                value="Dreifach verglast"></el-option>
                        </el-select>
                    </el-form-item>

                    <div class="flex justify-end mt-5">
                        <bz-button type="primary" @click="addSkylight"
                            >Hinzufügen</bz-button
                        >
                    </div>
                </el-form>
            </el-drawer>

            <el-drawer v-model="state.dormer">
                <template #header>
                    <h2>Gaube hinzufügen</h2>
                </template>

                <el-form label-position="top" size="large">
                    <el-form-item
                        :error="dormerForm.errors.form"
                        label="Bauweise">
                        <el-select
                            v-model="dormerForm.form"
                            class="w-full"
                            placeholder="Bitte auswählen">
                            <el-option
                                label="Schleppgaube"
                                value="Schleppgaube"></el-option>
                            <el-option
                                label="Giebelgaube"
                                value="Giebelgaube"></el-option>
                            <el-option
                                label="Dachgiebel"
                                value="Dachgiebel"></el-option>
                            <el-option
                                label="Fledermausgaube"
                                value="Fledermausgaube"></el-option>
                            <el-option
                                label="Tonnendachgiebelgaube"
                                value="Tonnendachgiebelgaube"></el-option>
                            <el-option
                                label="Rundgaube"
                                value="Rundgaube"></el-option>
                            <el-option
                                label="Spitzgaube"
                                value="Spitzgaube"></el-option>
                            <el-option
                                label="Sonstige"
                                value="Sonstige"></el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item
                        :error="dormerForm.errors.count"
                        label="Anzahl">
                        <el-input-number
                            v-model="dormerForm.count"
                            :max="20"
                            :min="0"
                            :step="1"
                            placeholder="0"></el-input-number>
                    </el-form-item>

                    <el-form-item
                        :error="dormerForm.errors.height"
                        label="Stirnseitige Höhe in cm">
                        <el-input-number
                            v-model="dormerForm.height"
                            :max="500"
                            :min="0"
                            :step="1"
                            placeholder="0"></el-input-number>
                    </el-form-item>

                    <el-form-item
                        :error="dormerForm.errors.width"
                        label="Stirnseitige Breite in cm">
                        <el-input-number
                            v-model="dormerForm.width"
                            :max="500"
                            :min="0"
                            :step="1"
                            placeholder="0"></el-input-number>
                    </el-form-item>

                    <el-alert
                        show-icon
                        title="Höhe und Breite müssen nicht Zentimeter genau angegeben werden."
                        type="info" />

                    <div class="flex justify-end mt-5">
                        <bz-button @click="addDormer">Hinzufügen</bz-button>
                    </div>
                </el-form>
            </el-drawer>

            <el-drawer v-model="state.insulation">
                <template #header>
                    <h2>Dämmung hinzufügen</h2>
                </template>

                <el-form label-position="top" size="large">
                    <el-form-item
                        :error="insulationForm.errors.type"
                        label="Form der Dämmung">
                        <el-select
                            v-model="insulationForm.type"
                            class="w-full"
                            placeholder="Bitte auswählen">
                            <el-option
                                label="Nicht bekannt"
                                value="nicht bekannt"></el-option>
                            <el-option
                                label="Aufdachdämmung"
                                value="Aufdachdämmung"></el-option>
                            <el-option
                                label="Gefachdämmung"
                                value="Gefachdämmung"></el-option>
                        </el-select>
                    </el-form-item>

                    <el-form-item
                        :error="insulationForm.errors.thickness"
                        label="Stärke in cm">
                        <el-input-number
                            v-model="insulationForm.thickness"
                            :max="500"
                            :min="0"
                            :step="1"
                            placeholder="0"></el-input-number>
                    </el-form-item>

                    <div class="flex justify-end mt-5">
                        <bz-button @click="addInsulation">Hinzufügen</bz-button>
                    </div>
                </el-form>
            </el-drawer>
        </template>

        <div
            id="roof-button-container"
            class="w-full flex justify-end p-5 border-t border-gray-200">
            <bz-button
                :disabled="
                    form.processing ||
                    !form.isDirty ||
                    form.construction.length !== 2
                "
                @click="safe">
                {{
                    form.isDirty
                        ? form.construction.length < 2
                            ? 'Nicht genug Daten'
                            : 'Speichern'
                        : 'Bereits gespeichert'
                }}
            </bz-button>
        </div>
    </el-card>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
