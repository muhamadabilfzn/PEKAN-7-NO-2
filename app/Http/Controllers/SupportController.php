<?php

namespace App\Http\Controllers;

use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportController extends Controller
{
    public function index()
    {
        return view('support.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama'   => 'required|max:100',
            'email'  => 'required|email|max:100',
            'subjek' => 'nullable|max:150',
            'pesan'  => 'required|min:10',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'pesan.required' => 'Pesan wajib diisi.',
            'pesan.min'      => 'Pesan minimal 10 karakter.',
        ]);

        SupportMessage::create($data);

        return redirect()->route('bantuan.index')
            ->with('success', 'Pesan Anda berhasil dikirim. Kami akan merespons segera!');
    }
}
