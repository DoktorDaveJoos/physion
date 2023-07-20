<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
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
import { Inertia } from '@inertiajs/inertia';
import BzButton from './BzButton.vue';

const props = defineProps({
    order: Object,
});

const cellar = computed(() => props.order.certificate?.cellar);

const form = useForm({
    heated: null,
    u_value: null,
    ceiling: null,
});

onMounted(() => {
    form.defaults({
        heated: cellar?.value?.heated ?? null,
        u_value: cellar?.value?.u_value ?? null,
        ceiling: cellar?.value?.ceiling ?? null,
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
        route('bdrf.cellar', {
            bdrf: props.order.certificate.id,
            signature: usePage().props.value.signature,
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
    insulationForm.put(
        route('bdrf.cellar.insulation', {
            bdrf: props.order.certificate.id,
            signature: usePage().props.value.signature,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                insulationForm.reset();
                state.insulation = false;
            },
            onError: (err) => {
                ElNotification({
                    title: 'Fehler',
                    message: err.message,
                    type: 'error',
                });
            },
        }
    );
};

const deleteInsulation = (id) => {
    Inertia.delete(
        route('bdrf.cellar.insulation.delete', {
            bdrf: props.order.certificate.id,
            insulation: id,
            signature: usePage().props.value.signature,
        }),
        {
            preserveScroll: true,
        }
    );
};

const openDrawer = (drawer) => (state[drawer] = true);

const hasAdditional = computed(() => {
    return cellar?.value?.insulations?.length > 0;
});
</script>
<template>
    <el-card
        :body-style="{ padding: '0px', position: 'relative' }"
        shadow="never">
        <div class="absolute top-6 right-4">
            <div
                v-if="form.isDirty"
                class="text-xs text-gray-500 flex items-center">
                <ExclamationTriangleIcon class="h-4 w-4 mr-1 text-yellow-500" />
                es gibt nicht gespeicherte Änderungen
            </div>
            <div
                v-else-if="order.certificate?.cellar"
                class="text-xs text-gray-500 flex items-center">
                <CheckCircleIcon class="h-4 w-4 mr-1 text-emerald-500" />
                alles gespeichert
            </div>
        </div>

        <el-form
            :model="form"
            class="grid sm:grid-cols-2 sm:gap-4 p-4"
            label-position="top"
            size="large">
            <el-form-item label="Keller" required :error="form.errors.heated">
                <el-select
                    v-model="form.heated"
                    class="w-full"
                    placeholder="Bitte wählen">
                    <el-option
                        v-for="item in [
                            { label: 'Beheizt', value: true },
                            { label: 'Kalt', value: false },
                        ]"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value" />
                </el-select>
            </el-form-item>

            <div class="hidden sm:block"></div>

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
        </el-form>

        <template v-if="hasAdditional">
            <div
                class="border-t border-gray-200 px-6 pb-6 space-y-2 bg-gray-50">
                <div v-if="cellar?.insulations?.length > 0" class="pt-4">
                    <span class="text-xs text-gray-500"
                        >Dämmung und Isolierung</span
                    >
                </div>

                <div
                    v-for="insulation in cellar?.insulations"
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
            </div>
        </template>

        <div
            v-if="cellar"
            class="p-4 flex justify-end border-t border-gray-200">
            <bz-button plain @click="openDrawer('insulation')">
                <plus-icon class="h-4 w-4 mr-1" />
                <span class="text-xs">Dämmung hinzufügen</span>
            </bz-button>
        </div>

        <el-drawer v-model="state.insulation">
            <template #header>
                <h2>Dämmung hinzufügen</h2>
            </template>

            <el-form label-position="top" size="large">
                <el-form-item label="Form der Dämmung">
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

                <el-form-item label="Stärke in cm">
                    <el-input-number
                        v-model="insulationForm.thickness"
                        :max="500"
                        :min="0"
                        :step="1"
                        placeholder="0"></el-input-number>
                </el-form-item>

                <div class="flex justify-end mt-5">
                    <el-button type="primary" @click="addInsulation"
                        >Hinzufügen</el-button
                    >
                </div>
            </el-form>
        </el-drawer>

        <div class="w-full flex justify-end p-4 border-t border-gray-200">
            <el-button
                :disabled="
                    form.processing || !form.isDirty || form.heated === null
                "
                size="large"
                type="primary"
                @click="safe">
                {{
                    form.isDirty
                        ? form.heated === null
                            ? 'Nicht genug Daten'
                            : 'Speichern'
                        : cellar
                        ? 'Gespeichert'
                        : 'Speichern'
                }}
            </el-button>
        </div>
    </el-card>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
