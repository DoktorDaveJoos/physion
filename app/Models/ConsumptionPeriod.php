<?php

namespace App\Models;

use App\Casts\HandleJsDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConsumptionPeriod extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'start' => HandleJsDate::class,
        'end' => HandleJsDate::class
    ];

    public function energySource(): BelongsTo
    {
        return $this->belongsTo(EnergySource::class);
    }
}
