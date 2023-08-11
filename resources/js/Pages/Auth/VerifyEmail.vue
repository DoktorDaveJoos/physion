<script setup>
import { computed } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import AuthenticationCardLogo from '@/Components/AuthenticationCardLogo.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import ApplicationMark from '../../Components/ApplicationMark.vue';

const props = defineProps({
    status: String,
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent'
);
</script>

<template>
    <Head title="Email Bestätigen" />

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
            Bevor du fortfährst, könntest du bitte deine E-Mail-Adresse
            überprüfen, indem du auf den Link klickst, den wir dir gerade per
            E-Mail geschickt haben? Falls du die E-Mail nicht erhalten hast,
            senden wir dir gerne eine weitere.
        </div>

        <div
            v-if="verificationLinkSent"
            class="mb-4 font-medium text-sm text-green-600">
            Ein neuer Bestätigungslink wurde an die E-Mail-Adresse gesendet, die
            du in deinen Profileinstellungen angegeben hast.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing">
                    E-Mail erneut senden
                </PrimaryButton>

                <div>
                    <Link
                        :href="route('profile.show')"
                        class="underline text-sm text-gray-600 hover:text-gray-900">
                        Profil bearbeiten</Link
                    >

                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 hover:text-gray-900 ml-2">
                        Log out
                    </Link>
                </div>
            </div>
        </form>
    </AuthenticationCard>
</template>
