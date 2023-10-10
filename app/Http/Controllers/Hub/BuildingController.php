<?php

namespace App\Http\Controllers\Hub;

use App\Http\Controllers\Controller;
use App\Http\Requests\Certificate\Bdrf\UpdatePositionRequest;
use App\Http\Requests\CreateBuildingRequest;
use App\Http\Requests\CreateBzaRequest;
use App\Http\Requests\CreateIsfpRequest;
use App\Http\Resources\Building\BuildingResource;
use App\Http\Resources\Building\BuildingResourceConsumption;
use App\Http\Resources\Building\BuildingResourceDocs;
use App\Http\Resources\Building\BuildingResourceEnergieausweis;
use App\Http\Resources\Building\BuildingResourcePosition;
use App\Http\Resources\Building\BuildingThermalResource;
use App\Models\Activity;
use App\Models\Attachment;
use App\Models\Building;
use App\Models\Bza;
use App\Models\Customer;
use App\Models\Isfp;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class BuildingController extends Controller
{

    public function index(Request $request)
    {
        return Inertia::render('Hub/Building/BuildingIndex', [
            'buildings' => BuildingResource::collection(Building::where('team_id', $request->user()->currentTeam->id)->orderBy('id', 'desc')->paginate(10)),
        ]);
    }

    public function show(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowIndex', [
            'building' => new BuildingResource($building),
        ]);
    }

    public function general(Building $building)
    {
        return Inertia::render('Hub/Building/Show/BuildingShowData', [
            'building' => new BuildingResource($building),
        ]);
    }

    public function update(Building $building, CreateBuildingRequest $request) {

        $building->update($request->all());

        return to_route('hub.buildings.show.general', $building->id);
    }

    public function position(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingPosition', [
            'building' => new BuildingResourcePosition($building),
        ]);
    }

    public function updatePosition(Building $building, UpdatePositionRequest $request)
    {

        $building->update([
            'status' => 'finished'
        ] + $request->all());

        return to_route('hub.buildings.show.position', [
            'building' => $building->id,
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
        return Inertia::render('Hub/Building/BuildingIsfp', [
            'building' => new BuildingResource($building),
        ]);
    }

    public function storeIsfp(Building $building, CreateIsfpRequest $request)
    {

        $isfpProduct = Product::where('short_name', 'isfp')->firstOrFail();

        $path = $request->file('vollmacht')->store($building->storagePath().'/attachments');

        $customer = Customer::create([
            'type' => $request->get('type'),
            'title' => $request->get('title'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'address_line_1' => $request->get('street').' '.$request->get('house_number'),
            'zip' => $request->get('postal_code'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
        ]);

        $building->update([
            'bauantrag_date' => $request->get('bauantrag_date'),
        ]);

        Isfp::create([
            'building_id' => $building->id,
            'customer_id' => $customer->id,
            'product_id' => $isfpProduct->id,
            'power_of_attorney_path' => $path,
        ]);

        return to_route('hub.buildings.isfp', [
            'building' => $building->id,
        ]);
    }

    public function showBza(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingBza', [
            'building' => new BuildingResource($building),
        ]);
    }

    public function storeBza(Building $building, CreateBzaRequest $request)
    {
        $bzaProduct = Product::where('short_name', 'bza')->firstOrFail();

        $path = $request->file('vollmacht')->store($building->storagePath().'/attachments');

        $customer = Customer::create([
            'type' => $request->get('type'),
            'title' => $request->get('title'),
            'first_name' => $request->get('first_name'),
            'last_name' => $request->get('last_name'),
            'address_line_1' => $request->get('street').' '.$request->get('house_number'),
            'zip' => $request->get('postal_code'),
            'city' => $request->get('city'),
            'country' => $request->get('country'),
            'phone' => $request->get('phone'),
            'email' => $request->get('email'),
        ]);

        Bza::create([
            'building_id' => $building->id,
            'customer_id' => $customer->id,
            'product_id' => $bzaProduct->id,
            'power_of_attorney_path' => $path,
        ]);

        return to_route('hub.buildings.bza', [
            'building' => $building->id,
        ]);
    }

    public function showCalculator(Building $building)
    {
        return Inertia::render('Hub/Building/BuildingCalculator', [
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
        return Inertia::render('Hub/Building/BuildingCreate');
    }

    public function store(CreateBuildingRequest $request)
    {
        $building = Building::create([
            'team_id' => $request->user()->currentTeam->id,
            'created_by' => $request->user()->id,
            'place_id' => $request->get('place_id'),
            'street' => $request->get('street'),
            'house_number' => $request->get('house_number'),
            'postal_code' => $request->get('postal_code'),
            'city' => $request->get('city'),
            'type' => $request->get('type'),
            'additional_type' => $request->get('additional_type'),
            'construction_year' => $request->get('construction_year'),
            'construction_year_heating' => $request->get('construction_year_heating'),
            'floor_area' => $request->get('floor_area'),
            'floors' => $request->get('floors'),
            'housing_units' => $request->get('housing_units'),
            'ventilation' => $request->get('ventilation'),
            'cellar' => $request->get('cellar'),
            'cooling' => $request->get('cooling'),
            'cooling_count' => $request->get('cooling_count'),
            'cooling_service' => $request->get('cooling_service'),
        ]);

        return to_route('hub.buildings.show.position', [
            'building' => $building->id,
        ]);
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

        $path = $request->file('document')->store($building->storagePath().'/attachments');

        $building->attachments()->create([
            'type' => $request->get('type'),
            'path' => $path,
            'name' => $request->file('document')->getClientOriginalName(),
            'published' => true,
        ]);

        Activity::create([
            'team_id' => $building->team_id,
            'user_id' => $request->user()->id,
            'type' => Activity::ADDED,
            'subject' => 'ein Dokument',
        ]);

        return to_route('hub.buildings.docs', [
            'building' => $building->id,
        ]);
    }

    public function deleteDocument(Building $building, Attachment $attachment)
    {
        Storage::delete($attachment->path);
        $attachment->delete();
        return to_route('hub.buildings.docs', [
            'building' => $building->id,
        ]);
    }

    public function storeImages(Building $building, Request $request)
    {
        $request->validate([
            'pictures' => 'required|array',
            'pictures.*' => 'required|file|image|max:10000',
        ], [
            'picture.required' => 'Bitte laden Sie ein Dokument hoch.',
            'picture.file' => 'Bitte laden Sie ein Bild hoch.',
            'picture.max' => 'Bild zu groß.',
        ]);

        foreach ($request->file('pictures') as $picture) {
            $path = $picture->store($building->storagePath().'/attachments');
            $building->attachments()->create([
                'type' => 'picture',
                'path' => $path,
                'name' => $picture->getClientOriginalName(),
                'published' => true,
            ]);
        }

        return to_route('hub.buildings.docs', [
            'building' => $building->id,
        ]);
    }

    public function showAppraisal(Building $building) {
        return Inertia::render('Hub/Building/BuildingAppraisal', [
            'building' => BuildingResource::make($building)
        ]);
    }

}
