<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Verbrauchsausweis extends Model
{
    use HasFactory;

    protected $table = 'verbrauchsausweise';

    protected $casts = [
        'cooling_service' => 'datetime',
    ];

    protected $guarded = ['id'];

    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'product');
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
