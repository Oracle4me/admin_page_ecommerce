<?php

namespace App\Modules\Auth\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Auth\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function viewLoginAdmin()
    {
        return view('admin.auth.admin_login');
    }

    /*
    |--------------------------------------------------------------------------
    | REGISTER
    |--------------------------------------------------------------------------
    */
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:225',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => 'user',
            'status' => 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Registrasi berhasil',
            'user' => $user,
        ], 201);
    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials['status'] = 'active';

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return response()->json([
                'status' => 'success',
                'redirect_to' => route('dashboard.index'),
            ]);
        }

        return back()->withErrors(['email' => 'Login gagal']);
    }

    public function logoutAdmin(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('admin.login')
            ->with('success', 'Logout berhasil')
            ;
    }


    /*
    |--------------------------------------------------------------------------
    | LOGIN (JWT)
    |--------------------------------------------------------------------------
    */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Tambahkan filter akun aktif
        $credentials['status'] = 'active';

        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email atau password salah',
                ], 401);
            }
        } catch (JWTException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal membuat token',
            ], 500);
        }

        $user = JWTAuth::user();
        $redirectTo = match ($user->role) {
            'admin' => '/admin/dashboard',
            'user' => 'http://localhost:8080/',
            default => '/',
        };

        return response()->json([
            'status' => true,
            'success' => 'Login berhasil',
            'token' => $token,
            'redirect_to' => $redirectTo,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'status' => $user->status,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | ME (CHECK LOGIN)
    |--------------------------------------------------------------------------
    */
    public function me()
    {
        return response()->json([
            'status' => true,
            'user' => JWTAuth::user(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT (JWT INVALIDATE)
    |--------------------------------------------------------------------------
    */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json([
            'status' => true,
            'message' => 'Logout berhasil',
        ]);
    }
}
