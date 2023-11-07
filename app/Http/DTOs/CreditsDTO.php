<?php

declare(strict_types=1);

namespace App\Http\DTOs;

use App\Models\Credit;

class CreditsDTO
{

    private array $credits;
    private array $grants;


    /**
     * @param  array  $credits
     * @param  array  $grants
     */
    public function __construct(array $credits = [], array $grants = [])
    {
        $this->credits = $credits;
        $this->grants = $grants;
    }

    public static function make(array $credits = [], array $grants = []): self
    {
        return new static($credits, $grants);
    }

    public function addCredit(
        Credit $credit,
        ?int $amount = 0,
    ): self
    {

        $interest = $credit->creditConditions()->min('interest');

        $this->credits[] = [
            'key' => $credit->key,
            'name' => $credit->name,
            'amount' => $amount ?? $credit->default_amount,
            'link' => $credit->link,
            'interest' => $interest,
            'credit_conditions' => $credit->creditConditions,
        ];

        return $this;
    }

    public function addGrant($grant): self
    {
        $this->grants[] = [
            'grant' => $grant['grant'],
            'key' => $grant['key'],
        ];

        return $this;
    }

    public function toArray(): array
    {
        return [
            'credits' => $this->credits,
            'grants' => $this->grants,
        ];
    }
}
