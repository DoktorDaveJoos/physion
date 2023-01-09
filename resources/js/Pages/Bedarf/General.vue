<script>
import AppLayout from '../../Layouts/GuestLayout.vue';
import {reactive, ref} from 'vue';
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';

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
    components: {StepperWrapper},
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
    <StepperWrapper>

        <div class="space-y-6 sm:px-6 lg:col-span-9 lg:px-0">
            <form @submit.prevent="">
                <div class="shadow sm:overflow-hidden sm:rounded-md">

                    <div class="space-y-6 bg-white py-6 px-4 sm:p-6">
                    Test
                    </div>

                    <div class="bg-slate-50 px-4 py-3 text-right sm:px-6">
                        <button type="submit"
                                class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Save
                        </button>
                    </div>
                </div>
            </form>
        </div>


    </StepperWrapper>
</template>
