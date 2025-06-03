<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;
use App\Models\Provincesregion;
use Illuminate\Support\Facades\DB;

class AirportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $provinces = Provincesregion::all();
        return view('pages.airports.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    // public function api()
    // {
    //     return response()->json(Airport::all());
    // }

    public function showdetail($id)
    {
        $airport = Airport::findOrFail($id);

        return view('pages.airports.showdetail', compact('airport'));
    }

    public function showdetailemergency($id)
    {
        $airport = Airport::findOrFail($id);
        $nearests = DB::table('nearestairports')->where('airport_id', $id)->get();

        return view('pages.airports.showdetailemergency', compact('airport','nearests'));
    }

    public function showairlinesdestination($id)
    {
        $airport = Airport::findOrFail($id);
        $internationals = DB::table('internationalairlines')->where('airport_id', $id)->get();
        $domestics = DB::table('domesticairlines')->where('airport_id', $id)->get();

        return view('pages.airports.showairlinesdestination', compact('airport','internationals','domestics'));
    }

    public function shownavigation($id)
    {
        $airport = Airport::findOrFail($id);
        $airportcommunications = DB::table('airportcommunications')->where('airport_id', $id)->get();
        $runawayairports = DB::table('runawayairports')->where('airport_id', $id)->get();
        $navigationaidairports = DB::table('navigationaidairports')->where('airport_id', $id)->get();
        $navigationnearbyairports = DB::table('navigationnearbyairports')->where('airport_id', $id)->get();
        return view('pages.airports.shownavigation', compact('airportcommunications','runawayairports','navigationaidairports','navigationnearbyairports','airport'));
    }

    public function filter(Request $request)
    {
        $query = Airport::query();

        // Filter by name
        $query->when($request->filled('name'), function ($q) use ($request) {
            $q->where('airport_name', 'like', '%' . $request->input('name') . '%');
        });

        // Filter by category
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->where('category', 'like', '%' . $request->input('category') . '%');
        });

        // Filter by location
        $query->when($request->filled('location'), function ($q) use ($request) {
            $q->where('address', 'like', '%' . $request->input('location') . '%');
        });

        // Filter by province IDs
        $query->when($request->filled('provinces'), function ($q) use ($request) {
            $q->whereIn('province_id', $request->input('provinces'));
        });

        // Filter by radius (Haversine Formula)
        if (
            $request->filled('radius') &&
            $request->filled('center_lat') &&
            $request->filled('center_lng') &&
            is_numeric($request->input('radius')) &&
            $request->input('radius') > 0
        ) {
            $centerLat = (float) $request->input('center_lat');
            $centerLng = (float) $request->input('center_lng');
            $radiusKm = (float) $request->input('radius');

            // Haversine formula
            $haversine = "(6371 * acos(cos(radians(?)) * cos(radians(latitude))
                        * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude))))";

            $query->selectRaw("airports.*, $haversine AS distance", [
                    $centerLat, $centerLng, $centerLat
                ])
                ->whereRaw("$haversine < ?", [
                    $centerLat, $centerLng, $centerLat, $radiusKm
                ])
                ->orderBy('distance');
        }

        return response()->json($query->get());
    }

}
