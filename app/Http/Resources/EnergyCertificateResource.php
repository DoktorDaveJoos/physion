<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\EnergyCertificate;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

/**
 * @mixin EnergyCertificate
 */
class EnergyCertificateResource extends JsonResource
{
    /**
     * @throws Throwable
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'status' => $this->status,
        ];
    }

}
