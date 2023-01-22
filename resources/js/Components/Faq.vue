<template>
    <section id="faq" class="bg-white">
        <div class="mx-auto max-w-7xl py-16 px-6 sm:py-24 lg:px-8">
            <div class="max-w-2xl lg:mx-auto lg:text-center">
                <h2
                    class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">
                    Häufig gestellte Fragen
                </h2>
                <p class="mt-4 text-gray-500">
                    Die wichtigsten Fragen und Antworten zum Thema
                    Energieausweis, Abwicklung und Funktionsweise von
                    Bauzertifikate.de
                </p>
            </div>
            <div class="mt-20">
                <dl
                    class="space-y-10 lg:grid lg:grid-cols-2 lg:gap-x-8 lg:gap-y-10 lg:space-y-0">
                    <div v-for="faq in faqs" :key="faq.id">
                        <dt class="font-semibold text-gray-900">
                            {{ faq.question }}
                        </dt>
                        <dd class="mt-3 text-gray-500">{{ faq.answer }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>
</template>

<script setup>
const faqs = [
    {
        question: 'Wie lange ist der Energieausweis gültig?',
        answer: 'Ein Energieausweis hat in Deutschland eine Gültigkeit von 10 Jahren. Sollten an dem betreffenden Gebäude Sanierungs- oder Umbaumaßnahmen durchgeführt werden, wird der Energieausweis frühzeitig ungültig und muss erneuert werden, um die aktualisierten Energiedaten des Gebäudes zu reflektieren. Es ist wichtig, die Gültigkeit des Energieausweises regelmäßig zu überprüfen und gegebenenfalls eine Erneuerung in Erwägung zu ziehen, um sicherzustellen, dass der Ausweis immer aktuell ist.',
    },
    {
        question: 'Ist Bauzertifikate.de ein deutsches Unternehmen?',
        answer: 'Bauzertifikate.de ist ein deutsches Unternehmen mit Sitz im idyllischen Schwabenland. Unser Team besteht aus erfahrenen Experten, darunter ein Ingenieur und ein Softwareentwickler, die sich seit Jahren mit dem Thema nachhaltiger Bau auseinandersetzen. Durch unsere Kombination aus Fachwissen und technologischen Kenntnissen sind wir in der Lage, unseren Kunden maßgeschneiderte Lösungen für ihre Anforderungen im Bereich des Energieausweises zu bieten.',
    },
    {
        question: 'Wie lange dauert es bis ich meinen Energieausweis erhalte?',
        answer: 'Wir von "Bauzertifikate" legen großen Wert auf eine zügige Bearbeitung Ihrer Anfragen. Daher überprüfen wir Ihren Energieausweis werktags umgehend. Unsere Kunden erhalten in der Regel ihren Energieausweis noch am selben Tag. In Ausnahmefällen, bei einer hohen Anzahl von Anfragen, kann die Bearbeitungszeit jedoch bis zu 24 Stunden betragen. Bitte beachten Sie, dass eine automatisierte Prüfung des Energieausweises aufgrund der komplexen Anforderungen nicht möglich ist und jeder Ausweis von unseren Experten manuell überprüft werden muss.',
    },
    {
        question: 'Ist der Energieausweis rechtsgültig?',
        answer: 'Alle Produkte von Bauzertifikate.de erfüllen höchste Qualitätsstandards und entsprechen den geltenden rechtlichen Anforderungen. Unsere Experten bei Bauzertifikate.de verfügen über die erforderlichen Zertifizierungen und sind bestens qualifiziert, um Ihnen einen hochwertigen und professionellen Service zu bieten. Wir legen großen Wert auf die ständige Weiterbildung und Schulung unserer Mitarbeiter, um sicherzustellen, dass sie stets auf dem neuesten Stand der Technik und Gesetzgebung sind.',
    },
    {
        question: 'Wie kann ich bezahlen?',
        answer: 'Sie können auf verschiedene Weise bezahlen: PayPal, Kreditkarte, Apple & Google Pay, SOFORT Überweisung, Giropay und Klarna.',
    },
    {
        question: 'Erhalte ich eine Rechnung?',
        answer: 'Sie erhalten eine Rechnung per Email.',
    },
    {
        question: 'Was passiert mit meinen Daten?',
        answer: 'Wir von "Bauzertifikate" verstehen den Wert der Datensicherheit und Privatsphäre unserer Kunden. Daher garantieren wir, dass wir lediglich die Kontaktdaten unserer Kunden speichern, um sie bezüglich ihres Energieausweises kontaktieren zu können. Zudem speichern wir die Daten zum Gebäude und den Energieausweis, um unseren Kunden eine schnelle und problemlose Abrufmöglichkeit des Ausweises zu gewährleisten. Sollten unsere Kunden jedoch keine Speicherung ihrer Daten wünschen, kann diese nach Abschluss des Auftrags einfach und unkompliziert gelöscht werden. Wir stehen Ihnen jederzeit für Rückfragen und Anliegen zur Verfügung.',
    },
    {
        question: 'Ich habe meinen Energieausweis verloren, was nun?',
        answer: 'Ein wichtiges Alleinstellungsmerkmal von Bauzertifikate ist unser innovativer Service "Find my Energieausweis". Dieser ermöglicht es unseren Kunden, ihren Energieausweis jederzeit und unabhängig von der Bestellnummer einfach und bequem über unsere Plattform abzurufen. Damit sind unsere Kunden vor dem Verlust des wichtigen Dokuments geschützt und haben stets Zugriff auf ihren Energieausweis.',
    },
];
</script>
