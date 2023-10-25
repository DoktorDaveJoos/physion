<script setup>
import {
    PaperClipIcon,
    TrashIcon,
    ArrowDownTrayIcon,
} from '@heroicons/vue/24/outline';
import BzButton from '../../../../Components/BzButton.vue';
import DialogModal from '../../../../Components/DialogModal.vue';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import BzDropzone from '../../../../Components/BzDropzone.vue';
import { ElNotification } from 'element-plus';
import Badge from '../../../../Components/Badge.vue';

const props = defineProps({
    building: Object,
});

const modal = ref(false);
const loading = ref(false);

const form = useForm({
    type: null,
    document: null,
});

const cancel = () => {
    form.reset();
    modal.value = false;
};

const handleSelect = (e) => {
    form.document = e;
};

const submit = () => {
    form.post(route('buildings.attachments.store', props.building.data.id), {
        onStart: () => {
            loading.value = true;
        },
        onSuccess: () => {
            cancel();
        },
        onError: (e) => {
            console.log(e);
        },
        onFinish: () => {
            loading.value = false;
        },
    });
};

const destroy = (id) => {
    router.delete(
        route(
            'buildings.attachments.destroy',
            {
                building: props.building.data.id,
                attachment: id,
            },
            {
                onStart: () => {
                    loading.value = true;
                },
                onSuccess: () => {
                    ElNotification({
                        title: 'Dokument gelöscht',
                        message: 'Das Dokument wurde erfolgreich gelöscht.',
                        type: 'success',
                    });
                },
                onFinish: () => {
                    loading.value = false;
                },
            }
        )
    );
};

const types = [
    { label: 'Baugesuch', value: 'baugesuch' },
    { label: 'Grundriss', value: 'grundriss' },
    { label: 'Sonstiges', value: 'misc' },
];
</script>

<template>
    <div class="rounded-lg shadow bg-white mt-4 flex flex-col">
        <div class="flex px-6 py-4 justify-between items-center">
            <div>
                <h3 class="text-base font-semibold leading-7 text-gray-900">
                    Gebäudedokumente
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    Baugesuch, Grundriss, etc.
                </p>
            </div>
            <bz-button type="secondary" @click="modal = true"
                >dokument hochladen</bz-button
            >
        </div>
        <div class="border-t border-gray-100">
            <ul
                v-if="
                    building.data.attachments.filter(
                        (file) => file.data.type !== 'picture'
                    ).length > 0
                "
                class="divide-y divide-gray-100"
                role="list">
                <li
                    v-for="file in building.data.attachments.filter(
                        (file) => file.data.type !== 'picture'
                    )"
                    class="flex items-center justify-between py-4 px-6 text-sm leading-6">
                    <div class="flex w-0 flex-1 items-center">
                        <PaperClipIcon
                            aria-hidden="true"
                            class="h-5 w-5 flex-shrink-0 text-gray-400" />
                        <div class="ml-4 flex min-w-0 flex-1 gap-2">
                            <span class="truncate font-medium">{{
                                file.data.name
                            }}</span>
                            <span class="flex-shrink-0 text-gray-400">{{
                                file.data.size
                            }}</span>
                            <badge
                                v-if="file.data.type === 'baugesuch'"
                                size="sm"
                                label="Baugesuch">
                            </badge>
                            <badge
                                v-if="file.data.type === 'grundriss'"
                                size="sm"
                                label="Grundriss">
                            </badge>
                        </div>
                    </div>
                    <div class="ml-4 flex-shrink-0 flex items-center space-x-2">
                        <a :href="file.links.self" download>
                            <ArrowDownTrayIcon
                                aria-hidden="true"
                                class="h-5 w-5 text-gray-400" />
                        </a>
                        <button type="button" @click="destroy(file.data.id)">
                            <TrashIcon
                                aria-hidden="true"
                                class="h-5 w-5 text-gray-400" />
                        </button>
                    </div>
                </li>
            </ul>
            <el-empty description="Noch keine Dokumente vorhanden" v-else>
            </el-empty>
        </div>
    </div>
    <dialog-modal
        v-loading="form.processing"
        :show="modal"
        :closeable="true"
        @close="cancel">
        <template #title>Dokument hochladen</template>
        <template #content>
            <el-form @submit.prevent="submit" label-position="top" size="large">
                <el-form-item label="Dokumenttyp" :error="form.errors.type">
                    <el-select v-model="form.type" placeholder="Dokumenttyp">
                        <el-option
                            v-for="type in types"
                            :key="type.value"
                            :label="type.label"
                            :value="type.value"></el-option>
                    </el-select>
                </el-form-item>
            </el-form>

            <el-form-item class="!w-full" :error="form.errors.document">
                <bz-dropzone
                    class="w-full"
                    v-if="!form.document"
                    text="Dokument hochladen"
                    :allowed-mime-types="['application/pdf']"
                    @select="(e) => handleSelect(e)"></bz-dropzone>

                <div
                    v-else
                    class="flex w-full items-center px-6 py-4 rounded border border-gray-300 justify-between">
                    <div class="flex">
                        <paper-clip-icon class="h-5 w-5 text-gray-400 mr-2" />
                        <span class="font-semibold text-sm">{{
                            form.document.name
                        }}</span>
                    </div>
                    <button type="button" @click="form.document = null">
                        <trash-icon class="h-4 w-4 text-red-400 ml-4" />
                    </button>
                </div>
            </el-form-item>
        </template>
        <template #footer>
            <div class="flex justify-end">
                <bz-button type="secondary" @click="cancel"
                    >abbrechen</bz-button
                >
                <bz-button
                    type="primary"
                    :loading="form.processing"
                    @click="submit"
                    >hochladen</bz-button
                >
            </div>
        </template>
    </dialog-modal>
</template>
