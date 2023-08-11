<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Throwable;

/**
 * @mixin Order
 */
class OrderHubResource extends JsonResource
{
    /**
     * @throws Throwable
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'status' => $this->status,
            'owner' => $this->owner,
            'product' => $this->getCertificateProduct(),
            'certificate' => $this->certificate,
            'attachments' => AttachmentResource::collection($this->attachments),
            'certificate_type' => $this->certificate_type,
            'created_at' => $this->created_at->format('d.m.Y'),
        ];
    }


}
