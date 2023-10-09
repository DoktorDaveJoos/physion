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
