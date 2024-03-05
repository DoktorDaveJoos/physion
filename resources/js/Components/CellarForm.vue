<script setup>
import { useForm, router } from '@inertiajs/vue3';
import {
    CheckCircleIcon,
    ExclamationTriangleIcon,
} from '@heroicons/vue/20/solid';
import {
    PlusIcon,
    Square3Stack3DIcon,
    TrashIcon,
} from '@heroicons/vue/24/outline';
import { computed, onMounted, reactive } from 'vue';
import { ElNotification } from 'element-plus';
import BzButton from './BzButton.vue';

const props = defineProps({
    buildingId: Number,
    cellar: Object,
});

const cellar = computed(() => props.cellar);

const form = useForm({
    type: null,
    u_value: null,
    ceiling: null,
    height: null,
});

onMounted(() => {
    form.defaults({
        type: cellar?.value?.type ?? null,
        u_value: cellar?.value?.u_value ?? null,
        ceiling: cellar?.value?.ceiling ?? null,
        height: cellar?.value?.height ?? null,
    });

    form.reset();
});

const insulationForm = useForm({
    type: null,
    thickness: null,
});

const state = reactive({
    insulation: false,
});

const safe = () => {
    form.put(
        route('buildings.cellars.update', {
            building: props.buildingId,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                ElNotification({
                    title: 'Gespeichert',
                    message: 'Keller erfolgreich gespeichert',
                    type: 'success',
                });
            },
        }
    );
};

const addInsulation = () => {
    insulationForm.post(
        route('buildings.cellars.insulations.store', {
            cellar: props.cellar,
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

const deleteInsulation = (id) => {
    router.delete(
        route('buildings.cellars.insulations.destroy', {
            cellar: props.cellar,
            building: props.buildingId,
            insulation: id,
        }),
        {
            preserveScroll: true,
        }
    );
};

const openDrawer = (drawer) => (state[drawer] = true);

const hasAdditional = computed(() => {
    return props.cellar?.insulations?.length > 0;
});
</script>
<template>
    <el-form
        :model="form"
        class="grid sm:grid-cols-2 sm:gap-4 px-6 py-4"
        label-position="top"
        size="large">
        <el-form-item label="Keller" required :error="form.errors.type">
            <el-select
                v-model="form.type"
                class="w-full"
                placeholder="Bitte wählen">
                <el-option
                    v-for="item in [
                        { label: 'Beheizt', value: 'Beheizt' },
                        { label: 'Kalt', value: 'Kalt' },
                        { label: 'Kein Keller', value: 'Kein Keller' },
                    ]"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value" />
            </el-select>
        </el-form-item>

        <div class="hidden sm:block"></div>

        <el-form-item
            v-if="form.type !== 'Kein Keller'"
            label="Raumhöhe in m"
            :error="form.errors.height">
            <el-input-number
                v-model="form.height"
                :max="10"
                :min="0"
                :precision="2"
                :step="0.01"
                placeholder="0" />
        </el-form-item>
        <el-form-item
            label="Bodenplatte/Zwischendecke Dämmung"
            :error="form.errors.ceiling">
            <el-input-number
                v-model="form.ceiling"
                :max="100"
                :min="0"
                :step="1"
                placeholder="0" />
        </el-form-item>
        <el-form-item
            label="U-Wert (falls bekannt) (Bodenplatte/Zwischendecke)"
            :error="form.errors.u_value">
            <el-input-number
                v-model="form.u_value"
                :max="10"
                :min="0"
                :precision="2"
                :step="0.08"
                placeholder="0" />
        </el-form-item>
    </el-form>

    <template v-if="hasAdditional">
        <div
            class="border-t border-gray-200 shadow-inner px-6 py-4 space-y-1 bg-gray-50">
            <div v-if="cellar?.insulations?.length > 0">
                <span class="text-xs text-gray-500"
                    >Dämmung und Isolierung</span
                >
            </div>

            <div
                v-for="insulation in cellar?.insulations"
                class="flex rounded-lg bg-white border border-gray-200 p-2 items-center">
                <div
                    class="h-12 w-12 mr-4 bg-gray-100 rounded-lg flex justify-center items-center">
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
        </div>
    </template>

    <div
        v-if="cellar && cellar.type !== 'Kein Keller'"
        class="p-4 flex justify-end border-t border-gray-100">
        <bz-button type="secondary" @click="openDrawer('insulation')">
            <plus-icon class="h-4 w-4 mr-1" />
            <span class="text-xs">Dämmung hinzufügen</span>
        </bz-button>
    </div>

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
                    : cellar
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
