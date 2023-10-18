<template>
    <GuestLayout>
        <div class="bg-white">
            <div class="mx-auto max-w-7xl pt-12 px-6 lg:px-8 lg:pt-24">
                <div
                    class="space-y-12 lg:grid lg:grid-cols-3 lg:gap-8 lg:space-y-0">
                    <div class="space-y-5 sm:space-y-4">
                        <h2
                            class="text-3xl font-bold tracking-tight sm:text-4xl">
                            Die Gründer
                        </h2>
                        <p class="text-xl text-gray-500">
                            Die beiden Gründer, die sich seit vielen Jahren
                            kennen und auch durch Freundschaft verbunden sind,
                            haben ihre jeweiligen Kompetenzen kombiniert, um
                            ihre gemeinsame Leidenschaft für Nachhaltigkeit auf
                            ihre eigene Art und Weise zu unterstützen.
                        </p>
                    </div>
                    <div class="lg:col-span-2">
                        <ul
                            role="list"
                            class="space-y-12 sm:grid sm:grid-cols-2 sm:gap-x-6 sm:gap-y-12 sm:space-y-0 lg:gap-x-8">
                            <li v-for="person in people" :key="person.name">
                                <div class="space-y-4">
                                    <div class="aspect-w-3 aspect-h-2">
                                        <img
                                            class="rounded-lg object-cover shadow-lg"
                                            :src="person.imageUrl"
                                            alt="" />
                                    </div>
                                    <div
                                        class="space-y-1 text-lg font-medium leading-6">
                                        <h3>{{ person.name }}</h3>
                                        <p class="text-primary">
                                            {{ person.role }}
                                        </p>
                                    </div>
                                    <div class="text-lg">
                                        <p class="text-gray-500">
                                            {{ person.bio }}
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div
            class="overflow-hidden bg-white py-16 px-6 lg:px-8 xl:pt-16 xl:pb-36">
            <div class="mx-auto max-w-max lg:max-w-7xl">
                <div class="relative z-10 mb-8 md:mb-2 md:px-6">
                    <div class="max-w-prose text-base lg:max-w-none">
                        <p
                            class="mt-2 text-3xl font-bold leading-8 tracking-tight text-gray-900 sm:text-4xl">
                            Das Unternehmen
                        </p>
                    </div>
                </div>
                <div class="relative">
                    <svg
                        class="absolute top-0 right-0 -mt-20 -mr-20 hidden md:block md:[overflow-anchor:none]"
                        width="404"
                        height="384"
                        fill="none"
                        viewBox="0 0 404 384"
                        aria-hidden="true">
                        <defs>
                            <pattern
                                id="95e8f2de-6d30-4b7e-8159-f791729db21b"
                                x="0"
                                y="0"
                                width="20"
                                height="20"
                                patternUnits="userSpaceOnUse">
                                <rect
                                    x="0"
                                    y="0"
                                    width="4"
                                    height="4"
                                    class="text-gray-200"
                                    fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect
                            width="404"
                            height="384"
                            fill="url(#95e8f2de-6d30-4b7e-8159-f791729db21b)" />
                    </svg>
                    <svg
                        class="absolute bottom-0 left-0 -mb-20 -ml-20 hidden md:block md:[overflow-anchor:none]"
                        width="404"
                        height="384"
                        fill="none"
                        viewBox="0 0 404 384"
                        aria-hidden="true">
                        <defs>
                            <pattern
                                id="7a00fe67-0343-4a3c-8e81-c145097a3ce0"
                                x="0"
                                y="0"
                                width="20"
                                height="20"
                                patternUnits="userSpaceOnUse">
                                <rect
                                    x="0"
                                    y="0"
                                    width="4"
                                    height="4"
                                    class="text-gray-200"
                                    fill="currentColor" />
                            </pattern>
                        </defs>
                        <rect
                            width="404"
                            height="384"
                            fill="url(#7a00fe67-0343-4a3c-8e81-c145097a3ce0)" />
                    </svg>
                    <div class="relative md:bg-white md:p-6">
                        <div class="lg:grid lg:grid-cols-2 lg:gap-6">
                            <div
                                class="prose prose-lg prose-blue text-gray-500 lg:max-w-none">
                                <p>
                                    Die Idee hinter Bauzertifikate ist es, die
                                    Förderung des nachhaltigen Bauens durch
                                    unsere Zertifikate zu unterstützen und
                                    gleichzeitig den Prozess digital zu
                                    vereinfachen. Der Energieausweis und das
                                    BIRN Zertifikat sind hervorragende Konzepte,
                                    die jedoch oft mit vielen Hürden und
                                    Schwierigkeiten verbunden sind. Von der
                                    Antragsstellung bis hin zur Erfassung und
                                    Messung der erforderlichen Daten - der
                                    Prozess kann kompliziert sein. Wir möchten
                                    dies ändern und den Kunden eine einfache und
                                    unkomplizierte Erfahrung bieten, indem wir
                                    alle Komplexitäten wegnehmen.
                                </p>
                                <p>
                                    Unsere Leidenschaft für den nachhaltigen Bau
                                    begann bereits während des Studiums, als die
                                    beiden Gründer in einer Vorlesung zum Thema
                                    Nachhaltigkeit fasziniert waren von den
                                    Möglichkeiten. Sie sind erfreut über die
                                    aktuelle Entwicklung der Förderung wirklich
                                    nachhaltiger Gebäude durch das BIRN
                                    Zertifizierungsverfahren. Hannes hat sich
                                    früh in seiner Karriere auf die
                                    Energieberatung spezialisiert und die
                                    Schwächen des Prozesses erkannt. Zusammen
                                    mit David, dem leidenschaftlichen
                                    Softwareentwickler, entstand die Vision
                                    einer einfachen und modernen Plattform.
                                </p>
                            </div>
                            <div
                                class="prose prose-lg prose-blue mt-6 text-gray-500 lg:mt-0">
                                <p>
                                    Mit unserer Erfahrung, unserer Leidenschaft
                                    und unserer technischen Kompetenz sind wir
                                    bestrebt, unseren Kunden eine unkomplizierte
                                    und erfolgreiche Erfahrung im Umgang mit
                                    Energieausweisen und BIRN Zertifikaten zu
                                    bieten.
                                </p>
                                <p>
                                    Unsere Vision ist es, die Art und Weise, wie
                                    Gebäudeenergiezertifizierungen durchgeführt
                                    werden, zu revolutionieren und dabei die
                                    Umwelt, die Gesellschaft und die Wirtschaft
                                    gleichermaßen zu unterstützen. Wir arbeiten
                                    ständig daran, unsere Plattform und unsere
                                    Dienstleistungen zu verbessern, um diesem
                                    Ziel immer näher zu kommen. Wir sind stolz
                                    darauf, ein zuverlässiger und
                                    vertrauenswürdiger Partner für unsere Kunden
                                    zu sein und sie bei der Erreichung ihrer
                                    Ziele zu unterstützen.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </GuestLayout>
</template>

<script setup>
import GuestLayout from '../../Layouts/GuestLayout.vue';

const people = [
    {
        name: 'Hannes Jungert',
        role: 'Geschäftsführer',
        imageUrl: '/hannes-blog.png',
        bio: 'Ingenieur, zertifiziert als Energieberater und BIRN-Auditor, übernimmt die operative Umsetzung unserer Projekte.',
        twitterUrl: '#',
        linkedinUrl: '#',
    },
    {
        name: 'David Joos',
        role: 'Geschäftsführer',
        imageUrl: '/david.png',
        bio: 'Softwareentwickler mit technischer Expertise übernimmt die Verantwortung für die Umsetzung und Optimierung unserer technischen Projekte.',
        twitterUrl: '#',
        linkedinUrl: '#',
    },
    // More people...
];
</script>
