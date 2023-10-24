<?php

namespace App\Http\Controllers\Building;

use App\Actions\Building\CreateAttachment;
use App\Actions\Building\DestroyAttachment;
use App\Http\Controllers\Controller;
use App\Http\Requests\CreateAttachmentRequest;
use App\Http\Resources\Building\BuildingResourceAttachments;
use App\Models\Attachment;
use App\Models\Building;
use Inertia\Inertia;

class AttachmentController extends Controller
{

    public function show(Building $building)
    {
        return Inertia::render('Hub/Buildings/Attachments/Show', [
            'building' => new BuildingResourceAttachments($building),
        ]);
    }


    public function store(Building $building, CreateAttachmentRequest $request)
    {
        $buildingId = CreateAttachment::run(
            $building,
            $request->file('document'),
            $request->validated('type')
        );

        return to_route('buildings.attachments.show', [
            'building' => $buildingId,
        ]);
    }

    public function destroy(Building $building, Attachment $attachment)
    {
        DestroyAttachment::run($attachment);

        return to_route('buildings.attachments.show', [
            'building' => $building->id,
        ]);
    }

}
