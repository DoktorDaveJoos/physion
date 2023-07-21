<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Wall extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function bedarfsausweis(): BelongsTo
    {
        return $this->belongsTo(Bdrf::class, 'bdrf_id');
    }

    public function windows(): MorphMany
    {
        return $this->morphMany(Window::class, 'windowable');
    }

    public function insulations(): MorphMany
    {
        return $this->morphMany(Insulation::class, 'insulationable');
    }
}
