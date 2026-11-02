<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WasteReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function dashboard()
    {
        $mine = WasteReport::with('category')->where('user_id', session('user_id'));

        return view('user.dashboard', [
            'stats'      => WasteReport::statistik(),
            'laporan'    => (clone $mine)->orderByDesc('created_at')->limit(5)->get(),
            'totalSaya'  => (clone $mine)->count(),
        ]);
    }

    public function riwayat()
    {
        return view('user.riwayat', [
            'laporan' => WasteReport::with('category')
                ->where('user_id', session('user_id'))
                ->orderByDesc('created_at')
                ->get(),
        ]);
    }

    public function profil()
    {
        return view('user.profil', ['profil' => User::findOrFail(session('user_id'))]);
    }

    public function updateProfil(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|min:3|max:100',
            'no_hp'        => 'required|min:10|max:15',
            'alamat'       => 'nullable|string',
            'password'     => 'nullable|min:6',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nama_lengkap.min'      => 'Nama lengkap minimal 3 karakter.',
            'no_hp.required'        => 'No. HP wajib diisi.',
            'no_hp.min'             => 'No. HP minimal 10 karakter.',
            'password.min'          => 'Password baru minimal 6 karakter.',
        ]);

        $update = [
            'nama_lengkap' => $data['nama_lengkap'],
            'no_hp'        => $data['no_hp'],
            'alamat'       => $data['alamat'] ?? null,
        ];

        if (! empty($data['password'])) {
            $update['password'] = Hash::make($data['password']);
        }

        User::whereKey(session('user_id'))->update($update);
        session(['nama' => $update['nama_lengkap']]);

        return redirect()->route('user.profil')->with('success', 'Profil berhasil diupdate.');
    }
}
