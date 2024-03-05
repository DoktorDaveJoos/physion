<?php

declare(strict_types=1);

namespace App\Http\Resources\Building;

use App\Http\Resources\AttachmentResource;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Building
 */
class BuildingResourceAttachments extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'address' => $this->street.' '.$this->house_number,
                'postal_code' => $this->postal_code,
                'city' => $this->city,
                'attachments' => AttachmentResource::collection($this->attachments),
            ],
            'links' => [
                'image' => null, // $this->image ? Storage::url($this->image) : null,
                'self' => null // route('hub.buildings.show.index', $this->id),
            ],
        ];
    }
}
