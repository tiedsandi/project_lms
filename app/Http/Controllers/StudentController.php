<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\Majors;
use App\Models\Roles;
use App\Models\Students;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRoles;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function index()
    {
        $students = Students::with('major', 'user')->orderBy('id', 'desc')->paginate(5);
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Majors::orderBy('name', 'asc')->get();
        $usedUserIds = Students::whereNotNull('user_id')->pluck('user_id')->toArray();

        $usersAsStudents = User::whereHas('roles', function ($query) {
            $query->where('name', 'Murid');
        })
            ->whereNotIn('id', $usedUserIds)
            ->orderBy('name', 'asc')
            ->get();

        return view('student.create', compact('majors', 'usersAsStudents'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'major_id' => 'nullable|exists:majors,id',
            'gender' => 'required|in:0,1',
            'palace_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' => 'nullable|exists:users,id',
            'create_account' => 'nullable|boolean',
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
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('students', 'public');
            }

            $userId = null;

            if ($request->has('create_account')) {
                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $this->generateRandomEmail($request->name),
                    'password' => Hash::make('password123'), // Default password
                ]);
                $userId = $newUser->id;

                $role = Roles::where('name', 'Murid')->first();
                if (!$role) {
                    Alert::error('Error', 'Role Murid tidak ditemukan!');
                    return redirect()->back()->withInput();
                }

                UserRoles::create([
                    'user_id' => $userId,
                    'role_id' => $role->id,
                ]);
            } else {
                $userId = $request->user_id;
            }

            Students::create([
                'name' => $validatedData['name'],
                'major_id' => $validatedData['major_id'] ?? null,
                'user_id' => $userId,
                'gender' => $validatedData['gender'],
                'palace_of_birth' => $validatedData['palace_of_birth'] ?? null,
                'date_of_birth' => $validatedData['date_of_birth'] ?? null,
                'phone' => $validatedData['phone'] ?? null,
                'photo' => $photoPath,
                'is_active' => $validatedData['is_active'],
            ]);

            Alert::success('Berhasil', 'Murid berhasil dibuat!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal membuat murid!');
            return redirect()->back()->withInput();
        }

        return redirect()->route('murid.index');
    }

    private function generateRandomEmail($name)
    {
        $slug = Str::slug($name);
        $random = Str::lower(Str::random(5));
        return "{$slug}_{$random}@example.com";
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
        $student = Students::findOrFail($id);
        $majors = Majors::orderBy('name', 'asc')->get();

        $usedUserIds = Students::whereNotNull('user_id')->pluck('user_id')->toArray();
        $usersAsStudents = User::whereHas('roles', function ($query) {
            $query->where('name', 'Murid');
        })
            ->whereNotIn('id', $usedUserIds)
            ->orderBy('name', 'asc')
            ->get();

        return view('student.edit', compact('student', 'majors', 'usersAsStudents'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'major_id' => 'nullable|exists:majors,id',
            'gender' => 'required|in:0,1',
            'palace_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date',
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'user_id' => 'nullable|exists:users,id',
            'is_active' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            Alert::error('Validasi Gagal', 'Silakan periksa input Anda.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validatedData = $validator->validated();
        $validatedData['is_active'] = $request->has('is_active') ? 1 : 0;

        try {
            $student = Students::findOrFail($id);

            // Handle photo update
            $photoPath = $student->photo; // retain old photo by default

            if ($request->hasFile('photo')) {
                // Delete the old photo if it exists
                if ($student->photo) {
                    Storage::disk('public')->delete($student->photo);
                }

                // Store the new photo
                $photoPath = $request->file('photo')->store('students', 'public');
            }

            // Update the Student data
            $student->update([
                'major_id' => $validatedData['major_id'] ?? null,
                'user_id' => $validatedData['user_id'] ?? $student->user_id,
                'gender' => $validatedData['gender'],
                'palace_of_birth' => $validatedData['palace_of_birth'] ?? null,
                'date_of_birth' => $validatedData['date_of_birth'] ?? null,
                'phone' => $validatedData['phone'] ?? null,
                'photo' => $photoPath,
                'is_active' => $validatedData['is_active'],
            ]);

            // Handle user roles
            if ($request->has('user_id') && $student->user_id != $request->user_id) {
                // If the student's user ID has changed, update the roles
                $user = User::findOrFail($request->user_id);

                $role = Roles::where('name', 'Murid')->first();
                $user->roles()->sync([$role->id]);

                Alert::success('Berhasil', 'Murid berhasil diupdate!');
            } else {
                Alert::success('Berhasil', 'Murid berhasil diupdate!');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal memperbarui murid!');
            return redirect()->back()->withInput();
        }

        return redirect()->route('murid.index');
    }


    public function destroy($id)
    {
        try {
            $student = Students::findOrFail($id);

            $user = $student->user;

            if ($student->photo) {
                Storage::disk('public')->delete($student->photo);
            }

            $student->delete();

            if ($user) {
                $user->roles()->detach();
                $user->delete();
            }

            Alert::success('Berhasil', 'Murid berhasil dihapus!');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus murid!');
        }

        return redirect()->route('murid.index');
    }
}
