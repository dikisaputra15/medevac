<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;
use Illuminate\Support\Facades\DB;

class AirportsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.airports.index');
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

    public function api()
    {
        return response()->json(Airport::all());
    }

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

}
