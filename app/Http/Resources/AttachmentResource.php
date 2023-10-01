<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Attachment;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

/**
 * @mixin Attachment
 */
class AttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'type' => $this->type
            ],
            'links' => [
                'self' => Storage::url($this->path),
            ],
        ];
    }


}
