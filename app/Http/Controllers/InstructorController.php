<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\Majors;
use App\Models\MergedInstructor;
use App\Models\Roles;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class InstructorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     $usedUserIds = Instructors::whereNotNull('user_id')->pluck('user_id')->toArray();

    //     $instructorsWithoutUser = Instructors::with('major')
    //         ->whereNull('user_id')
    //         ->get();

    //     $usersAsInstructors = User::whereHas('roles', function ($query) {
    //         $query->where('name', 'Instruktur');
    //     })
    //         ->whereNotIn('id', $usedUserIds)
    //         ->get();

    //     $merged = $instructorsWithoutUser->map(function ($instructor) {
    //         return new MergedInstructor([
    //             'source' => 'instructor',
    //             'id' => $instructor->id,
    //             'name' => $instructor->name,
    //             'major' => $instructor->major->name ?? null,
    //             'phone' => $instructor->phone,
    //             'photo' => null,
    //             'status' => $instructor->is_active,
    //             'created_at' => $instructor->created_at,
    //         ]);
    //     })->merge(
    //         $usersAsInstructors->map(function ($user) {
    //             return new MergedInstructor([
    //                 'source' => 'user',
    //                 'id' => $user->id,
    //                 'name' => $user->name,
    //                 'major' => null,
    //                 'phone' => $user->phone,
    //                 'photo' => $user->photo,
    //                 'status' => 0,
    //                 'created_at' => $user->created_at,
    //             ]);
    //         })
    //     );


    //     // Urutkan berdasarkan created_at terbaru
    //     $sorted = $merged->sortByDesc('created_at')->values();

    //     // Paginate manual
    //     $perPage = 5;
    //     $currentPage = LengthAwarePaginator::resolveCurrentPage();
    //     $currentItems = $sorted->slice(($currentPage - 1) * $perPage, $perPage);

    //     $paginated = new LengthAwarePaginator(
    //         $currentItems,
    //         $sorted->count(),
    //         $perPage,
    //         $currentPage,
    //         ['path' => request()->url(), 'query' => request()->query()]
    //     );

    //     return view('instructor.index', compact('paginated'));
    // }

    public function index()
    {
        $instructors = Instructors::with('major', 'user')->orderBy('id', 'desc')->paginate(5);
        return view('instructor.index', compact('instructors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $majors = Majors::orderBy('name', 'asc')->get();
        $usedUserIds = Instructors::whereNotNull('user_id')->pluck('user_id')->toArray();
        $usersAsInstructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'Instruktur');
        })
            ->whereNotIn('id', $usedUserIds)
            ->orderBy('name', 'desc')
            ->get();

        return view('instructor.create', compact('majors', 'usersAsInstructors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'major_id' => 'nullable|exists:majors,id',
            'gender' => 'required|in:0,1',
            'address' => 'nullable|string',
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
                $photoPath = $request->file('photo')->store('instructors', 'public');
            }

            $userId = null;

            if ($request->has('create_account')) {
                $newUser = User::create([
                    'name' => $request->name,
                    'email' => $this->generateRandomEmail($request->name),
                    'password' => Hash::make('password123'), // Default password
                ]);
                $userId = $newUser->id;

                $role = Roles::where('name', 'Instruktur')->first();
                if (!$role) {
                    Alert::error('Error', 'Role Instruktur tidak ditemukan!');
                    return redirect()->back()->withInput();
                }

                UserRoles::create([
                    'user_id' => $userId,
                    'role_id' => $role->id,
                ]);
            } else {
                $userId = $request->user_id;
            }

            Instructors::create([
                'major_id' => $validatedData['major_id'] ?? null,
                'user_id' => $userId,
                'gender' => $validatedData['gender'],
                'address' => $validatedData['address'] ?? null,
                'phone' => $validatedData['phone'] ?? null,
                'photo' => $photoPath,
                'is_active' => $validatedData['is_active'],
            ]);

            Alert::success('Berhasil', 'Instruktur berhasil dibuat!');
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal membuat instruktur!');
            return redirect()->back()->withInput();
        }

        return redirect()->route('instructor.index');
    }

    /**
     * Generate random email untuk akun baru
     */
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
        $instructor = Instructors::findOrFail($id);
        $majors = Majors::orderBy('name', 'asc')->get();

        $usedUserIds = Instructors::whereNotNull('user_id')->pluck('user_id')->toArray();
        $usersAsInstructors = User::whereHas('roles', function ($query) {
            $query->where('name', 'Instruktur');
        })
            ->whereNotIn('id', $usedUserIds)
            ->orderBy('name', 'desc')
            ->get();

        return view('instructor.edit', compact('instructor', 'majors', 'usersAsInstructors'));
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
            'address' => 'nullable|string',
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
            $instructor = Instructors::findOrFail($id);

            // Handle photo update
            $photoPath = $instructor->photo; // retain old photo by default

            if ($request->hasFile('photo')) {
                // Delete the old photo if it exists
                if ($instructor->photo) {
                    Storage::disk('public')->delete($instructor->photo);
                }

                // Store the new photo
                $photoPath = $request->file('photo')->store('instructors', 'public');
            }

            // Update the Instructor data
            $instructor->update([
                'major_id' => $validatedData['major_id'] ?? null,
                'user_id' => $validatedData['user_id'] ?? $instructor->user_id,
                'gender' => $validatedData['gender'],
                'address' => $validatedData['address'] ?? null,
                'phone' => $validatedData['phone'] ?? null,
                'photo' => $photoPath,
                'is_active' => $validatedData['is_active'],
            ]);

            // Handle user roles
            if ($request->has('user_id') && $instructor->user_id != $request->user_id) {
                // If the instructor's user ID has changed, update the roles
                $user = User::findOrFail($request->user_id);

                $role = Roles::where('name', 'Instruktur')->first();
                $user->roles()->sync([$role->id]);

                Alert::success('Berhasil', 'Instruktur berhasil diupdate!');
            } else {
                Alert::success('Berhasil', 'Instruktur berhasil diupdate!');
            }
        } catch (\Exception $e) {
            Alert::error('Error', 'Gagal memperbarui instruktur!');
            return redirect()->back()->withInput();
        }

        return redirect()->route('instructor.index');
    }

    public function destroy($id)
    {
        try {
            $instructor = Instructors::findOrFail($id);

            $user = $instructor->user;

            if ($instructor->photo) {
                Storage::disk('public')->delete($instructor->photo);
            }

            $instructor->delete();

            if ($user) {
                $user->roles()->detach();
                $user->delete();
            }

            Alert::success('Berhasil', 'Instruktur berhasil dihapus!');
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Terjadi kesalahan saat menghapus instruktur!');
        }

        return redirect()->route('instructor.index');
    }
}
