<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Enums\Category;
use App\Models\Bdrf;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

/**
 * @mixin Bdrf
 */
class BdrfSearchResource extends JsonResource
{
    /**
     * @throws Throwable
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'certificate_type' => Category::fromModel(Bdrf::class)->name(),
            'type' => Category::fromModel(Bdrf::class)->value,
            'street_address' => $this->street_address,
            'zip' => $this->zip,
            'city' => $this->city,
            'order_status' => $this->order->status,

        ];
    }


}
