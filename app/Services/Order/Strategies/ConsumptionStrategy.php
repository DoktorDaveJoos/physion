<?php

declare(strict_types=1);

namespace App\Services\Order\Strategies;

use App\Models\Additional;
use App\Models\Consumption;
use App\Models\Vbrc;
use App\Models\Vacancy;

class ConsumptionStrategy implements OrderStrategy
{

    public function handle($payload): array
    {
        $certificate = new Vbrc($payload['general']);
        $certificate->save();

        $additional = new Additional($payload['additional']);
        $additional->consumptionCertificate()->associate($certificate->id);
        $additional->save();

        $consumption = $payload['consumption'];

        foreach ($consumption['consumption_range'] as $source) {
            foreach ($source['range'] as $range) {
                $consumptionModel = new Consumption(
                    array_merge(
                        [
                            'source' => $source['source'],
                            'hot_water' => $consumption['hot_water'],
                        ],
                        $range
                    )
                );
                $consumptionModel->consumptionCertificate()->associate($certificate->id);
                $consumptionModel->save();
            }
        }

        if (array_key_exists(
                'vacancy_percentage',
                $consumption
            ) && ($percentage = $consumption['vacancy_percentage'])) {
            $vacancy = new Vacancy([
                'percentage' => $percentage,
            ]);
            $vacancy->consumptionCertificate()->associate($certificate->id);
            $vacancy->save();
        }

        if (array_key_exists('vacancy_range', $consumption)) {
            foreach ($consumption['vacancy_range'] as $range) {
                $vacancy = new Vacancy($range);

                $vacancy->consumptionCertificate()->associate($certificate->id);
                $vacancy->save();
            }
        }

        return [$certificate->id, Vbrc::class];
    }
}
