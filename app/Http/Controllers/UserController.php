<?php

namespace App\Http\Controllers;

use App\Models\Instructors;
use App\Models\MajorDetail;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('UserRoles.role')->orderBy('id', 'desc')->paginate(5);
        // return $users;
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Roles::where('is_active', 1)->get();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validation  = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validation->fails()) {
            Alert::error('Validasi Gagal');
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        UserRoles::create([
            'user_id' => $user->id,
            'role_id' => $request->role_id,
        ]);

        Alert::success('Berhasil', 'User berhasil dibuat!');

        return redirect()->route('user.index');
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
        $user = User::with('UserRoles')->findOrFail($id);
        $roles = Roles::where('is_active', 1)->get();

        return view('user.edit', compact('roles', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validation  = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $id,
            'role_id' => 'required|exists:roles,id',
        ]);

        if ($validation->fails()) {
            Alert::error('Validasi Gagal');

            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        $user = User::findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ?? $user->password,
        ]);

        UserRoles::where('user_id', $id)->update([
            'role_id' => $request->role_id,
        ]);

        Alert::success('Berhasil', 'User berhasil diperbarui!');

        return redirect()->route('user.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        MajorDetail::where('user_id', $id)->delete();
        UserRoles::where('user_id', $id)->delete();
        Instructors::where('user_id', $id)->update(['user_id' => null]);


        $user->delete();

        Alert::success('Berhasil', 'User berhasil dihapus!');

        return redirect()->route('user.index');
    }
}
