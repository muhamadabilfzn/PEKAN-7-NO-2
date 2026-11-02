<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Officer;
use App\Models\WasteReport;

class AnalyticsController extends Controller
{
    public function index()
    {
        $stat = WasteReport::statistik();

        return view('admin.analytics', [
            'stats' => [
                'total_laporan'   => $stat['total'],
                'laporan_selesai' => $stat['selesai'],
                'laporan_aktif'   => $stat['aktif'],
                'total_petugas'   => Officer::count(),
            ],
        ]);
    }

    /** Data grafik (AJAX). */
    public function api()
    {
        return response()->json([
            'per_bulan'  => WasteReport::chartPerBulan(),
            'per_status' => WasteReport::chartPerStatus(),
            'per_area'   => WasteReport::chartPerArea(5),
        ]);
    }
}
