<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Activity;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateAttachment
{

    use asAction;

    public function handle(
        Building $building,
        UploadedFile $file,
        string $type
    ): int {

        $path = $file->store($building->storagePath().'/attachments');

        $building->attachments()->create([
            'type' => $type,
            'path' => $path,
            'name' => $file->getClientOriginalName(),
            'published' => true,
        ]);

        return $building->id;

    }


}
