<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string payment_intent
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function consumption(): HasMany
    {
        return $this->hasMany(Consumption::class);
    }

    public function vacancy(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

}