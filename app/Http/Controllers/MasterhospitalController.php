<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;

class MasterhospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         if(request()->ajax()) {
            return datatables()->of(Hospital::select('*'))
            ->addColumn('action', function($row){
                 $updateButton = '<a href="' . route('hospitaldata.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                 return $updateButton;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('pages.master.hospital');
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
        $hospital = Hospital::findOrFail($id);
        return view('pages.master.edithospital', [
            'hospital' => $hospital
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         // Cari data airport berdasarkan ID
        $hospital = Hospital::findOrFail($id);

        // Update data
        $hospital->update([
            'name' => $request->input('name'),
            'nearest_airfield' => $request->input('nearest_airport'),
            'nearest_police_station' => $request->input('nearest_police_station'),
        ]);

          // Redirect dengan pesan sukses
        return redirect()->route('hospitaldata.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
