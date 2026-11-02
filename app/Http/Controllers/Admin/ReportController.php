<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Notifikasi;
use App\Models\Officer;
use App\Models\WasteCategory;
use App\Models\WasteReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->only(['status', 'kategori', 'keyword']);

        return view('admin.reports.index', [
            'reports'    => WasteReport::with(['category', 'user'])
                ->filter($filter)
                ->orderByDesc('created_at')
                ->paginate(15)
                ->withQueryString(),
            'categories' => WasteCategory::orderBy('id')->get(),
            'filter'     => $filter,
        ]);
    }

    public function show(WasteReport $report)
    {
        $report->load(['category', 'user', 'images']);

        return view('admin.reports.show', [
            'report'  => $report,
            'petugas' => Officer::with('user')->whereHas('user', fn ($q) => $q->where('status', 'aktif'))->get(),
        ]);
    }

    public function verify(WasteReport $report)
    {
        $report->update(['status' => 'diverifikasi']);

        Notifikasi::kirim(
            $report->user_id,
            'Laporan Diverifikasi',
            'Laporan #' . $report->id . ' Anda telah diverifikasi oleh admin.',
            'info'
        );

        return redirect()->route('admin.laporan.show', $report)->with('success', 'Laporan berhasil diverifikasi.');
    }

    public function assign(Request $request, WasteReport $report)
    {
        $data = $request->validate([
            'officer_id' => 'required|exists:officers,id',
            'catatan'    => 'nullable|string',
        ], [
            'officer_id.required' => 'Pilih petugas terlebih dahulu.',
        ]);

        $officer = Officer::findOrFail($data['officer_id']);

        DB::transaction(function () use ($report, $data) {
            Assignment::create([
                'report_id'   => $report->id,
                'officer_id'  => $data['officer_id'],
                'assigned_by' => session('user_id'),
                'catatan'     => $data['catatan'] ?? null,
                'status'      => 'pending',
            ]);
            $report->update(['status' => 'diproses']);
        });

        Notifikasi::kirim(
            $officer->user_id,
            'Tugas Baru',
            'Anda mendapat tugas baru untuk menangani laporan #' . $report->id,
            'warning'
        );
        Notifikasi::kirim(
            $report->user_id,
            'Laporan Sedang Diproses',
            'Laporan #' . $report->id . ' Anda sedang diproses oleh petugas kebersihan.',
            'info'
        );

        return redirect()->route('admin.laporan.show', $report)->with('success', 'Petugas berhasil ditugaskan.');
    }

    public function updateStatus(Request $request, WasteReport $report)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(WasteReport::STATUSES)],
        ], [
            'status.in' => 'Status tidak valid.',
        ]);

        $report->update(['status' => $data['status']]);

        return redirect()->route('admin.laporan.show', $report)
            ->with('success', 'Status laporan diupdate menjadi ' . $data['status'] . '.');
    }

    public function destroy(WasteReport $report)
    {
        $report->delete();

        return redirect()->route('admin.laporan.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
