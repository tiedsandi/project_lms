<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\LearningModule;
use App\Models\Majors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class LearningModulController extends Controller
{
    public function index(Request $request)
    {
        $majors = Majors::all();
        $instructors = [];
        $modules = [];

        if ($request->major_id) {
            $instructors = Instructors::with('user')->where('major_id', $request->major_id)->get();
        }

        if ($request->instructor_id) {
            $modules = LearningModule::where('instructor_id', $request->instructor_id)->get();
        }

        return view('learning_modul.index', compact('majors', 'instructors', 'modules'));
    }

    public function create($instructorId)
    {
        $instructor = Instructors::find($instructorId);

        if (!$instructor) {
            Alert::error('Validasi Gagal', 'Instructor tidak ditemukan.');
            return redirect()->route('learning_module.index');
        }

        return view('learning_modul.create', compact('instructor'));
    }

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

        return redirect()->route('learning_module.index');
    }

    public function edit($id)
    {
        // Cari module berdasarkan ID
        $module = LearningModule::find($id);

        // Jika tidak ditemukan, arahkan ke halaman daftar module
        if (!$module) {
            return redirect()->route('learning_module.index')->with('error', 'Module tidak ditemukan.');
        }

        // Ambil data terkait instructor jika perlu
        $instructor = Instructors::find($module->instructor_id)->with('user')->first();
        if (!$instructor) {
            return redirect()->route('learning_module.index')->with('error', 'Instructor tidak ditemukan.');
        }

        // Kembalikan view dengan data module dan instructor
        return view('learning_modul.edit', compact('module', 'instructor'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Cari module berdasarkan ID
        $module = LearningModule::find($id);

        // Jika module tidak ditemukan
        if (!$module) {
            return redirect()->route('learning_module.index')->with('error', 'Module tidak ditemukan.');
        }

        // Perbarui data module
        $module->name = $validatedData['name'];
        $module->description = $validatedData['description'];
        $module->is_active = $request->has('is_active') ? 1 : 0;

        // Simpan perubahan
        try {
            $module->save();
            Alert::success('Berhasil', 'Modul berhasil diperbarui!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal memperbarui modul!');
        }

        // Redirect ke halaman index
        return redirect()->route('learning_module.index');
    }

    public function destroy($id)
    {
        // Cari module berdasarkan ID
        $module = LearningModule::find($id);

        // Jika module tidak ditemukan, kembalikan ke halaman daftar module dengan pesan error
        if (!$module) {
            return redirect()->route('learning_module.index')->with('error', 'Module tidak ditemukan.');
        }

        // Coba hapus data module
        try {
            $module->delete();
            Alert::success('Berhasil', 'Module berhasil dihapus!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal menghapus module!');
        }

        // Redirect ke halaman index setelah berhasil dihapus
        return redirect()->route('learning_module.index');
    }
}
