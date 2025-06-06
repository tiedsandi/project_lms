<?php

namespace App\Http\Controllers;

use App\Models\Roles;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::orderBy('id', 'desc')->paginate(5);
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            Alert::error('Validasi Gagal', 'Silakan periksa input Anda.');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            Roles::create($validatedData);
            Alert::success('Berhasil', 'Role berhasil dibuat!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal membuat role!');
        }

        return redirect()->route('role.index');
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
        $role = Roles::findOrFail($id);
        return view('role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            Alert::error('Validasi Gagal', 'Silakan periksa input Anda.');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            $role = Roles::findOrFail($id);
            $role->update($validatedData);

            Alert::success('Berhasil', 'Role berhasil diupdate!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal membuat role!');
        }

        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Roles::findOrFail($id);
            $role->delete();
            Alert::success('Success', 'Role berhasil di hapus!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal untuk menghapus role!');
        }

        return redirect()->route('role.index');
    }
}
