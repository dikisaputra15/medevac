<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hospital;

class HospitalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('pages.hospital.index');
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
        return response()->json(Hospital::all());
    }

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
}
