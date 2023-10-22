<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Renewable extends Model
{

    protected $table = 'renewable_energy_installations';

    protected $guarded = ['id'];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

    public function bedarfsausweis(): BelongsTo
    {
        return $this->belongsTo(Bdrf::class, 'bdrf_id');
    }
}
