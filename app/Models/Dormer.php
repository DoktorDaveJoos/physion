<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dormer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function roof(): BelongsTo
    {
        return $this->belongsTo(Roof::class);
    }
}
