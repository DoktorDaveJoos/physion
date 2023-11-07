<?php

declare(strict_types=1);

namespace App\Actions\Building;

use App\Models\Building;
use Illuminate\Http\UploadedFile;
use Lorisleiva\Actions\Concerns\AsAction;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class CreateMedia
{

    use asAction;

    /**
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function handle(
        Building $building,
        array $images,
    ): void {
        collect($images)->each(function (UploadedFile $image) use ($building) {
            $building->addMedia($image)->toMediaCollection('images');
        });
    }
}
