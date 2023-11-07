<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateMedia;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMediaRequest;
use App\Models\Building;
use Illuminate\Http\RedirectResponse;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{

    public function store(Building $building, CreateMediaRequest $request): RedirectResponse
    {
        CreateMedia::run(
            building: $building,
            images: $request->validated('images'),
        );

        return to_route('buildings.attachments.show', $building->id);
    }

    public function destroy(Building $building, Media $media): RedirectResponse
    {
        $media->delete();

        return to_route('buildings.attachments.show', $building->id);
    }

}
