<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $source
 * @property string $water
 * @property boolean $water_enabled
 * @property Vrbr $consumptionCertificate
 */
class EnergySource extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'water_enabled' => 'boolean',
        'main' => 'boolean',
    ];

    public function vrbr(): BelongsTo
    {
        return $this->belongsTo(Vrbr::class);
    }

    public function periods(): HasMany
    {
        return $this->hasMany(ConsumptionPeriod::class);
    }
}
