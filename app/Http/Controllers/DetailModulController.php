<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\LearningModule;
use App\Models\LearningModuleDetail;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class DetailModulController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $id = $user->id;

        $instructor = Instructors::where('user_id', $id)->first();

        if (!$instructor || !$instructor->major_id) {

            Alert::error('Error', 'Anda belum terdaftar sebagai instruktur atau major belum ditentukan.');
            return redirect()->route('learning_module.index');
        }

        // Ambil semua modul yang dibuat oleh instructor ini
        $learning_module = LearningModule::where('instructor_id', $instructor->id)->get();

        // Default detail_module kosong
        $detail_module = collect();

        if ($request->filled('module_id')) {
            // Kalau ada module_id, cari detailnya
            $detail_module = LearningModuleDetail::where('learning_module_id', $request->module_id)->get();
        }

        return view('module_detail.index', compact('learning_module', 'detail_module'));
    }

    public function create()
    {
        $user = auth()->user();
        $id = $user->id;

        // Cek apakah user sudah memiliki instruktur terkait
        $instructor = Instructors::where('user_id', $id)->first();

        // Jika instruktur tidak ada atau instruktur tidak memiliki major_id, handle dengan baik
        if (!$instructor || !$instructor->major_id) {

            Alert::error('Error', 'Anda belum terdaftar sebagai instruktur atau major belum ditentukan.');
            return redirect()->route('learning_module.index');
        }

        // Jika instruktur ada dan memiliki major_id yang valid
        $learning_module = LearningModule::where('instructor_id', $instructor->id)->get();

        return view('module_detail.create', compact('learning_module'));
    }


    public function store(Request $request)
    {
        // Validasi data input
        $validated = $request->validate([
            'module_id' => 'required|exists:learning_modules,id',
            'file_name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip', // sesuaikan jenis file yang boleh
            'reference_link' => 'nullable|url',
        ]);

        // Inisialisasi array data untuk disimpan
        $data = [
            'learning_module_id' => $validated['module_id'],
            'file_name' => $validated['file_name'],
            'reference_link' => $validated['reference_link'] ?? null,
        ];

        // Handle file upload jika ada file diupload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('learning_modules', 'public'); // simpan di storage/app/public/learning_modules
            $data['file'] = $filePath;
        }

        // Simpan data ke database
        LearningModuleDetail::create($data);
        Alert::success('Berhasil', 'Role berhasil diupdate!');

        // Redirect ke halaman list atau balik dengan pesan sukses
        return redirect()->route('detail_module.create');
    }

    public function show($id) {}

    public function edit($id)
    {
        $detail_module = LearningModuleDetail::findOrFail($id);
        $learning_module = LearningModule::all(); // atau filter sesuai kebutuhan

        return view('module_detail.edit', compact('detail_module', 'learning_module'));
    }


    public function update(Request $request, $id)
    {
        // Validasi data input
        $validated = $request->validate([
            'module_id' => 'required|exists:learning_modules,id',
            'file_name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip', // sesuaikan jenis file
            'reference_link' => 'nullable|url',
        ]);

        // Cari data detail_module berdasarkan id
        $detail = LearningModuleDetail::findOrFail($id);

        // Inisialisasi array data untuk diupdate
        $data = [
            'learning_module_id' => $validated['module_id'],
            'file_name' => $validated['file_name'],
            'reference_link' => $validated['reference_link'] ?? null,
        ];

        // Handle file upload baru
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($detail->file && Storage::disk('public')->exists($detail->file)) {
                Storage::disk('public')->delete($detail->file);
            }

            // Upload file baru
            $file = $request->file('file');
            $filePath = $file->store('learning_modules', 'public');
            $data['file'] = $filePath;
        }

        // Update data di database
        $detail->update($data);

        // Tampilkan alert sukses
        Alert::success('Berhasil', 'Detail modul berhasil diupdate!');

        // Redirect ke halaman list detail module
        return redirect()->route('detail_module.index')->with('success', 'Detail modul berhasil diupdate.');
    }


    public function destroy($id)
    {
        // Cari data berdasarkan id
        $detail = LearningModuleDetail::findOrFail($id);

        // Hapus file dari storage kalau ada
        if ($detail->file && Storage::disk('public')->exists($detail->file)) {
            Storage::disk('public')->delete($detail->file);
        }

        // Hapus data dari database
        $detail->delete();

        // Tampilkan alert sukses
        Alert::success('Berhasil', 'Detail modul berhasil dihapus!');

        // Redirect ke list detail module
        return redirect()->route('detail_module.index')->with('success', 'Detail modul berhasil dihapus.');
    }
}
