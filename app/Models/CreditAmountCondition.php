<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property array $condition
 */
class CreditAmountCondition extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'condition' => 'array',
    ];

    public function credit(): BelongsTo
    {
        return $this->belongsTo(Credit::class);
    }

}
