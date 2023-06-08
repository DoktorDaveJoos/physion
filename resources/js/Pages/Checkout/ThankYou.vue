<template>
    <div class="bg-white">
        <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 sm:py-24 lg:px-8">
            <div class="max-w-xl">
                <h1 class="text-base font-medium text-blue-600">
                    Danke schön!
                </h1>
                <p class="mt-2 text-4xl font-bold tracking-tight sm:text-5xl">
                    Auftrag in Bearbeitung!
                </p>
                <p class="mt-2 text-base text-gray-500">
                    Wir haben deinen Auftrag erfolgreich erhalten.
                </p>

                <p class="mt-10 text-base text-gray-900 font-semibold">
                    Wie gehts weiter?
                </p>
                <p class="mt-1 text-gray-600">
                    In Kürze erhältst du zwei wichtige E-Mails von uns: eine
                    Auftragsbestätigung sowie einen Zahlungsbeleg. Zusätzlich
                    hast du jederzeit Zugriff auf den aktuellen
                    Bearbeitungsstand deines Ausweises. Um deinen Ausweis
                    mühelos wiederzufinden, haben wir dir bereits eine E-Mail
                    mit einem Link zu deinem Ausweis und der Ausweis-ID
                    zugesendet. Darüber hinaus kannst du jederzeit unseren "Find
                    my Ausweis"-Service nutzen, indem du einfach deine
                    E-Mail-Adresse eingibst. Wir senden dir dann sämtliche Links
                    zu deinen erstellten Ausweisen. Wir freuen uns sehr, dass du
                    dich für unsere Dienstleistungen entschieden hast und heißen
                    dich herzlich als unseren geschätzten Kunden willkommen!
                </p>
            </div>

            <div class="mt-10 border-t border-gray-200 py-6 flex justify-end">
                <bz-button as="link" :href="link"> Auftrag anzeigen </bz-button>
            </div>
        </div>
    </div>
</template>

<script setup>
import BzButton from '../../Components/BzButton.vue';

defineProps({
    link: String,
});
</script>
