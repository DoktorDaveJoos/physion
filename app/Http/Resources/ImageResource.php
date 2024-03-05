<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Attachment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @mixin Media
 */
class ImageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'collection_name' => $this->collection_name,
                'type' => $this->type,
                'size' => $this->humanReadableSize,
            ],
            'links' => [
                'original_url' => $this->original_url,
                'preview_url' => $this->preview_url,
            ],
        ];
    }


}
