import dayjs from 'dayjs';

export const zielzustand = {
    'EH 40': {
        key: 'EH 40',
        zuschuss: 0.2,
        max: 120_000,
    },
    'EH 40 EE': {
        key: 'EH 40 EE',
        zuschuss: 0.25,
        max: 150_000,
    },
    'EH 55': {
        key: 'EH 55',
        zuschuss: 0.15,
        max: 120_000,
    },
    'EH 55 EE': {
        key: 'EH 55 EE',
        zuschuss: 0.2,
        max: 150_000,
    },
    'EH 70': {
        key: 'EH 70',
        zuschuss: 0.1,
        max: 120_000,
    },
    'EH 70 EE': {
        key: 'EH 70 EE',
        zuschuss: 0.15,
        max: 150_000,
    },
    'EH 85': {
        key: 'EH 85',
        zuschuss: 0.05,
        max: 120_000,
    },
    'EH 85 EE': {
        key: 'EH 85 EE',
        zuschuss: 0.1,
        max: 150_000,
    },
    'EH Denkmal': {
        key: 'EH Denkmal',
        zuschuss: 0.05,
        max: 120_000,
    },
    'EH Denkmal EE': {
        key: 'EH Denkmal EE',
        zuschuss: 0.1,
        max: 150_000,
    },
};

const familyCredit = [
    {
        kids: 1,
        maxSalary: 90_000,
        summe: 170_000,
    },
    {
        kids: 2,
        maxSalary: 100_000,
        summe: 170_000,
    },
    {
        kids: 3,
        maxSalary: 110_000,
        summe: 200_000,
    },
    {
        kids: 4,
        maxSalary: 120_000,
        summe: 200_000,
    },
    {
        kids: 5,
        maxSalary: 130_000,
        summe: 270_000,
    },
    {
        kids: 6,
        maxSalary: 140_000,
        summe: 270_000,
    },
    {
        kids: 7,
        maxSalary: 150_000,
        summe: 270_000,
    },
    {
        kids: 8,
        maxSalary: 160_000,
        summe: 270_000,
    },
    {
        kids: 9,
        maxSalary: 170_000,
        summe: 270_000,
    },
];

export const getValue = (eh) => {
    return zielzustand[eh] ?? zielzustand['EH Denkmal'];
};

export const sanierung = (target, energyClass, housingUnits) => {
    const summary = {
        programs: [
            {
                key: '261',
                summe: getValue(target).max * housingUnits,
                link: 'https://www.kfw.de/inlandsfoerderung/Privatpersonen/Bestehende-Immobilie/F%C3%B6rderprodukte/Bundesf%C3%B6rderung-f%C3%BCr-effiziente-Geb%C3%A4ude-Wohngeb%C3%A4ude-Kredit-(261-262)/',
                zins: '0,47',
                conditions: [
                    {
                        zins: '0,47',
                        laufzeit: '4-10 Jahre',
                        zinsbindung: '10 Jahre',
                        tilgungsfrei: '1-2 Jahre',
                    },
                    {
                        zins: '1,58',
                        laufzeit: '11-20 Jahre',
                        zinsbindung: '10 Jahre',
                        tilgungsfrei: '1-3 Jahre',
                    },
                    {
                        zins: '1,86',
                        laufzeit: '21-30 Jahre',
                        zinsbindung: '10 Jahre',
                        tilgungsfrei: '1-5 Jahre',
                    },
                ],
            },
            {
                key: '124',
                summe: 100_000,
                link: 'https://www.kfw.de/inlandsfoerderung/Privatpersonen/Bestandsimmobilien/Finanzierungsangebote/Wohneigentumsprogramm-(124)/',
                zins: '4,29',
                conditions: [
                    {
                        zins: '4,29',
                        laufzeit: '4-25 Jahre',
                        zinsbindung: '5 Jahre',
                        tilgungsfrei: '1-3 Jahre',
                    },
                    {
                        zins: '4,32',
                        laufzeit: '4-25 Jahre',
                        zinsbindung: '10 Jahre',
                        tilgungsfrei: '1-3 Jahre',
                    },
                    {
                        zins: '4,29',
                        laufzeit: '26-35 Jahre',
                        zinsbindung: '5 Jahre',
                        tilgungsfrei: '1-5 Jahre',
                    },
                    {
                        zins: '4,33',
                        laufzeit: '26-35 Jahre',
                        zinsbindung: '10 Jahre',
                        tilgungsfrei: '1-5 Jahre',
                    },
                ],
            },
        ],
        grants: [
            {
                tag: target ?? 'EH Denkmal',
                zuschuss: getValue(target).zuschuss,
                summe:
                    getValue(target).max *
                    housingUnits *
                    getValue(target).zuschuss,
            },
        ],
    };

    if (energyClass === 'H') {
        summary.grants.push({
            tag: 'worst performing building',
            zuschuss: 0.1,
            summe: (getValue(target).max * housingUnits + 100_000) * 0.1,
        });
    }

    return summary;
};

export const neubau = (
    hasBuilding,
    salary,
    kids,
    eh,
    lh,
    qng,
    housingUnits
) => {
    const summary = {
        programs: [],
        grants: [],
    };

    summary.programs.push(get124());

    if (hasBuilding && eh && (lh || qng)) {
        summary.programs.push(get297(qng, housingUnits));
    } else if (!hasBuilding && eh && (lh || qng) && kids > 0) {
        const availableCombinations = familyCredit
            .filter((entry) => entry.maxSalary >= salary)
            .filter((entry) => entry.kids <= kids);

        const combination =
            availableCombinations.length > 0
                ? availableCombinations.reduce((acc, cur) => {
                      if (!acc) {
                          acc = cur;
                          return acc;
                      }

                      if (cur.maxSalary > acc.maxSalary) {
                          acc = cur;
                          return acc;
                      }

                      return acc;
                  })
                : null;

        if (combination) {
            summary.programs.push(get300(combination.summe));
        } else {
            summary.programs.push(get297(qng, housingUnits));
        }
    } else if (!hasBuilding && eh && (lh || qng)) {
        summary.programs.push(get297(qng, housingUnits));
    }
    return summary;
};

const get124 = () => ({
    key: '124',
    summe: 100_000,
    link: 'https://www.kfw.de/inlandsfoerderung/Privatpersonen/Bestandsimmobilien/Finanzierungsangebote/Wohneigentumsprogramm-(124)/',
    zins: '4,29',
    conditions: [
        {
            zins: '4,29',
            laufzeit: '4-25 Jahre',
            zinsbindung: '5 Jahre',
            tilgungsfrei: '1-3 Jahre',
        },
        {
            zins: '4,32',
            laufzeit: '4-25 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-3 Jahre',
        },
        {
            zins: '4,29',
            laufzeit: '26-35 Jahre',
            zinsbindung: '5 Jahre',
            tilgungsfrei: '1-5 Jahre',
        },
        {
            zins: '4,33',
            laufzeit: '26-35 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-5 Jahre',
        },
    ],
});

const get261 = (target, housingUnits) => ({
    key: '261',
    summe: getValue(target).max * housingUnits,
    link: 'https://www.kfw.de/inlandsfoerderung/Privatpersonen/Bestehende-Immobilie/F%C3%B6rderprodukte/Bundesf%C3%B6rderung-f%C3%BCr-effiziente-Geb%C3%A4ude-Wohngeb%C3%A4ude-Kredit-(261-262)/',
    zins: '0,47',
    conditions: [
        {
            zins: '0,47',
            laufzeit: '4-10 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-2 Jahre',
        },
        {
            zins: '1,58',
            laufzeit: '11-20 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-3 Jahre',
        },
        {
            zins: '1,86',
            laufzeit: '21-30 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-5 Jahre',
        },
    ],
});

const get297 = (qng, housingUnits) => ({
    key: '297',
    summe: (qng ? 150_000 : 100_000) * housingUnits,
    link: 'https://www.kfw.de/inlandsfoerderung/Privatpersonen/Neubau/F%C3%B6rderprodukte/Klimafreundlicher-Neubau-Wohngeb%C3%A4ude-(297-298)/',
    zins: '0,1',
    conditions: [
        {
            zins: '0,1',
            laufzeit: '4-10 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-2 Jahre',
        },
        {
            zins: '0,99',
            laufzeit: '11-20 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-3 Jahre',
        },
        {
            zins: '1,23',
            laufzeit: '21-30 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-5 Jahre',
        },
    ],
});

const get300 = (summe) => ({
    key: '300',
    summe: summe,
    link: 'https://www.kfw.de/inlandsfoerderung/Privatpersonen/Neubau/F%C3%B6rderprodukte/Wohneigentum-f%C3%BCr-Familien-(300)/',
    zins: '0,1',
    conditions: [
        {
            zins: '0,1',
            laufzeit: '4-10 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-2 Jahre',
        },
        {
            zins: '0,99',
            laufzeit: '11-20 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-3 Jahre',
        },
        {
            zins: '1,23',
            laufzeit: '21-30 Jahre',
            zinsbindung: '10 Jahre',
            tilgungsfrei: '1-5 Jahre',
        },
    ],
});

/**
 * Fenster immer 30-50k
 *
 * Sagen wir ein Dach 80-100k
 *
 * Heizung WP 45k
 *
 * Haustüre 8k
 *
 * Kellerdecke 15k
 *
 * PV 20k
 */

export const heating = [
    {
        id: 1,
        name: 'Einbau Wärmepumpe',
        description: 'Alternativ auch EE-Hybridheizung (auch mit Biomasse)',
        price: 45_000,
        percent: [0.3],
        grant: null,
    },
    {
        id: 2,
        name: 'Einbau Biomasse Heizung',
        description: 'Stückgut, Hackschnitzel oder Pelletheizung',
        price: 55_000,
        percent: [0.1],
        grant: null,
    },
    {
        id: 3,
        name: 'Solarthermie',
        description: 'Einbau einer Solarthermie Anlage',
        price: 30_000,
        percent: [0.25],
        grant: null,
    },
    {
        id: 4,
        name: 'Heizungsoptimierung',
        description: 'Optimierung der bestehenden Anlage',
        price: 10_000,
        percent: [0.15],
        grant: null,
    },
];

const envelope = [
    {
        id: 1,
        name: 'Fassade',
        description: 'Fassadendämmung',
        price: 40_000,
        percent: [0.15],
        grant: null,
    },
    {
        id: 3,
        name: 'Dach',
        description: 'Isolierung des Dachs',
        price: 90_000,
        percent: [0.15],
        grant: null,
    },
    {
        id: 3,
        name: 'Keller',
        description: 'Isolierung Kellerdecke',
        price: 15_000,
        percent: [0.15],
        grant: null,
    },
    {
        id: 2,
        name: 'Fenstertausch',
        description: 'Auswechseln der Fenster',
        price: 35_000,
        percent: [0.15],
        grant: null,
    },
    {
        id: 4,
        name: 'Haustüre',
        description: 'Austausch der Haustüre',
        price: 8_000,
        percent: [0.15],
        grant: null,
    },
    {
        id: 4,
        name: 'Sonnenschutz',
        description: 'Einbau passender Fenster und Beschattung',
        price: 15_000,
        percent: [0.15],
        grant: null,
    },
];

const system = [
    {
        id: 1,
        name: 'Lüftung',
        description: 'Einbau eines Lüftungssystems für gut isolierte Gebäude',
        price: 15_000,
        percent: [0.15],
        grant: null,
    },
    {
        id: 2,
        name: 'Smart Home',
        description: 'Einbau smarter Technologie zum Ressourcen einsparen',
        price: 50_000,
        percent: [0.15],
        grant: null,
    },
];

const consulting = [
    {
        id: 1,
        name: 'Energieberatung',
        description: 'Erstellung eines Sanierungsfahrplans plus Beratung',
        price: 1_600,
        percent: [0.8],
        grant: null,
    },
    {
        id: 2,
        name: 'Fachplanung/Baubegleitung',
        description: 'Sämtliche ',
        price: 10_000,
        percent: [0.5],
        grant: null,
    },
];

export const filterActions = (
    constructionYear,
    ventilation,
    heatingSystems,
    renewables,
    hasIsfp,
    energyCertificateRating
) => {
    const summary = {
        heating: [],
        envelope: [],
        system: [],
        consulting: [],
    };

    // Heizungssysteme
    if (
        heatingSystems.find(
            (system) =>
                system.type === 'Ölheizung' || system.type === 'Gasheizung'
        )
    ) {
        // push Wärmepumpe and EE Hybridheizung
        summary.heating = structuredClone(
            heating.filter((heating) => heating.id === 1 || heating.id === 2)
        );
    } else if (heatingSystems.find((system) => system.type === 'Holzheizung')) {
        summary.heating.push(heating.find((heating) => heating.id === 1));
    }

    if (!renewables.find((renewable) => renewable.type === 'Solarthermie')) {
        summary.heating.push(heating.find((heating) => heating.id === 3));
    }
    // Optimierung immer anbieten
    summary.heating.push(
        structuredClone(heating.find((heating) => heating.id === 4))
    );

    // Gebäudehülle
    if (dayjs().year() - constructionYear >= 10) {
        summary.envelope = structuredClone(envelope);
    }

    // Anlagentechnik
    if (ventilation === 'Fensterlüftung' || ventilation === 'Schachtlüftung') {
        summary.system = structuredClone(system);
    } else {
        summary.system.push(system.find((system) => system.id === 2));
    }

    // Energieberatung
    if (!hasIsfp) {
        summary.consulting = consulting;
    } else {
        summary.consulting.push(consulting.find((entry) => entry.id === 2));
    }

    // iSFP 5 %
    if (hasIsfp) {
        summary.envelope.map((entry) => entry.percent.push(0.05));
        summary.heating.map((entry) => {
            if (entry.id === 4) {
                entry.percent.push(0.05);
            }
            return entry;
        });
    }

    // Heizungstausch 10 %
    if (
        heatingSystems.find(
            (system) =>
                system.type === 'Ölheizung' || system.type === 'Gasheizung'
        )
    ) {
        console.log('ADDING');
        summary.heating.map((entry) => {
            if (entry.id !== 4 && entry.id !== 3) {
                entry.percent.push(0.1);
            }
            return entry;
        });
    }

    // Compute grants
    summary.heating?.map(
        (entry) =>
            (entry.grant =
                entry.price * entry.percent.reduce((a, b) => a + b, 0))
    );
    summary.envelope?.map(
        (entry) =>
            (entry.grant =
                entry.price * entry.percent.reduce((a, b) => a + b, 0))
    );
    summary.system?.map(
        (entry) =>
            (entry.grant =
                entry.price * entry.percent.reduce((a, b) => a + b, 0))
    );
    summary.consulting?.map(
        (entry) =>
            (entry.grant =
                entry.price * entry.percent.reduce((a, b) => a + b, 0))
    );

    return summary;
};
