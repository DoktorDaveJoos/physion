<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Heating extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'water_included' => 'boolean',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function bedarfsausweis(): BelongsTo
    {
        return $this->belongsTo(Bdrf::class, 'bdrf_id');
    }
}
