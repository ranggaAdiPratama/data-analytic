<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            if (strlen($request->password) < 8) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->withErrors(['error' => 'Password harus mengandung setidaknya 8 karakter']);
            }
            // !SECTION validasi
            // SECTION Pengecekan
            Auth::attempt([
                'username'  => $request->username,
                'password'  => $request->password,
            ]);
            // !SECTION Pengecekan
            if (Auth::check()) {
                return redirect()->to('/');
            } else {
                // SECTION Pengecekan
                Auth::attempt([
                    'email'     => $request->phone,
                    'password'  => $request->password,
                ]);
                // !SECTION Pengecekan
                if (Auth::check()) {
                    return redirect()->to('/auth/dashboard');
                } else {
                    return redirect()->back()->withInput()->withErrors(['error' => 'Password Salah']);
                }
            }
        } catch (Exception $e) {
            if (env('APP_ENV') == 'local') {
                dd($e);
            }

            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['error' => 'Terjadi kesalahan']);
        }
    }
}
