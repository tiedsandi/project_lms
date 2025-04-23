<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\LearningModule;
use App\Models\LearningModuleDetail;
use App\Models\Students;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class MyLearningController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        // Cari student berdasarkan user_id
        $student = Students::where('user_id', $userId)->first();

        if (!$student) {
            Alert::error('Gagal', 'Kamu belum terdaftar sebagai siswa.');
            return redirect('dashboard');
        }

        $majorId = $student->major_id;
        if (!$majorId) {
            Alert::error('Gagal', 'Major kamu belum terdaftar.');
            return redirect('dashboard');
        }

        // Ambil semua Instructors yang major-nya sama
        $instructors = Instructors::where('major_id', $majorId)->get();

        $learning_modules = collect();
        $detail_modules = collect();

        if ($instructors->isNotEmpty()) {
            // Kalau ada instructor, cari learning modules berdasarkan pilihan instructor_id (optional)
            $queryLearningModules = LearningModule::whereIn('instructor_id', $instructors->pluck('id'));

            if ($request->filled('instructor_id')) {
                $queryLearningModules->where('instructor_id', $request->instructor_id);
            }

            $learning_modules = $queryLearningModules->get();

            // Cari detail modul berdasarkan pilihan module_id
            if ($request->filled('module_id')) {
                $detail_modules = LearningModuleDetail::where('learning_module_id', $request->module_id)->get();
            }
        }

        return view('my-learning.index', [
            'instructors' => $instructors,
            'learning_modules' => $learning_modules,
            'detail_modules' => $detail_modules
        ]);
    }
}
