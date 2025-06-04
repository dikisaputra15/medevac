<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;
use App\Models\Provincesregion;
use Illuminate\Support\Facades\DB;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hospitalNames = DB::table('hospitals')->distinct()->pluck('name')->filter()->sort()->values();
        $hospitalCategories = DB::table('hospitals')->distinct()->pluck('facility_level')->filter()->sort()->values();
        $hospitalLocations = DB::table('hospitals')->distinct()->pluck('address')->filter()->sort()->values();

        $provinces = Provincesregion::all();
        return view('pages.hospital.index', compact('provinces','hospitalNames','hospitalCategories','hospitalLocations'));
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
    //     return response()->json(Hospital::all());
    // }

    public function showdetail($id)
    {
        $hospital = Hospital::findOrFail($id);
        return view('pages.hospital.showdetail', compact('hospital'));
    }

    public function showdetailclinic($id)
    {
        $hospital = Hospital::findOrFail($id);
        return view('pages.hospital.showdetailclinic', compact('hospital'));
    }

    public function showdetailemergency($id)
    {
        $hospital = Hospital::findOrFail($id);
        return view('pages.hospital.showdetailemergency', compact('hospital'));
    }

    public function filter(Request $request)
    {
        $query = Hospital::query();

        // Filter by name
        $query->when($request->filled('name'), function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->input('name') . '%');
        });

        // Filter by category
        $query->when($request->filled('category'), function ($q) use ($request) {
            $q->where('facility_level', 'like', '%' . $request->input('category') . '%');
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

            $query->selectRaw("hospitals.*, $haversine AS distance", [
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
