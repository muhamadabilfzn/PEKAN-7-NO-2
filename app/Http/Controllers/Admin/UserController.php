<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->only(['role', 'status', 'keyword']);

        $users = User::with('role')
            ->when(! empty($filter['role']), fn ($q) => $q->whereHas('role', fn ($r) => $r->where('name', $filter['role'])))
            ->when(! empty($filter['status']), fn ($q) => $q->where('status', $filter['status']))
            ->when(! empty($filter['keyword']), fn ($q) => $q->where('nama_lengkap', 'like', '%' . $filter['keyword'] . '%'))
            ->orderByDesc('created_at')
            ->get();

        return view('admin.users.index', compact('users', 'filter'));
    }

    public function create()
    {
        return view('admin.users.form', ['roles' => Role::orderBy('id')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'username'     => 'required|max:50|unique:users,username',
            'email'        => 'required|email|max:100|unique:users,email',
            'password'     => 'required|min:6',
            'role_id'      => 'required|exists:roles,id',
            'no_hp'        => 'nullable|max:20',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['status']   = 'aktif';
        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        return view('admin.users.form', [
            'roles'    => Role::orderBy('id')->get(),
            'editUser' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|max:100',
            'email'        => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'no_hp'        => 'nullable|max:20',
            'role_id'      => 'required|exists:roles,id',
            'status'       => 'required|in:aktif,nonaktif',
            'password'     => 'nullable|min:6',
        ]);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diupdate.');
    }

    public function destroy(User $user)
    {
        if ((int) $user->id === (int) session('user_id')) {
            return redirect()->route('admin.users.index')->with('error', 'Anda tidak bisa menghapus akun sendiri.');
        }

        try {
            $user->delete();
        } catch (QueryException $e) {
            return redirect()->route('admin.users.index')
                ->with('error', 'User tidak dapat dihapus karena masih memiliki data terkait (mis. artikel atau penugasan). Nonaktifkan saja.');
        }

        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }

    public function toggle(User $user)
    {
        $baru = $user->status === 'aktif' ? 'nonaktif' : 'aktif';
        $user->update(['status' => $baru]);

        return redirect()->route('admin.users.index')->with('success', 'Status user diubah menjadi ' . $baru . '.');
    }
}
