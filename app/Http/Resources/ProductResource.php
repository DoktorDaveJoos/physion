<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Product
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'price' => $this->price,
                'description' => $this->description,
                'features' => $this->meta['features'] ?? [],
            ],
            'links' => [
                'self' => null,
            ],
        ];
    }


}
