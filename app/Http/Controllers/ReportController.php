<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use App\Models\ReportImage;
use App\Models\WasteCategory;
use App\Models\WasteReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /** Dashboard pemantauan (publik). */
    public function index(Request $request)
    {
        $reports = WasteReport::with(['category', 'user'])
            ->filter($request->only(['status', 'kategori', 'keyword']))
            ->orderByDesc('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('reports.index', [
            'reports'    => $reports,
            'categories' => WasteCategory::orderBy('id')->get(),
            'filter'     => $request->only(['status', 'kategori', 'keyword']),
            'stats'      => WasteReport::statistik(),
        ]);
    }

    public function create()
    {
        return view('reports.create', [
            'categories' => WasteCategory::orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:waste_categories,id',
            'deskripsi'   => 'required|min:10|max:500',
            'alamat'      => 'required',
            'lat'         => 'nullable|numeric',
            'lng'         => 'nullable|numeric',
            'foto'        => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ], [
            'category_id.required' => 'Kategori sampah wajib dipilih.',
            'deskripsi.required'   => 'Deskripsi wajib diisi.',
            'deskripsi.min'        => 'Deskripsi minimal 10 karakter.',
            'alamat.required'      => 'Alamat/lokasi wajib diisi.',
            'foto.image'           => 'File harus berupa gambar.',
            'foto.max'             => 'Ukuran foto maksimal 5 MB.',
        ]);

        $report = DB::transaction(function () use ($request, $data) {
            $report = WasteReport::create([
                'user_id'       => session('user_id'),
                'category_id'   => $data['category_id'],
                'deskripsi'     => $data['deskripsi'],
                'alamat_detail' => $data['alamat'],
                'latitude'      => $data['lat'] ?? null,
                'longitude'     => $data['lng'] ?? null,
                'status'        => 'diajukan',
                'iuran'         => WasteReport::IURAN,
            ]);

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $name = 'laporan_' . time() . '_' . session('user_id') . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('assets/uploads/laporan'), $name);

                ReportImage::create([
                    'report_id' => $report->id,
                    'file_path' => 'assets/uploads/laporan/' . $name,
                    'file_type' => 'foto',
                ]);
            }

            return $report;
        });

        Notifikasi::kirim(
            session('user_id'),
            'Laporan Berhasil Dikirim',
            'Laporan #' . $report->id . ' Anda telah diterima dan akan segera diverifikasi.',
            'success'
        );

        return redirect()->route('user.riwayat')
            ->with('success', 'Laporan berhasil dikirim! Kami akan segera menanganinya.');
    }

    public function show(WasteReport $report)
    {
        $report->load(['category', 'user', 'images']);

        return view('reports.show', compact('report'));
    }

    public function destroy(WasteReport $report)
    {
        if ((int) $report->user_id !== (int) session('user_id')) {
            abort(403, 'Anda tidak berhak menghapus laporan ini.');
        }

        if ($report->status !== 'diajukan') {
            return redirect()->route('user.riwayat')
                ->with('error', 'Laporan yang sudah diproses tidak dapat dihapus.');
        }

        $report->delete();

        return redirect()->route('user.riwayat')->with('success', 'Laporan berhasil dihapus.');
    }

    /** Data titik laporan untuk peta (AJAX). */
    public function markers(Request $request)
    {
        $data = WasteReport::with('category')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->input('status')))
            ->get()
            ->map(fn ($r) => [
                'id'        => $r->id,
                'deskripsi' => $r->deskripsi,
                'status'    => $r->status,
                'latitude'  => $r->latitude,
                'longitude' => $r->longitude,
                'kategori'  => $r->category->nama,
                'warna'     => $r->category->warna,
            ]);

        return response()->json(['status' => 'ok', 'data' => $data]);
    }
}
