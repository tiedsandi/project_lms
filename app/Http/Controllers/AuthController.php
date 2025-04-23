<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;


class AuthController extends Controller
{
  public function login()
  {
    return view('login');
  }

  public function actionLogin(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ]);

    $credentials = $request->only('email', 'password');


    if (Auth::attempt($credentials)) {
      Alert::success('Selamat Datang Kembali', 'Anda berhasil masuk!');
      return redirect('dashboard');
    } else {
      Alert::toast('Email atau kata sandi salah!', 'error');
      return back()->withInput();
    }
  }

  public function logout()
  {
    Auth::logout();
    Alert::toast('Anda berhasil keluar!', 'success');
    return redirect()->to('/');
  }
}
