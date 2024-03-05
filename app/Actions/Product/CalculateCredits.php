<?php

declare(strict_types=1);

namespace App\Actions\Product;

use App\Http\DTOs\CreditsDTO;
use App\Models\Building;
use App\Models\Credit;
use Lorisleiva\Actions\Concerns\AsAction;

class CalculateCredits
{

    use asAction;

    public const KIDS = 'kids';
    public const SALARY = 'salary';
    public const HAS_BUILDING = 'has_building';
    public const HAS_QNG = 'has_qng';
    public const HAS_LIFECYCLE = 'has_lifecycle';
    public const TARGET = 'target';
    public const ECERT_RATING = 'ecert_rating';

    public function handle(
        Building $building,
        ...$args
    ): CreditsDTO {
        ray($args);

        $creditsDTO = CreditsDTO::make();

        // Get all credits
        $credits = Credit::with(['creditConditions', 'creditAmountConditions'])->get();

        // If no credits, return empty DTO
        if ($credits->isEmpty()) {
            return $creditsDTO;
        }

        // Loop through credits, filter out credits that don't fit
        $credits->each(function (Credit $credit) use ($creditsDTO, $building, $args) {
            // @todo check QNG, check lifecycle and opt out if not present but requested
            if ($credit->respects_lifecycle || $credit->respects_qng) {
                // Check if building has QNG or lifecycle
//                if ($args[])

            }


            // If no credit conditions, add credit to DTO
            if ($credit->creditAmountConditions()->count() === 0) {
                $creditsDTO
                    ->addCredit($credit);
                return;
            }

            // If credit conditions, check if credit fits -> add to DTO if it does
            if (!([$amount, $grant] = $credit->getConditionStrategy()->getAmount($args))) {
                return;
            }

            // Apply housing units if respected
            $amount = $credit->respects_housing_units ?
                $amount * $building->housing_units :
                $amount;


            $creditsDTO
                ->addCredit($credit, $amount);

            // If grant exists, add to DTO
            if ($grant) {
                $creditsDTO
                    ->addGrant($grant);
            }
        });

        return $creditsDTO;
    }
}
