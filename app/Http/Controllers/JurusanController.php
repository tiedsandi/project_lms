<?php

namespace App\Http\Controllers;

use App\Models\Majors;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $majors = Majors::orderBy('id', 'desc')->paginate(5);
        return view('jurusan.index', compact('majors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurusan.create');
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
            Alert::error('Validasi Gagal');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $validatedData = $validator->validated();
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            Majors::create($validatedData);
            Alert::success('Berhasil', 'Jurusan berhasil dibuat!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal membuat jurusan!');
        }

        return redirect()->route('major.index');
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
        $major = Majors::findOrFail($id);
        return view('jurusan.edit', compact('major'));
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
            $major = Majors::findOrFail($id);
            $major->update($validatedData);

            Alert::success('Berhasil', 'Jurusan berhasil diupdate!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal membuat jurusan!');
        }

        return redirect()->route('major.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $role = Majors::findOrFail($id);
            $role->delete();
            Alert::success('Success', 'Role berhasil di hapus!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal untuk menghapus role!');
        }

        return redirect()->route('major.index');
    }
}
