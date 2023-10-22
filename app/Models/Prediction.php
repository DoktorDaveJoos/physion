<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Prediction extends Model
{

    protected $guarded = ['id'];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }

}
