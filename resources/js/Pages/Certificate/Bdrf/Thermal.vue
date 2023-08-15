<script setup>
import GuestLayout from '../../../Layouts/GuestLayout.vue';
import StepperWrapper from '../../../Wrappers/StepperWrapper.vue';
import WallForm from '../../../Components/WallForm.vue';
import FormHeader from '../../../Components/FormHeader.vue';
import {
    CheckCircleIcon,
    ExclamationTriangleIcon,
} from '@heroicons/vue/20/solid';
import InformationBox from '../../../Components/InformationBox.vue';
import Badge from '../../../Components/Badge.vue';
import { ref } from 'vue';
import RoofForm from '../../../Components/RoofForm.vue';
import CellarForm from '../../../Components/CellarForm.vue';
import BzButton from '../../../Components/BzButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import PageWrapper from '../../../Wrappers/PageWrapper.vue';

const props = defineProps({
    order: Object,
});

const active = ref('wall');

const form = useForm({});

const submit = () => {
    const url = usePage().props.user
        ? route('hub.certificates.update', {
              order: props.order.slug,
              page: 'thermal',
          })
        : route('certificate.update', {
              order: props.order.slug,
              page: 'thermal',
              signature: route().params.signature,
          });

    form.put(url);
};
</script>

<template>
    <page-wrapper>
        <information-box to="#infobox">
            <div v-if="active === 'wall'" class="flex flex-col">
                <Badge dot label="Außenwand"></Badge>
                <p class="text-xs text-gray-500 mt-2">
                    Wenn Sie keine Angaben zu Dämmung und Fenstern machen,
                    verwenden wir Standardwerte. Obwohl der Wandaufbau
                    ausreicht, empfehlen wir genauere Daten, da dies meist zu
                    besseren Ergebnissen führt.
                </p>
            </div>
        </information-box>

        <form-header
            subtitle="Angaben zur Außenwand, Dach und dem Keller"
            title="Thermische Hülle" />
        <el-collapse v-model="active" accordion>
            <el-collapse-item name="wall">
                <template #title>
                    <CheckCircleIcon
                        v-if="order.certificate?.wall?.id"
                        class="h-5 w-5 text-emerald-500 mr-4" />
                    <ExclamationTriangleIcon
                        v-else
                        class="h-5 w-5 text-orange-400 mr-4" />
                    Außenwand
                </template>
                <wall-form :order="order" />
            </el-collapse-item>
            <el-collapse-item name="roof">
                <template #title>
                    <CheckCircleIcon
                        v-if="order.certificate.roof?.id"
                        class="h-5 w-5 text-emerald-500 mr-4" />
                    <ExclamationTriangleIcon
                        v-else
                        class="h-5 w-5 text-orange-400 mr-4" />
                    Dach
                </template>
                <roof-form :order="order" />
            </el-collapse-item>
            <el-collapse-item>
                <template #title>
                    <CheckCircleIcon
                        v-if="order.certificate.cellar?.id"
                        class="h-5 w-5 text-emerald-500 mr-4" />
                    <ExclamationTriangleIcon
                        v-else
                        class="h-5 w-5 text-orange-400 mr-4" />
                    Keller
                </template>
                <cellar-form :order="order" />
            </el-collapse-item>
        </el-collapse>
        <div class="grid sm:flex sm:justify-between sm:col-span-2 gap-4 mt-6">
            <div class="grid sm:block">
                <bz-button
                    v-if="$page.props.user"
                    as="link"
                    type="secondary"
                    :href="
                        route('hub.certificates.show', {
                            order: order.slug,
                            page: 'position',
                        })
                    ">
                    Zurück
                </bz-button>
                <bz-button
                    v-else
                    as="link"
                    type="secondary"
                    :href="
                        route('certificate.show', {
                            signature: route().params.signature,
                            order: order.slug,
                            page: 'position',
                        })
                    ">
                    Zurück
                </bz-button>
            </div>
            <div class="grid sm:block">
                <bz-button
                    :disabled="
                        !order.certificate.wall?.id ||
                        !order.certificate.roof?.id ||
                        !order.certificate.cellar?.id
                    "
                    @click="submit"
                    >{{
                        order.certificate.wall?.id &&
                        order.certificate.roof?.id &&
                        order.certificate.cellar?.id
                            ? 'Speichern & Weiter'
                            : 'Nicht genügend Daten'
                    }}</bz-button
                >
            </div>
        </div>
    </page-wrapper>
</template>

<style scoped>
.el-input-number {
    width: 100%;
}
</style>
