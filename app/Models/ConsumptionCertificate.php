<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ConsumptionCertificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'product');
    }

    public function additional(): HasOne
    {
        return $this->hasOne(Additional::class);
    }

    public function consumptions(): HasMany
    {
        return $this->hasMany(Consumption::class);
    }

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }
}
