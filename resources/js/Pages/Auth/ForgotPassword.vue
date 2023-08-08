<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import ApplicationMark from '../../Components/ApplicationMark.vue';

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <Head title="Passwort vergessen" />

    <AuthenticationCard>
        <template #logo>
            <ApplicationMark />
        </template>

        <template #header>
            <h1
                class="font-black font-display tracking-tight text-3xl text-gray-900 mt-4">
                EnergieHub
            </h1>
            <p class="text-gray-500 text-center">by bauzertifikate.de</p>
        </template>

        <div class="mb-4 text-sm text-gray-600">
            Passwort vergessen? Kein Problem. Gib uns einfach deine
            E-Mail-Adresse bekannt, und wir senden dir einen Link zur
            Zurücksetzung des Passworts. Damit kannst du ein neues Passwort
            wählen.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    v-model="form.email"
                    autocomplete="username"
                    autofocus
                    class="mt-1 block w-full"
                    required
                    type="email" />
                <InputError :message="form.errors.email" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    Passwort zurücksetzen
                </PrimaryButton>
            </div>
        </form>
    </AuthenticationCard>
</template>
