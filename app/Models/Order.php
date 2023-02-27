<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property $id
 * @property $customer_id
 * @property $type
 * @property $status
 * @property $paid
 * @property $product_id
 * @property $product_type
 * @property $created_at
 * @property $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer_id',
        'status',
        'paid',
        'product_id',
        'product_type',
    ];

    protected $casts = [
        'paid' => 'boolean',
        'meta' => 'json',
        'id' => 'string'
    ];

    public function capture() {
        $this->update([
            'paid' => true,
            'status' => 'open'
        ]);
    }

    public function isBedarf(): bool
    {
        return $this->type === 'bedarfsausweis';
    }

    public function isVerbrauch(): bool
    {
        return $this->type === 'verbrauchsausweis';
    }

    public function isDone(): bool
    {
        return $this->status === 'done';
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function product(): MorphTo
    {
        return $this->morphTo();
    }

    public function upsells(): BelongsToMany
    {
        return $this->belongsToMany(Upsell::class);
    }

}
