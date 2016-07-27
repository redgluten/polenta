<?php

namespace App\Http\Controllers;

use Cache;
use App\Location;
use App\Http\Requests;
use Illuminate\Http\Request;

class LocationsAdminController extends Controller
{
    /**
     * Validation rules
     * @var array
     */
    private $rules = [
        'longitude'   => 'required|numeric',
        'latitude'    => 'required|numeric',
        'city'        => 'required|string',
        'name'        => 'required|string|max:255',
        'description' => 'string|max:4000',
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::orderBy('name')->paginate(20);

        return view('admin.locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.locations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, $this->rules);

        $location = new Location();

        $this->saveLocation($request, $location);

        Cache::rememberForever('locations', function() {
            return \App\Location::all();
        });

        return redirect()
            ->route('admin.location.index')
            ->with('message', 'Le lieu de distribution ' . $location->name . ' a bien été créé');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $location = Location::findOrFail($id);

        return view('admin.locations.edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $this->validate($request, $this->rules);

        $location = Location::findOrFail($id);

        $this->saveLocation($request, $location);

        Cache::rememberForever('locations', function() {
            return \App\Location::all();
        });

        return redirect()
            ->route('admin.location.index')
            ->with('message', 'Le lieu de distribution ' . $location->name . ' a bien été mis à jour');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Location $location)
    {
        $name = $location->name;

        $location->delete();

        return redirect()
            ->route('admin.location.index')
            ->with('message', 'Le lieu de distribution ' . $name . ' a été correctement supprimé');
    }

    /**
     * Save location to DB
     */
    private function saveLocation(Request $request, Location $location) : Location
    {
        $location->name        = $request->name;
        $location->city        = $request->city;
        $location->longitude   = $request->longitude;
        $location->latitude    = $request->latitude;
        $location->description = $request->description;

        $location->save();

        return $location;
    }
}
