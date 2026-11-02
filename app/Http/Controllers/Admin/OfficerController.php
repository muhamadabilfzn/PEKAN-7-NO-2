<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class OfficerController extends Controller
{
    public function index()
    {
        return view('admin.officers.index', [
            'petugas' => Officer::with('user')->whereHas('user', fn ($q) => $q->where('status', 'aktif'))->get(),
        ]);
    }

    public function create()
    {
        return view('admin.officers.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'username'     => 'required|max:50|unique:users,username',
            'email'        => 'required|email|max:100|unique:users,email',
            'password'     => 'required|min:6',
            'no_hp'        => 'nullable|max:20',
            'area_kerja'   => 'nullable|max:150',
        ]);

        DB::transaction(function () use ($data) {
            $user = User::create([
                'role_id'      => 2, // petugas
                'nama_lengkap' => $data['nama_lengkap'],
                'username'     => $data['username'],
                'email'        => $data['email'],
                'password'     => Hash::make($data['password']),
                'no_hp'        => $data['no_hp'] ?? null,
                'status'       => 'aktif',
            ]);

            Officer::create([
                'user_id'    => $user->id,
                'area_kerja' => $data['area_kerja'] ?? null,
                'status'     => 'aktif',
            ]);
        });

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil ditambahkan.');
    }

    public function edit(Officer $officer)
    {
        return view('admin.officers.form', ['editOfficer' => $officer->load('user')]);
    }

    public function update(Request $request, Officer $officer)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'email'        => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($officer->user_id)],
            'no_hp'        => 'nullable|max:20',
            'password'     => 'nullable|min:6',
            'area_kerja'   => 'nullable|max:150',
        ]);

        $userData = [
            'nama_lengkap' => $data['nama_lengkap'],
            'email'        => $data['email'],
            'no_hp'        => $data['no_hp'] ?? null,
        ];
        if (! empty($data['password'])) {
            $userData['password'] = Hash::make($data['password']);
        }

        DB::transaction(function () use ($officer, $userData, $data) {
            $officer->user->update($userData);
            $officer->update(['area_kerja' => $data['area_kerja'] ?? null]);
        });

        return redirect()->route('admin.petugas.index')->with('success', 'Data petugas berhasil diupdate.');
    }

    public function destroy(Officer $officer)
    {
        try {
            DB::transaction(function () use ($officer) {
                $officer->delete();
                $officer->user()->update(['status' => 'nonaktif']);
            });
        } catch (QueryException $e) {
            return redirect()->route('admin.petugas.index')
                ->with('error', 'Petugas tidak dapat dihapus karena masih memiliki riwayat penugasan.');
        }

        return redirect()->route('admin.petugas.index')->with('success', 'Petugas berhasil dihapus.');
    }
}
