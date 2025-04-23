<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\LearningModule;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class InstrukturLearningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $instructor = Instructors::where('user_id', $user->id)->first();

        if (!$instructor) {
            Alert::error('Gagal', 'Kamu belum terdaftar sebagai instruktur.');
            return redirect('dashboard');
        }

        if (!$instructor->major_id) {
            Alert::error('Gagal', 'Major kamu belum terdaftar.');
            return redirect('dashboard');
        }

        // Ambil semua modul yang dibuat instruktur ini
        $modules = LearningModule::where('instructor_id', $instructor->id)->get();

        return view('learning_modul_ins.index', compact('modules', 'instructor'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $user = auth()->user();
        $instructor = Instructors::where('user_id', $user->id)->first();

        if (!$instructor) {
            Alert::error('Gagal', 'Kamu belum terdaftar sebagai instruktur.');
            return redirect('dashboard');
        }

        if (!$instructor->major_id) {
            Alert::error('Gagal', 'Major kamu belum terdaftar.');
            return redirect('dashboard');
        }

        return view('learning_modul_ins.create', compact('instructor'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructor_id' => 'required|exists:instructors,id',
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
            LearningModule::create($validatedData);
            Alert::success('Berhasil', 'Learning Module berhasil dibuat!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal membuat Learning Module!');
        }

        return redirect()->route('learning_modul_ins.index');
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
        $module = LearningModule::findOrFail($id);

        return view('learning_modul_ins.edit', compact('module'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
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
            $module = LearningModule::findOrFail($id);
            $module->update($validatedData);

            Alert::success('Berhasil', 'Learning Module berhasil diperbarui!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal memperbarui Learning Module!');
        }

        return redirect()->route('module_ins.index');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $module = LearningModule::findOrFail($id);
            $module->delete();

            Alert::success('Berhasil', 'Learning Module berhasil dihapus!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menghapus Learning Module!');
        }

        return redirect()->route('module_ins.index');
    }
}
