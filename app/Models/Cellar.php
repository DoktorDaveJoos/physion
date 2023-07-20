<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Cellar extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bedarfsausweis(): BelongsTo
    {
        return $this->belongsTo(Bdrf::class);
    }

    public function insulations(): MorphMany
    {
        return $this->morphMany(Insulation::class, 'insulationable');
    }
}