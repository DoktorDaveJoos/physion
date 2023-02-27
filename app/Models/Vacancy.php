<?php

namespace App\Models;

use App\Casts\HandleJsDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vacancy extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'start' => HandleJsDate::class,
        'end' => HandleJsDate::class
    ];

    public function consumptionCertificate(): BelongsTo
    {
        return $this->belongsTo(Vbrc::class);
    }
}
