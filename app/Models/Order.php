<?php

namespace App\Models;

use App\Enums\Category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property $id
 * @property $customer_id
 * @property $slug
 * @property $status
 * @property $certificate_id
 * @property $certificate_type
 * @property Customer $customer
 * @property $created_at
 * @property $updated_at
 */
class Order extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'id' => 'string',
        'meta' => 'json',
    ];

    public function capture(): void
    {
        $this->update([
            'paid' => true,
            'status' => 'open',
        ]);
    }

    public function setStep(string $step): void
    {
        $this->update([
            'meta' => [
                'steps' => collect($this->meta['steps'])->add($step)->unique()->values()->toArray(),
            ],
        ]);
    }

    public function isDone(): bool
    {
        return $this->status === 'done';
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function certificate(): MorphTo
    {
        return $this->morphTo();
    }

    public function getCertificateProduct(): ?Product
    {
        return $this->products()->whereCategory(
            Category::fromModel($this->certificate_type)->value
        )->first();
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

}
