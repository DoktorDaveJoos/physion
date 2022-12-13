<script>
import AppLayout from '../../Layouts/AppLayout.vue';
import SideNavWrapper from '../../Wrappers/SideNavWrapper.vue';
import {reactive, ref} from 'vue';

const value = ref('');

const options = [
    {
        value: 'Option1',
        label: 'Option1',
    },
    {
        value: 'Option2',
        label: 'Option2',
    },
    {
        value: 'Option3',
        label: 'Option3',
    },
    {
        value: 'Option4',
        label: 'Option4',
    },
    {
        value: 'Option5',
        label: 'Option5',
    },
];

export default {
    components: {SideNavWrapper},
    // Using the shorthand
    layout: [AppLayout],

    props: {
        subtitle: Object,
    },

    setup() {

        const form = reactive({
            last_name: null,
            email: null,
        });

        function submit() {
            Inertia.post('/users', form);
        }

        const value = ref('');

        const options = [
            {
                value: 'freistehend',
                label: 'Freistehend',
            },
            {
                value: 'doppelhaushälfte',
                label: 'Doppelhaushälfte',
            },
            {
                value: 'reihenmittelhaus',
                label: 'Reihenmittelhaus',
            },
            {
                value: 'reiheneckhaus',
                label: 'Reiheneckhaus',
            },
        ];

        return {options, value, form, submit};
    },
};
</script>

<template>
    <SideNavWrapper>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <form action="#" method="POST">
                <div class="shadow sm:overflow-hidden sm:rounded-md">
                    <div class="space-y-6 bg-white py-6 px-4 sm:p-6">

                        <h3 class="text-lg font-medium leading-6 text-gray-900">{{ subtitle }}</h3>

                        <div class="grid grid-cols-4 gap-6">
                            <div class="sm:col-span-2">
                                <label for="email-address"
                                       class="block text-sm font-medium text-gray-700">Email</label>
                                <el-input
                                    v-model="form.email"
                                    class="mt-1"
                                    size="large"
                                    placeholder="max.mustermann@email.de"
                                />
                            </div>

                            <div></div>
                            <div></div>

                            <div class="sm:col-span-1">
                                <label for="email-address"
                                       class="block text-sm font-medium text-gray-700">Haustyp</label>
                                <el-select v-model="value" class="mt-1" placeholder="Typ" size="large">
                                    <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    />
                                </el-select>
                            </div>
                            <div class="sm:col-span-1">
                                <label for="email-address"
                                       class="block text-sm font-medium text-gray-700">Bauart</label>
                                <el-select v-model="value" class="mt-1 w-full" placeholder="Art" size="large">
                                    <el-option
                                        v-for="item in options"
                                        :key="item.value"
                                        :label="item.label"
                                        :value="item.value"
                                    />
                                </el-select>
                            </div>

                            <div></div>

                            <div class="col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Cover photo</label>
                                <el-upload
                                    class="upload-demo"
                                    drag
                                    action="https://run.mocky.io/v3/9d059bf9-4660-45f2-925d-ce80ad6c4d15"
                                    multiple
                                >
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                         viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>

                                    <div class="el-upload__text">
                                        Drop file here or <em>click to upload</em>
                                    </div>
                                    <template #tip>
                                        <div class="el-upload__tip">
                                            jpg/png files with a size less than 500kb
                                        </div>
                                    </template>
                                </el-upload>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 text-right sm:px-6">
                        <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>


    </SideNavWrapper>
</template>
