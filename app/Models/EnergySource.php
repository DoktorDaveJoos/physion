<?php

namespace App\Models;

use App\Casts\HandleJsDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EnergySource extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'water_enabled' => 'boolean',
        'main' => 'boolean',
    ];

    public function consumptionCertificate(): BelongsTo
    {
        return $this->belongsTo(Verbrauchsausweis::class);
    }

    public function periods(): HasMany
    {
        return $this->hasMany(ConsumptionPeriod::class);
    }
}
