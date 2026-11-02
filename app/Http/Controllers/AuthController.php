<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /** Nama route dashboard untuk setiap role. */
    public static function dashboardRoute(?string $role): string
    {
        return match ($role) {
            'admin'      => 'admin.dashboard',
            'petugas'    => 'officer.dashboard',
            'masyarakat' => 'user.dashboard',
            default      => 'home',
        };
    }

    public function showLogin()
    {
        if (session('is_login')) {
            return redirect()->route(self::dashboardRoute(session('role')));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required',
            'password' => 'required|min:6',
        ], [
            'email.required'    => 'Email / No. HP wajib diisi.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.min'      => 'Kata sandi minimal 6 karakter.',
        ]);

        $identifier = $request->input('email');

        $user = User::with('role')
            ->where(function ($q) use ($identifier) {
                $q->where('email', $identifier)->orWhere('no_hp', $identifier);
            })
            ->first();

        if (! $user || ! Hash::check($request->input('password'), $user->password)) {
            return back()->withInput($request->only('email'))
                ->with('error', 'Email/No. HP atau kata sandi salah.');
        }

        if ($user->status === 'nonaktif') {
            return back()->withInput($request->only('email'))
                ->with('error', 'Akun Anda dinonaktifkan. Hubungi administrator.');
        }

        $request->session()->regenerate();
        session([
            'user_id'  => $user->id,
            'nama'     => $user->nama_lengkap,
            'email'    => $user->email,
            'role'     => $user->role->name,
            'is_login' => true,
        ]);

        ActivityLog::catat($user->id, 'login', 'Login berhasil', $request->ip());

        return redirect()->route(self::dashboardRoute($user->role->name));
    }

    public function showRegister()
    {
        if (session('is_login')) {
            return redirect()->route(self::dashboardRoute(session('role')));
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap'        => 'required|min:3|max:100',
            'username'            => 'required|min:3|max:50|unique:users,username',
            'email'               => 'required|email|max:100|unique:users,email',
            'no_hp'               => 'required|min:10|max:15',
            'password'            => 'required|min:6',
            'konfirmasi_password' => 'required|same:password',
            'jenis_kelamin'       => 'nullable|in:L,P',
            'tanggal_lahir'       => 'nullable|date',
            'alamat'              => 'nullable|string',
        ], [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah digunakan, coba yang lain.',
            'min'      => ':attribute minimal :min karakter.',
            'same'     => 'Konfirmasi kata sandi tidak sama.',
            'email'    => 'Format email tidak valid.',
        ], [
            'nama_lengkap'        => 'Nama lengkap',
            'username'            => 'Username',
            'email'               => 'Email',
            'no_hp'               => 'No. HP',
            'password'            => 'Kata sandi',
            'konfirmasi_password' => 'Konfirmasi kata sandi',
        ]);

        User::create([
            'role_id'       => 3, // masyarakat
            'nama_lengkap'  => $data['nama_lengkap'],
            'username'      => $data['username'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'jenis_kelamin' => $data['jenis_kelamin'] ?? null,
            'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
            'no_hp'         => $data['no_hp'],
            'alamat'        => $data['alamat'] ?? null,
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }

    public function logout(Request $request)
    {
        ActivityLog::catat(session('user_id'), 'logout', 'Logout dari sistem', $request->ip());

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}
