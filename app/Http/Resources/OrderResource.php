<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use Throwable;

/**
 * @mixin Order
 */
class OrderResource extends JsonResource
{
    /**
     * @throws Throwable
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'slug' => $this->slug,
                'status' => $this->status,
                'customer' => $this->owner,
                'product' => $this->getCertificateProduct(),
                'upsells' => $this->upsells,
                'certificate' => $this->certificate,
                'attachments' => AttachmentResource::collection($this->attachments),
                'created_at' => $this->created_at->format('d.m.Y'),
            ],
            'links' => [
                'checkout' => URL::signedRoute('checkout.show', [
                    'order' => $this->slug,
                ]),
                'certificate' => URL::signedRoute('certificate.show', [
                    'order' => $this->slug,
                ]),
            ]
        ];
    }


}
