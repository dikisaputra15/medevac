<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aircharter;

class MasteraircharterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $airport =  Aircharter::orderBy('created_at', 'desc')->first();
        return view('pages.master.aircharter', compact('airport'));
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
    public function update(Request $request, $id)
    {
         // Cari data airport berdasarkan ID
        $airport = Aircharter::findOrFail($id);

        // Update data
        $airport->update([
            'charter_info' => $request->input('charter_info'),
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('aircharterdata.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
