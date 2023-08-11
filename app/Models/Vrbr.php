<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Collection as BaseCollection;
use Laravel\Scout\Searchable;

class Vrbr extends Model
{
    use HasFactory;
    use Searchable;

    protected $casts = [
        'cooling_service' => 'datetime',
        'suggestion_check' => 'json',
    ];

    protected $guarded = ['id'];

    public function searchableAs(): string
    {
        return 'vrbrs_index';
    }

    public function makeAllSearchableUsing(EloquentBuilder $query): EloquentBuilder
    {
        return $query->with('order');
    }

    public function makeSearchableUsing(Collection $models): Collection
    {
        return $models->load('order');
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
