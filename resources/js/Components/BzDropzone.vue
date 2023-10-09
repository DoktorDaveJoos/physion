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
    multiple: {
        type: Boolean,
        default: false,
    },
    text: {
        type: String,
        default: 'Bild hochladen',
    },
});

const dragging = ref(false);

const handleFileUpload = (event) => {
    if (event.dataTransfer?.files.length > 1 && !props.multiple) {
        ElNotification({
            title: 'Mehrere Dateien ausgewählt',
            message: 'Bitte wählen Sie nur eine Datei aus.',
            type: 'error',
        });
        return;
    }

    processFile(event.dataTransfer?.files);
};

const selectFile = (event) => {
    processFile(event.target.files);
};

const processFile = (files) => {
    if (!files || files.length === 0) {
        return;
    }
    try {
        Array.from(files).forEach((file) => {
            if (!props.allowedMimeTypes.includes(file.type)) {
                throw 'Falscher Dateityp';
            }
        });
        emits('select', props.multiple ? files : files[0]);
    } catch (e) {
        ElNotification({
            title: 'Falscher Dateityp',
            message:
                'Bitte wählen Sie eine Datei mit einem der folgenden Dateitypen: ' +
                props.allowedMimeTypes
                    .map((mime) => mime.split('/')[1])
                    .join(', '),
            type: 'error',
        });
    }
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
        class="col-span-2 flex justify-center rounded-lg border-2 border-dashed transition duration-75 px-6 py-8 group"
        :class="dragging ? 'border-blue-500 bg-blue-50' : 'border-gray-300'">
        <div class="text-center">
            <PhotoIcon
                class="mx-auto h-10 w-10 transition duration-75"
                :class="[dragging ? 'text-blue-500' : 'text-gray-300']"
                aria-hidden="true" />
            <div class="mt-4 flex text-sm leading-6 text-gray-500">
                <label
                    for="file-upload"
                    class="relative cursor-pointer rounded-md bg-transparent font-bold text-blue-600 hover:text-blue-500">
                    <slot name="text">{{ text }}</slot>
                    <input
                        id="file-upload"
                        name="file-upload"
                        type="file"
                        class="sr-only"
                        @change="selectFile" />
                </label>
                <p class="pl-1">oder per drag & drop</p>
            </div>
            <p class="text-xs leading-5 text-gray-500 font-bold">
                <span class="uppercase">{{
                    allowedMimeTypes.map((mime) => mime.split('/')[1]).join(',')
                }}</span>
                bis zu 10MB
            </p>
            <slot name="template"></slot>
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
