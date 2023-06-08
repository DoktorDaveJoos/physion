<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

/**
 * @mixin Order
 */
class FindOrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'slug' => $this->slug,
                'created_at' => $this->created_at->format('d.m.Y'),
                'status' => $this->status,
            ],
            'links' => [
                'self' => URL::temporarySignedRoute('order.show', now()->addHour(), ['order' => $this->slug ]),
            ],
        ];
    }


}
