<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Building\BuildingResourceConsumption;
use App\Http\Resources\Building\BuildingResourceDocs;
use App\Http\Resources\Building\BuildingResourceEnergieausweis;
use App\Http\Resources\Building\BuildingThermalResource;
use App\Models\Attachment;
use App\Models\Building;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BuildingController extends Controller
{

    public function index(Request $request)
    {



        return Inertia::render('Hub/Building/BuildingIndex', [
            'buildings' => BuildingResource::collection(Building::paginate(10)),
        ]);



    }

    public function show(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowIndex', [
            'building' => new BuildingResource($building),
        ]);
    }
    public function showDocs(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowDocs', [
            'building' => new BuildingResourceDocs($building),
        ]);
    }
    public function showEnergieausweis(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowEnergieausweis', [
            'building' => new BuildingResourceEnergieausweis($building),
        ]);
    }
    public function showIsfp(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingDetail', [
            'building' => new BuildingResource($building),
        ]);
    }
    public function showBza(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingDetail', [
            'building' => new BuildingResource($building),
        ]);
    }

    public function thermal(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingThermal', [
            'building' => new BuildingThermalResource($building),
        ]);

    }

    public function energy(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingEnergy', [
            'building' => new BuildingResource($building),
        ]);
    }

    public function consumption(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingConsumption', [
            'building' => new BuildingResourceConsumption($building),
        ]);
    }
    public function create(Request $request)
    {

    }

    public function store(Request $request)
    {

    }

    public function destroy(Building $building)
    {

    }

    public function storeDocument(Building $building, Request $request)
    {
        $request->validate([
            'type' => 'required|string',
            'document' => 'required|file|mimes:pdf|max:10000',
        ], [
            'type.required' => 'Bitte wählen Sie einen Dokumenttypen aus.',
            'type.string' => 'Bitte wählen Sie einen Dokumenttypen aus.',
            'document.required' => 'Bitte laden Sie ein Dokument hoch.',
            'document.file' => 'Bitte laden Sie ein Dokument hoch.',
            'document.mimes' => 'Bitte laden Sie ein Dokument hoch.',
            'document.max' => 'Dokument zu groß.',
        ]);

        $path = $request->file('document')->store($building->storagePath() . '/attachments');

        $building->attachments()->create([
            'type' => $request->get('type'),
            'path' => $path,
            'name' => $request->file('document')->getClientOriginalName(),
            'published' => true
        ]);

        return to_route('hub.buildings.show.docs', [
            'building' => $building->id,
        ]);

    }

    public function deleteDocument(Building $building, Attachment $attachment) {
        Storage::delete($attachment->path);
        $attachment->delete();
        return to_route('hub.buildings.show.docs', [
            'building' => $building->id,
        ]);
    }

    public function storeImage(Building $building, Request $request){

        $request->validate([
            'picture' => 'required|image|max:20000',
        ], [
            'picture.required' => 'Bitte laden Sie ein Dokument hoch.',
            'picture.file' => 'Bitte laden Sie ein Bild hoch.',
            'picture.max' => 'Bild zu groß.',
        ]);

        $path = $request->file('picture')->store($building->storagePath() . '/attachments');

        $building->attachments()->create([
            'type' => 'picture',
            'path' => $path,
            'name' => $request->file('picture')->getClientOriginalName(),
            'published' => true
        ]);

        return to_route('hub.buildings.show.docs', [
            'building' => $building->id,
        ]);

    }

}
