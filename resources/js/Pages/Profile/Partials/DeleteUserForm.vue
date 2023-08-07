<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import ActionSection from '@/Components/ActionSection.vue';
import DangerButton from '@/Components/DangerButton.vue';
import DialogModal from '@/Components/DialogModal.vue';
import InputError from '@/Components/InputError.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    setTimeout(() => passwordInput.value.focus(), 250);
};

const deleteUser = () => {
    form.delete(route('current-user.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <ActionSection>
        <template #title> Lösche Account</template>

        <template #description> Lösche dein Konto dauerhaft.</template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Sobald Ihr Konto gelöscht ist, werden alle Ressourcen und Daten
                dauerhaft gelöscht. Bevor Sie Ihr Konto löschen, laden Sie bitte
                alle Daten oder Informationen herunter, die Sie behalten
                möchten.
            </div>

            <div class="mt-5">
                <DangerButton @click="confirmUserDeletion">
                    Lösche Account
                </DangerButton>
            </div>

            <!-- Delete Account Confirmation Modal -->
            <DialogModal :show="confirmingUserDeletion" @close="closeModal">
                <template #title> Lösche Account</template>

                <template #content>
                    Sind Sie sicher, dass Sie Ihr Konto löschen möchten? Sobald
                    Ihr Konto gelöscht ist, werden alle Ressourcen und Daten
                    dauerhaft gelöscht. Bitte geben Sie Ihr Passwort ein, um zu
                    bestätigen, dass Sie Ihr Konto dauerhaft löschen möchten.

                    <div class="mt-4">
                        <TextInput
                            ref="passwordInput"
                            v-model="form.password"
                            autocomplete="current-password"
                            class="mt-1 block w-3/4"
                            placeholder="Password"
                            type="password"
                            @keyup.enter="deleteUser" />

                        <InputError
                            :message="form.errors.password"
                            class="mt-2" />
                    </div>
                </template>

                <template #footer>
                    <SecondaryButton @click="closeModal">
                        Abbrechen
                    </SecondaryButton>

                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        class="ml-3"
                        @click="deleteUser">
                        Lösche Account
                    </DangerButton>
                </template>
            </DialogModal>
        </template>
    </ActionSection>
</template>
