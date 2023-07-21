<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Roof extends Model
{
    use HasFactory;

    protected $casts = [
        'beheizt' => 'boolean',
        'dachform' => 'string',
        'bauweise' => 'string',
        'u_wert' => 'float',
        'dachneigung' => 'integer',
        'kniestock' => 'integer',
        'zwischendecke' => 'integer',
    ];

    protected $guarded = ['id'];

    public function bedarfsausweis(): BelongsTo
    {
        return $this->belongsTo(Bdrf::class, 'bdrf_id');
    }

    public function windows(): MorphMany
    {
        return $this->morphMany(Window::class, 'windowable');
    }

    public function dormers(): HasMany
    {
        return $this->hasMany(Dormer::class);
    }

    public function insulations(): MorphMany
    {
        return $this->morphMany(Insulation::class, 'insulationable');
    }

}
