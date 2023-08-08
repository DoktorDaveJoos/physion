<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Laravel\Scout\Searchable;

class Vrbr extends Model
{
    use HasFactory;
    use Searchable;

    protected $casts = [
        'cooling_service' => 'datetime',
        'suggestion_check' => 'json'
    ];

    protected $guarded = ['id'];

    public function searchableAs(): string
    {
        return 'vrbrs_index';
    }

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
