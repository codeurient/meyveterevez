<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Actions\Admin\Location\CreateLocationAction;
use App\Actions\Admin\Location\DeleteLocationAction;
use App\Actions\Admin\Location\UpdateLocationAction;
use App\DTOs\Admin\LocationDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreLocationRequest;
use App\Http\Requests\Admin\UpdateLocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(Request $request): View
    {
        $type  = $request->query('type', 'country');
        $query = Location::with('parent')->orderBy('name');

        if (in_array($type, ['country', 'state', 'city'])) {
            $query->where('type', $type);
        }

        $locations = $query->paginate(25)->withQueryString();
        $countries = Location::countries()->active()->orderBy('name')->get();

        return view('admin.locations.index', compact('locations', 'type', 'countries'));
    }

    public function create(): View
    {
        $countries = Location::countries()->active()->orderBy('name')->get();
        return view('admin.locations.create', compact('countries'));
    }

    public function store(StoreLocationRequest $request, CreateLocationAction $action): RedirectResponse
    {
        $action->execute(LocationDTO::fromRequest($request));

        return redirect()->route('admin.locations.index')
            ->with('success', __t('admin.location_created'));
    }

    public function edit(Location $location): View
    {
        $countries = Location::countries()->active()->orderBy('name')->get();
        $cities    = $location->parent_id
            ? Location::where('parent_id', $location->parent_id)->where('type', 'city')->orderBy('name')->get()
            : collect();

        return view('admin.locations.edit', compact('location', 'countries', 'cities'));
    }

    public function update(UpdateLocationRequest $request, Location $location, UpdateLocationAction $action): RedirectResponse
    {
        $action->execute($location, LocationDTO::fromRequest($request));

        return redirect()->route('admin.locations.index')
            ->with('success', __t('admin.location_updated'));
    }

    public function destroy(Location $location, DeleteLocationAction $action): RedirectResponse
    {
        try {
            $action->execute($location);
            return redirect()->route('admin.locations.index')
                ->with('success', __t('admin.location_deleted'));
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }
}
