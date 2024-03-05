<script setup>
import { useForm, router } from '@inertiajs/vue3';
import {
    CheckCircleIcon,
    ExclamationTriangleIcon,
} from '@heroicons/vue/20/solid';
import {
    PlusIcon,
    Square3Stack3DIcon,
    SunIcon,
    TrashIcon,
} from '@heroicons/vue/24/outline';
import { computed, onMounted, reactive } from 'vue';
import { ElNotification } from 'element-plus';
import BzButton from './BzButton.vue';

const props = defineProps({
    buildingId: Number,
    wall: Object,
});

const form = useForm({
    u_value: null,
    construction: null,
    variant: null,
    thickness: null,
    height: null,
});

onMounted(() => {
    form.defaults({
        u_value: props.wall?.u_value ?? null,
        construction: props.wall?.construction
            ? [props.wall?.construction, props.wall?.variant]
            : null,
        variant: props.wall?.variant ?? null,
        thickness: props.wall?.thickness ?? null,
        height: props.wall?.height ?? null,
    });

    form.reset();
});

const windowForm = useForm({
    count: null,
    height: null,
    width: null,
    glazing: null,
});

const insulationForm = useForm({
    type: null,
    thickness: null,
});

const state = reactive({
    insulation: false,
    window: false,
});

const prepareForm = (form) =>
    form.transform((data) => ({
        ...data,
        construction: data.construction[0],
        variant: data.construction[1],
    }));

const safe = () => {
    prepareForm(form).put(
        route('buildings.walls.update', {
            building: props.buildingId,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                ElNotification({
                    title: 'Gespeichert',
                    message: 'Wand erfolgreich gespeichert',
                    type: 'success',
                });
            },
        }
    );
};

const addInsulation = () => {
    insulationForm.post(
        route('buildings.walls.insulations.store', {
            wall: props.wall.id,
            building: props.buildingId,
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

const addWindow = () => {
    windowForm.post(
        route('buildings.walls.windows.store', {
            wall: props.wall.id,
            building: props.buildingId,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                windowForm.reset();
                state.window = false;
            },
        }
    );
};

const deleteInsulation = (id) => {
    router.delete(
        route('buildings.walls.insulations.destroy', {
            wall: props.wall.id,
            building: props.buildingId,
            insulation: id,
        }),
        {
            preserveScroll: true,
        }
    );
};

const deleteWindow = (id) => {
    router.delete(
        route('buildings.walls.windows.destroy', {
            wall: props.wall.id,
            building: props.buildingId,
            window: id,
        }),
        {
            preserveScroll: true,
        }
    );
};

const options = [
    {
        value: 'massiv',
        label: 'Massiv',
        children: [
            {
                value: 'ziegel',
                label: 'Ziegel',
            },
            {
                value: 'bims',
                label: 'Bims',
            },
            {
                value: 'beton',
                label: 'Beton',
            },
            {
                value: 'vollholz',
                label: 'Vollholz',
            },
            {
                value: 'sonstiges',
                label: 'Sonstiges',
            },
        ],
    },
    {
        value: 'leicht',
        label: 'Leicht',
        children: [
            {
                value: 'holzständer',
                label: 'Holzständer',
            },
        ],
    },
];

const openDrawer = (drawer) => (state[drawer] = true);

const hasAdditional = computed(() => {
    return (
        props.wall?.insulations?.length > 0 || props.wall?.windows?.length > 0
    );
});
</script>
<template>
    <div class="absolute top-6 right-4">
        <div
            v-if="form.isDirty"
            class="text-xs text-gray-500 flex items-center">
            <ExclamationTriangleIcon class="h-4 w-4 mr-1 text-yellow-500" />
            es gibt nicht gespeicherte Änderungen
        </div>
        <div v-else-if="wall" class="text-xs text-gray-500 flex items-center">
            <CheckCircleIcon class="h-4 w-4 mr-1 text-emerald-500" />
            alles gespeichert
        </div>
    </div>

    <el-form
        :model="form"
        class="grid sm:grid-cols-2 sm:gap-4 py-4 px-6"
        label-position="top"
        size="large">
        <el-form-item
            label="Bauweise"
            required
            :error="form.errors.construction">
            <el-cascader
                v-model="form.construction"
                :options="options"
                :props="{ expandTrigger: 'hover' }"
                class="w-full"
                placeholder="Bitte wählen" />
        </el-form-item>

        <el-form-item
            label="Geschosshöhe in m"
            :error="form.errors.height"
            required>
            <el-input-number
                v-model="form.height"
                :precision="2"
                :max="10"
                :min="0"
                :step="0.01"
                placeholder="0" />
        </el-form-item>

        <el-form-item
            label="Stärke der Wand in cm (falls bekannt)"
            :error="form.errors.thickness">
            <el-input-number
                v-model="form.thickness"
                :max="200"
                :min="0"
                :step="1"
                placeholder="0" />
        </el-form-item>
        <el-form-item
            label="U-Wert (falls bekannt)"
            :error="form.errors.u_value">
            <el-input-number
                v-model="form.u_value"
                :max="10"
                :min="0.08"
                :precision="2"
                :step="0.01"
                placeholder="0" />
        </el-form-item>
    </el-form>

    <template v-if="hasAdditional">
        <div
            class="border-t border-gray-200 shadow-inner px-6 py-4 space-y-1 bg-gray-50">
            <div v-if="wall?.insulations?.length > 0">
                <span class="text-xs text-gray-500"
                    >Dämmung und Isolierung</span
                >
            </div>

            <div
                v-for="insulation in wall?.insulations"
                class="flex rounded-lg bg-white border border-gray-200 p-2 items-center">
                <div
                    class="h-12 w-12 mr-4 bg-gray-100 rounded flex justify-center items-center">
                    <Square3Stack3DIcon class="h-6 w-6 text-gray-500" />
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

            <div v-if="wall?.windows?.length > 0">
                <span class="text-xs text-gray-500"
                    >Fenster und Fensterflächen</span
                >
            </div>

            <div
                v-for="window in wall?.windows"
                class="flex rounded-lg bg-white border border-gray-200 p-2 items-center">
                <div
                    class="h-12 w-12 mr-4 bg-gray-100 rounded-lg flex justify-center items-center">
                    <SunIcon class="h-6 w-6 text-gray-500" />
                </div>

                <div class="flex-1">
                    <h3 class="text-gray-800 text-sm">
                        Fenster - {{ window.glazing }}
                    </h3>
                    <div class="flex">
                        <span class="text-xs text-gray-500 mr-2"
                            >{{ window.count }} Stück</span
                        >
                        <span class="text-xs text-gray-500 mr-2"
                            >{{ window.height }}cm x {{ window.width }}cm</span
                        >
                    </div>
                </div>
                <div class="flex-shrink-0">
                    <el-button
                        size="small"
                        text
                        @click="deleteWindow(window.id)">
                        <trash-icon class="h-4 w-4" />
                    </el-button>
                </div>
            </div>
        </div>
    </template>

    <div
        v-if="wall"
        class="p-4 flex space-x-2 justify-end border-t border-gray-100">
        <bz-button type="secondary" @click="openDrawer('window')">
            <plus-icon class="h-4 w-4 mr-1" />
            <span class="text-xs">Fenster hinzufügen</span>
        </bz-button>
        <bz-button type="secondary" @click="openDrawer('insulation')">
            <plus-icon class="h-4 w-4 mr-1" />
            <span class="text-xs">Dämmung hinzufügen</span>
        </bz-button>
    </div>

    <el-drawer v-model="state.window">
        <template #header>
            <h2>Fenster hinzufügen</h2>
        </template>

        <el-form label-position="top" size="large">
            <el-form-item label="Anzahl" :error="windowForm.errors.count">
                <el-input-number
                    v-model="windowForm.count"
                    :max="20"
                    :min="0"
                    :step="1"
                    placeholder="0"></el-input-number>
            </el-form-item>

            <el-form-item label="Höhe in cm" :error="windowForm.errors.height">
                <el-input-number
                    v-model="windowForm.height"
                    :max="500"
                    :min="0"
                    :step="1"
                    placeholder="0"></el-input-number>
            </el-form-item>

            <el-form-item label="Breite in cm" :error="windowForm.errors.width">
                <el-input-number
                    v-model="windowForm.width"
                    :max="500"
                    :min="0"
                    :step="1"
                    placeholder="0"></el-input-number>
            </el-form-item>

            <el-form-item label="Verglasung" :error="windowForm.errors.glazing">
                <el-select
                    v-model="windowForm.glazing"
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
                <bz-button @click="addWindow">Hinzufügen</bz-button>
            </div>
        </el-form>
    </el-drawer>

    <el-drawer v-model="state.insulation">
        <template #header>
            <h2>Dämmung hinzufügen</h2>
        </template>

        <el-form label-position="top" size="large">
            <el-form-item
                label="Form der Dämmung"
                :error="insulationForm.errors.type">
                <el-select
                    v-model="insulationForm.type"
                    class="w-full"
                    placeholder="Bitte auswählen">
                    <el-option
                        label="Nicht bekannt"
                        value="Nicht bekannt"></el-option>
                    <el-option
                        label="Außenwanddämmung"
                        value="Außenwanddämmung"></el-option>
                    <el-option
                        label="Innendämmung"
                        value="Innendämmung"></el-option>
                </el-select>
            </el-form-item>

            <el-form-item
                label="Stärke in cm"
                :error="insulationForm.errors.thickness">
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

    <div class="w-full flex justify-end p-4 border-t border-gray-100">
        <bz-button :disabled="form.processing || !form.isDirty" @click="safe">
            {{
                form.isDirty
                    ? 'Speichern'
                    : wall
                    ? 'Gespeichert'
                    : 'Nicht genügend Daten'
            }}
        </bz-button>
    </div>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
