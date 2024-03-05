<?php

namespace App\Models;

use App\Models\Product\FamilyStrategy;
use App\Models\Product\StrategyInterface;
use App\Models\Product\TargetStrategy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Credit extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function creditConditions(): HasMany
    {
        return $this->hasMany(CreditCondition::class);
    }

    public function creditAmountConditions(): HasMany
    {
        return $this->hasMany(CreditAmountCondition::class);
    }

    public function getConditionStrategy(): ?StrategyInterface
    {
        if (!$this->creditAmountConditions()->exists()) {
            return null;
        }

        return key_exists('kids', $this->creditAmountConditions()->first()?->condition)
            ? FamilyStrategy::make($this->creditAmountConditions)
            : TargetStrategy::make($this->creditAmountConditions);
    }

}
