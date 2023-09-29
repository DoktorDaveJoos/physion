<script setup>
import { computed, ref } from 'vue';
import { ElNotification } from 'element-plus';
import { PhotoIcon, TrashIcon } from '@heroicons/vue/24/outline';
import BzButton from './BzButton.vue';

const emits = defineEmits(['select', 'delete']);

const props = defineProps({
    selected: {
        type: String,
        default: () => null,
    },
    allowedMimeTypes: {
        type: Array,
        default: () => [],
    },
    loading: {
        type: Boolean,
        default: false,
    },
});

const dragging = ref(false);

const handleFileUpload = (event) => {
    processFile(event.dataTransfer?.files[0]);
};

const selectFile = (event) => {
    processFile(event.target.files[0]);
};

const processFile = (file) => {
    if (!file) {
        return;
    }

    if (!props.allowedMimeTypes.includes(file.type)) {
        ElNotification({
            title: 'Falscher Dateityp',
            message:
                'Bitte wählen Sie eine Datei mit einem der folgenden Dateitypen: ' +
                props.allowedMimeTypes
                    .map((mime) => mime.split('/')[1])
                    .join(', '),
            type: 'error',
        });
        return;
    }

    emits('select', file);
};
</script>

<template>
    <div
        v-loading="loading"
        v-if="!selected"
        @dragenter.prevent="dragging = true"
        @dragleave.prevent="dragging = false"
        @dragover.prevent="dragging = true"
        @drop.prevent="
            dragging = false;
            handleFileUpload($event);
        "
        class="col-span-2 flex justify-center rounded-lg border border-dashed transition duration-75 px-6 py-8 group"
        :class="dragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">
        <div class="text-center">
            <PhotoIcon
                class="mx-auto h-10 w-10 transition duration-75"
                :class="[dragging ? 'text-blue-500' : 'text-gray-300']"
                aria-hidden="true" />
            <div class="mt-4 flex text-sm leading-6 text-gray-600">
                <label
                    for="file-upload"
                    class="relative cursor-pointer rounded-md bg-transparent font-semibold text-blue-600 hover:text-blue-500">
                    <span>Bild hochladen</span>
                    <input
                        id="file-upload"
                        name="file-upload"
                        type="file"
                        class="sr-only"
                        @change="selectFile" />
                </label>
                <p class="pl-1">oder per drag & drop</p>
            </div>
            <p class="text-xs leading-5 text-gray-600">
                <span class="uppercase">{{
                    allowedMimeTypes.map((mime) => mime.split('/')[1]).join(',')
                }}</span>
                bis zu 10MB
            </p>
        </div>
    </div>
    <div
        v-else
        v-loading="loading"
        class="col-span-2 flex justify-between items-center">
        <img
            class="inline-block h-24 w-24 rounded-md shadow"
            :src="selected"
            alt="building_picture" />
        <bz-button
            plain
            type="secondary"
            class="mr-2 group"
            @click="$emit('delete')">
            <trash-icon
                class="h-4 w-4 text-red-500 group-hover:text-red-800"
                aria-hidden="true" />
        </bz-button>
    </div>
</template>
