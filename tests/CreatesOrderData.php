<?php

declare(strict_types=1);

namespace Tests;

trait CreatesOrderData
{

    protected array $payload = [];

    public function basePayload($type = "verbrauchsausweis"): static
    {
        $this->payload["type"] = $type;
        $this->payload['feedback'] = 'this is a feedback';
        return $this;
    }

    public function withGeneral(): static
    {
        $this->payload["general"] = [
            "zip" => "88287",
            "city" => "Grünkraut",
            "cellar" => "Kein Keller",
            "reason" => "Modernisierung/Änderung",
            "ventilation" => "Schachtlüftung",
            "living_space" => "123",
            "building_type" => "Mehrfamilienhaus",
            "housing_units" => "1",
            "street_address" => "Liebenhofen 42",
            "construction_year" => 1990,
            "construction_year_heating" => "2005",
        ];

        return $this;
    }

    public function withAdditional($coolingEnabled = false): static
    {
        $this->payload["additional"] = [
            "renewables" => "Keine",
            "suggestion_check" => [
                "led" => false,
                "attic" => true,
                "windows" => true,
                "external_wall" => false,
                "cellar_ceiling" => true,
            ],
            ...!$coolingEnabled
                ? []
                : [
                    'cooling' => 'Aus Strom',
                    'cooling_count' => 2,
                    'cooling_service' => "2021-12-31T22:59:59.999Z",
                ],
        ];
        return $this;
    }

    public function withConsumption($numberOfRanges = 1, $waterEnabled = false): static
    {
        $this->payload["consumption"] =
            [
                ...$this->payload["consumption"] ?? [],
                "hot_water" => "Im Verbrauch enthalten - genaue Werte unbekannt",
                "consumption_range" => [
                    [

                        "range" =>
                            array_map(function () use ($waterEnabled) {
                                $range = [
                                    "end" => "2021-12-31T22:59:59.999Z",
                                    "start" => "2017-12-31T23:00:00.000Z",
                                    "consumption" => "16458",
                                ];
                                if ($waterEnabled) {
                                    $range["water"] = 1245;
                                }
                                return $range;
                            }, range(1, $numberOfRanges)),
                        "source" => "Erdgas L [m³]",
                    ],
                ],
            ];

        return $this;
    }

    public function withVacancyPercentage(): static
    {
        $this->payload["consumption"] = [
            ...$this->payload["consumption"] ?? null,
            "vacancy_percentage" => "27",
        ];
        return $this;
    }

    public function withVacancy($numberOfRanges = 1): static
    {
        $this->payload["consumption"] =
            [
                ...$this->payload["consumption"] ?? null,
                "vacancy_range" =>
                    array_map(function () {
                        return [
                            "end" => "2021-12-31T22:59:59.999Z",
                            "start" => "2017-12-31T23:00:00.000Z",
                        ];
                    }, range(1, $numberOfRanges)),

            ];

        return $this;
    }

    public function build(): array
    {
        $payload = $this->payload;
        $this->payload = [];
        return $payload;
    }
}
