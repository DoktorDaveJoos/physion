<?php

namespace App\Models;

use App\Casts\HandleJsDate;
use App\Casts\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Additional extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'cooling_service' => HandleJsDate::class,
        'suggestion_check' => Json::class,
    ];

    public function consumptionCertificate(): BelongsTo
    {

        return $this->belongsTo(ConsumptionCertificate::class);
    }
}
