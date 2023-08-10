<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\Category;
use App\Models\Vrbr;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

/**
 * @mixin Vrbr
 */
class VrbrSearchResource extends JsonResource
{
    /**
     * @throws Throwable
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'certificate_type' => Category::fromModel(Vrbr::class)->name(),
            'type' => Category::fromModel(Vrbr::class)->value,
            'street_address' => $this->street_address,
            'zip' => $this->zip,
            'city' => $this->city,
            'order_status' => $this->order->status,
        ];
    }


}
