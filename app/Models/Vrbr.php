<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Vrbr extends Model
{
    use HasFactory;

    protected $casts = [
        'cooling_service' => 'datetime',
    ];

    protected $guarded = ['id'];
    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'certificate');
    }

    public function sources(): HasMany
    {
        return $this->hasMany(EnergySource::class);
    }

    public function vacancies(): HasMany
    {
        return $this->hasMany(Vacancy::class);
    }

}
