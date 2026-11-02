<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Officer;
use App\Models\User;
use App\Models\WasteReport;

class DashboardController extends Controller
{
    public function index()
    {
        $stat = WasteReport::statistik();

        return view('admin.dashboard', [
            'stats' => [
                'total_user'      => User::count(),
                'total_laporan'   => $stat['total'],
                'laporan_selesai' => $stat['selesai'],
                'laporan_aktif'   => $stat['aktif'],
                'total_petugas'   => Officer::count(),
                'total_artikel'   => Article::count(),
            ],
            'laporanBaru' => WasteReport::with(['user', 'category'])->orderByDesc('created_at')->limit(5)->get(),
            'userBaru'    => User::with('role')->orderByDesc('created_at')->limit(5)->get(),
            'chartBulan'  => WasteReport::chartPerBulan(),
            'chartStatus' => WasteReport::chartPerStatus(),
        ]);
    }
}
