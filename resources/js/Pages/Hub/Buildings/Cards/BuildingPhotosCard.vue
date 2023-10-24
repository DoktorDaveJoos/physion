<script setup>
import BzButton from '../../../../Components/BzButton.vue';
import {
    PaperClipIcon,
    TrashIcon,
    ArrowTopRightOnSquareIcon,
    XMarkIcon,
} from '@heroicons/vue/24/outline';
import DialogModal from '../../../../Components/DialogModal.vue';
import BzDropzone from '../../../../Components/BzDropzone.vue';
import { ref } from 'vue';
import { router, useForm } from '@inertiajs/vue3';
import { ElNotification } from 'element-plus';

const props = defineProps({
    building: Object,
});

const modal = ref(false);
const modalDetail = ref(false);
const loading = ref(false);
const detail = ref(null);

const form = useForm({
    pictures: null,
});

const cancel = () => {
    form.reset();
    modal.value = false;
};

const handleSelect = (e) => {
    form.pictures = e;
};

const submit = () => {
    form.post(route('buildings.attachments.store', props.building.data.id), {
        onStart: () => {
            loading.value = true;
        },
        onSuccess: () => {
            cancel();
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

const handleDetail = (id) => {
    detail.value = props.building.data.attachments.find(
        (file) => file.data.id === id
    ).links.self;
    modalDetail.value = true;
};

const closeDetail = () => {
    detail.value = null;
    modalDetail.value = false;
};

const removePicture = (index) => {
    form.pictures = Array.from(form.pictures).splice(index, 1);
};
</script>

<template>
    <div class="rounded-lg shadow bg-white mt-4 flex flex-col">
        <div class="flex px-6 py-4 justify-between items-center">
            <div>
                <h3 class="text-base font-semibold leading-7 text-gray-900">
                    Gebäudefotos
                </h3>
                <p class="mt-1 max-w-2xl text-sm leading-tight text-gray-500">
                    Fotos vom Gebäude, Heizungsanlage, etc.
                </p>
            </div>
            <bz-button type="secondary" @click="modal = true"
                >bilder hochladen</bz-button
            >
        </div>
        <div class="border-t border-gray-100">
            <ul
                v-if="
                    building.data.attachments?.filter(
                        (file) => file.data.type === 'picture'
                    ).length > 0
                "
                class="grid p-4 grid-cols-2 gap-x-6 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8"
                role="list">
                <li
                    v-for="file in building.data.attachments?.filter(
                        (file) => file.data.type === 'picture'
                    )"
                    :key="file.data.id"
                    class="relative">
                    <div
                        class="group aspect-h-7 aspect-w-10 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-blue-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                        <img
                            :src="file.links.self"
                            alt=""
                            class="pointer-events-none object-cover group-hover:opacity-75" />
                        <div
                            class="absolute inset-0 flex justify-end p-1 space-x-1">
                            <button
                                class="w-8 h-8 bg-gray-100 text-gray-500 flex items-center justify-center rounded opacity-30 group-hover:opacity-100 hover:bg-white hover:text-gray-900 transition duration-75"
                                @click="handleDetail(file.data.id)">
                                <arrow-top-right-on-square-icon
                                    class="h-4 w-4"
                                    aria-hidden="true" />
                            </button>
                            <button
                                class="w-8 h-8 bg-gray-100 text-gray-500 flex items-center justify-center rounded opacity-30 group-hover:opacity-100 hover:bg-white hover:text-gray-900 transition duration-75"
                                @click="destroy(file.data.id)">
                                <trash-icon
                                    class="h-4 w-4"
                                    aria-hidden="true" />
                            </button>
                        </div>
                    </div>

                    <p
                        class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900">
                        {{ file.title }}
                    </p>
                    <p
                        class="pointer-events-none block text-sm font-medium text-gray-500">
                        {{ file.size }}
                    </p>
                </li>
            </ul>
            <el-empty
                description="Noch keine Fotos vorhanden"
                v-else></el-empty>
        </div>
    </div>
    <dialog-modal
        v-loading="form.processing"
        :show="modal"
        :closeable="true"
        @close="cancel">
        <template #title>Bild hochladen</template>
        <template #content>
            <el-form-item class="!w-full" :error="form.errors.pictures">
                <bz-dropzone
                    multiple
                    class="w-full"
                    v-if="!form.pictures"
                    :allowed-mime-types="[
                        'application/pdf',
                        'image/jpeg',
                        'image/png',
                    ]"
                    @select="(e) => handleSelect(e)"></bz-dropzone>
                <div v-else class="w-full space-y-2">
                    <div
                        v-for="(picture, index) in form.pictures"
                        class="flex w-full items-center px-6 py-4 rounded border border-gray-300 justify-between">
                        <div class="flex">
                            <paper-clip-icon
                                class="h-5 w-5 text-gray-400 mr-2" />
                            <span class="font-semibold text-sm">{{
                                picture.name
                            }}</span>
                        </div>
                        <button type="button" @click="removePicture(index)">
                            <trash-icon class="h-4 w-4 text-red-400 ml-4" />
                        </button>
                    </div>
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

    <dialog-modal :show="modalDetail" :closeable="true" @close="closeDetail">
        <template #title>
            <div class="flex items-center justify-between">
                Detailansicht
                <bz-button type="secondary" @click="closeDetail">
                    <x-mark-icon name="x" class="h-5 w-5 text-gray-400" />
                </bz-button>
            </div>
        </template>
        <template #content>
            <img :src="detail" alt="building_picture" />
        </template>
    </dialog-modal>
</template>
