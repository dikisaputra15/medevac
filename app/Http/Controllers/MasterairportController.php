<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Airport;

class MasterairportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if(request()->ajax()) {
            return datatables()->of(Airport::select('*'))
            ->addColumn('action', function($row){
                 $updateButton = '<a href="' . route('airportdata.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                 return $updateButton;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('pages.master.airport');
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
    public function edit($id)
    {
        $airport = Airport::findOrFail($id);
        $category = !empty($airport->category) ? explode(', ', $airport->category) : [];
        return view('pages.master.editairport', [
            'airport' => $airport,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Cari data airport berdasarkan ID
        $airport = Airport::findOrFail($id);
        $category = !empty($request->category) ? implode(', ', $request->category) : '';

        // Update data
        $airport->update([
            'airport_name' => $request->input('airport_name'),
            'category' => $category,
            'nearest_medical_facility' => $request->input('nearest_medical_facility'),
            'domestic_flights' => $request->input('domestic_flights'),
            'nearest_airport' => $request->input('nearest_airport'),
            'navigation_aids' => $request->input('navigation_aids'),
            'nearest_police_station' => $request->input('nearest_police_station'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('airportdata.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
