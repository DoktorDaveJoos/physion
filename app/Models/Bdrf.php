<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Bdrf extends Model
{
    use HasFactory;

    protected $table = 'bdrfs';

    protected $guarded = ['id'];

    protected $casts = [
        'cooling_service' => 'datetime',
    ];

    public function order(): MorphOne
    {
        return $this->morphOne(Order::class, 'certificate');
    }

    public function roof(): HasOne
    {
        return $this->hasOne(Roof::class);
    }

    public function wall(): HasOne
    {
        return $this->hasOne(Wall::class);
    }

    public function cellar(): HasOne
    {
        return $this->hasOne(Cellar::class);
    }

    public function heatingSystems(): HasMany
    {
        return $this->hasMany(HeatingSystem::class);
    }

    public function renewableEnergyInstallations(): HasMany
    {
        return $this->hasMany(RenewableEnergyInstallation::class);
    }

}
