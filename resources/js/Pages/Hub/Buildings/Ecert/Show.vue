<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import BzButton from '../../../../Components/BzButton.vue';
import { ref } from 'vue';
import DialogModal from '../../../../Components/DialogModal.vue';
import { ElNotification } from 'element-plus';
import BuildingWrapper from '../Shared/BuildingWrapper.vue';
import VrbrCard from './Cards/VrbrCard.vue';
import BdrfCard from './Cards/BdrfCard.vue';

const props = defineProps({
    building: Object,
});

const modal = ref(false);

const form = useForm({
    type: null,
    reason: null,
    suggestion_check: {
        attic: false,
        external_wall: false,
        windows: false,
        cellar_ceiling: false,
        led: false,
    },
});

const order = (type) => {
    form.type = type;
    modal.value = true;
};

const cancel = () => {
    form.reset();
    modal.value = false;
};

const submitOrder = () => {
    form.post(
        route('buildings.products.ecert.store', {
            building: props.building.data.id,
        }),
        {
            preserveScroll: true,
            onSuccess: () => {
                ElNotification({
                    title: 'Bestellung erfolgreich',
                    message: 'Ihre Bestellung wurde erfolgreich abgeschlossen.',
                    type: 'success',
                });
                modal.value = false;
            },
            onFinish: () => {
                form.reset();
            },
        },
    );
};

const openModal = type => {
    form.type = type;
    modal.value = true;
};

</script>

<template>
    <Head>
        <title>Energieausweis</title>
    </Head>

    <building-wrapper :building="building" sub-tabs-products-active>
        <div class="py-4 space-y-4">

            <vrbr-card :building="building" @create-vrbr="openModal('vrbr')" />
            <bdrf-card :building="building" @create-bdrf="openModal('bdrf')" />

        </div>

    </building-wrapper>

    <dialog-modal :closeable="true" :show="modal" @close="cancel">
        <template #title
        ><span class=""
        >{{
                form.type === 'vrbr'
                    ? 'Verbrauchsausweis'
                    : 'Bedarfsausweis'
            }}
                - Bestellung abschließen</span
        ></template
        >
        <template #content>
            <el-form
                :model="form"
                class="grid sm:grid-cols-2 sm:gap-x-8"
                label-position="top"
                size="large"
                @submit.prevent="">
                <el-form-item
                    :error="form.errors.reason"
                    :required="true"
                    label="Ausstellungsgrund">
                    <el-select
                        v-model="form.reason"
                        class="w-full"
                        placeholder="Bitte auswählen">
                        <el-option
                            default-first-option
                            label="Modernisierung/Änderung"
                            value="Modernisierung/Änderung" />
                        <el-option
                            default-first-option
                            label="Vermietung/Verkauf"
                            value="Vermietung/Verkauf" />
                        <el-option
                            default-first-option
                            label="Sonstiges"
                            value="Sonstiges" />
                    </el-select>
                </el-form-item>
                <div class="flex flex-col">
                    <el-checkbox
                        v-model="form.suggestion_check.attic"
                        label="Dach-/Dachbodendämmung"></el-checkbox>
                    <el-checkbox
                        v-model="form.suggestion_check.external_wall"
                        label="Außenwanddämmung"></el-checkbox>
                    <el-checkbox
                        v-model="form.suggestion_check.windows"
                        label="Wärmeschutz-/Isolierverglasung"></el-checkbox>
                    <el-checkbox
                        v-model="form.suggestion_check.cellar_ceiling"
                        label="Kellerdeckendämmung"></el-checkbox>
                    <el-checkbox
                        v-model="form.suggestion_check.led"
                        label="Ausschließlich LED Leuchtmittel"></el-checkbox>
                </div>
            </el-form>
        </template>
        <template #footer>
            <div class="flex justify-end space-x-2">
                <bz-button type="secondary" @click="cancel"
                >Abbrechen
                </bz-button
                >
                <bz-button @click="submitOrder"
                >Kostenpflichtig bestellen
                </bz-button
                >
            </div>
        </template>
    </dialog-modal>
</template>
