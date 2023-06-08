<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property string $type
 * @property string $stripe_product_id
 * @property string $name
 * @property string $short_name
 * @property string $description
 * @property float $price
 * @property string $image
 * @property string $image_alt
 */
class Product extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function order(): BelongsToMany
    {
        return $this->belongsToMany(Order::class);
    }

    public function scopeWhereCategory($query, string $category): void
    {
        $query->where('type', 'certificate')
            ->where('short_name', $category);
    }

}
