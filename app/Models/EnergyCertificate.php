<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EnergyCertificate extends Model
{
    use HasFactory;

    protected $table = 'energy_certificates';

    protected $guarded = ['id'];

    protected $casts = [
        'suggestion_check' => 'array',
    ];

    public function building(): BelongsTo
    {
        return $this->belongsTo(Building::class);
    }
}
