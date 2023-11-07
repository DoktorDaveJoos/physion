<?php

declare(strict_types=1);

namespace App\Models\Product;

use App\Actions\Product\CalculateCredits;
use App\Models\CreditAmountCondition;
use Illuminate\Support\Collection;

class FamilyStrategy implements StrategyInterface
{

    private const KIDS = 'kids';
    private const SALARY = 'salary';

    private const AMOUNT = 'max';

    private Collection $conditions;

    /**
     * @param  array  $conditions
     */
    public function __construct(Collection $conditions)
    {
        $this->conditions = collect($conditions);
    }

    public static function make(\Illuminate\Database\Eloquent\Collection $conditions): self
    {
        return new static($conditions);
    }

    public function getAmount(
        array $args
    ): ?array {
        [
            CalculateCredits::KIDS => $kids,
            CalculateCredits::SALARY => $salary,
            CalculateCredits::HAS_BUILDING => $preOwnsBuilding,
        ] = $args;

        if ($preOwnsBuilding) {
            return null;
        }

        if (!$kids || !$salary) {
            return null;
        }

        $found = $this->conditions->filter(function (CreditAmountCondition $condition) use ($kids, $salary) {
            return $condition->condition[self::SALARY] >= $salary && $condition->condition[self::KIDS] <= $kids;
        })->max(function (CreditAmountCondition $condition) {
            return $condition->condition[self::AMOUNT];
        });

        rd($found);

        return [
            'amount' => $found[self::AMOUNT],
            'grant' => null,
        ];
    }
}
