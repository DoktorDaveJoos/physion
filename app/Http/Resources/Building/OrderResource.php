<?php

declare(strict_types=1);

namespace App\Http\Resources\Building;

use App\Http\DTOs\OrdersDTO;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin OrdersDTO
 */
class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => 1,
            ],
            'links' => [

            ],
        ];
    }
}
