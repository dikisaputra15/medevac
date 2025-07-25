<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(request()->ajax()) {
            return datatables()->of(Role::select('*'))
            ->addColumn('action', function($row){
                 $updateButton = '<a href="' . route('roles.edit', $row->id) . '" class="btn btn-primary btn-sm">Edit</a>';
                 $deleteButton = '<button class="btn btn-sm btn-danger delete-btn" data-id="'.$row->id.'">Delete</button>';
                 return $updateButton." ".$deleteButton;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        return view('pages.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create(['name' => $request->name]);

        return redirect()->route('roles.index')->with('success', 'Role berhasil dibuat.');
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
         $role = Role::findOrFail($id);
         return view('pages.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
         $validatedData = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        // Simpan data ke database
        $role = Role::findOrFail($id);
        $role->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('roles.index')->with('success', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
         $role = Role::findOrFail($id);

        if($role->delete()){
            $response['success'] = 1;
            $response['msg'] = 'Delete successfully';
        }else{
            $response['success'] = 0;
            $response['msg'] = 'Invalid ID.';
        }

        return response()->json($response);
    }
}
