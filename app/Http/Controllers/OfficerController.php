<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Notifikasi;
use App\Models\Officer;
use App\Models\WasteReport;
use Illuminate\Support\Facades\DB;

class OfficerController extends Controller
{
    /** Data petugas yang sedang login. */
    private function officer(): Officer
    {
        return Officer::with('user')->where('user_id', session('user_id'))->firstOrFail();
    }

    public function dashboard()
    {
        $officer = $this->officer();

        $tugasAktif = Assignment::with('report.category')
            ->where('officer_id', $officer->id)
            ->whereIn('status', ['pending', 'diterima'])
            ->orderByDesc('assigned_at')
            ->get();

        return view('officer.dashboard', [
            'officer'      => $officer,
            'stats'        => [
                'pending' => $officer->assignments()->where('status', 'pending')->count(),
                'aktif'   => $officer->assignments()->where('status', 'diterima')->count(),
                'selesai' => $officer->assignments()->where('status', 'selesai')->count(),
                'saldo'   => $officer->saldo,
            ],
            'tugasAktif'   => $tugasAktif,
            'tugasSelesai' => Assignment::with('report.category')
                ->where('officer_id', $officer->id)
                ->where('status', 'selesai')
                ->orderByDesc('selesai_at')
                ->limit(5)
                ->get(),
            'mapData'      => $tugasAktif->map(fn ($t) => [
                'lat'    => $t->report->latitude,
                'lng'    => $t->report->longitude,
                'desc'   => $t->report->deskripsi,
                'kat'    => $t->report->category->nama,
                'status' => $t->status,
            ])->values(),
        ]);
    }

    public function tugasku()
    {
        $officer = $this->officer();

        return view('officer.tugasku', [
            'officer'    => $officer,
            'semuaTugas' => Assignment::with('report.category')
                ->where('officer_id', $officer->id)
                ->orderByDesc('assigned_at')
                ->get(),
        ]);
    }

    public function ambil(Assignment $assignment)
    {
        $officer = $this->officer();

        if ((int) $assignment->officer_id !== (int) $officer->id || $assignment->status !== 'pending') {
            return redirect()->route('officer.dashboard')->with('error', 'Gagal mengambil tugas.');
        }

        DB::transaction(function () use ($assignment) {
            $assignment->update(['status' => 'diterima']);
            $assignment->report->update(['status' => 'ditangani']);
        });

        return redirect()->route('officer.dashboard')
            ->with('success', 'Tugas berhasil diterima. Segera tangani laporan!');
    }

    public function selesai(Assignment $assignment)
    {
        $officer = $this->officer();

        if ((int) $assignment->officer_id !== (int) $officer->id || $assignment->status !== 'diterima') {
            return redirect()->route('officer.dashboard')->with('error', 'Tugas tidak ditemukan.');
        }

        $report = $assignment->report;

        DB::transaction(function () use ($assignment, $report, $officer) {
            $assignment->update(['status' => 'selesai', 'selesai_at' => now()]);
            $report->update(['status' => 'selesai']);
            $officer->increment('saldo', WasteReport::IURAN);
        });

        Notifikasi::kirim(
            $report->user_id,
            'Laporan Selesai Ditangani!',
            'Laporan #' . $report->id . ' Anda telah berhasil ditangani oleh petugas. Terima kasih!',
            'success'
        );

        return redirect()->route('officer.dashboard')
            ->with('success', 'Tugas selesai! Saldo +Rp15.000 telah ditambahkan.');
    }
}
