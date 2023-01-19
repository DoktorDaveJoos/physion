<script>
import GuestLayout from '../../Layouts/GuestLayout.vue';
import StepperWrapper from '../../Wrappers/StepperWrapper.vue';
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
    // Using the shorthand
    layout: [GuestLayout],
    components: {
        StepperWrapper,
    },

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
        test
    </StepperWrapper>





</template>
