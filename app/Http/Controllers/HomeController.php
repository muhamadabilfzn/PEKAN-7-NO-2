<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\WasteReport;

class HomeController extends Controller
{
    public function index()
    {
        // Pengguna yang sudah login langsung diarahkan ke dashboard sesuai role
        if (session('is_login')) {
            return redirect()->route(AuthController::dashboardRoute(session('role')));
        }

        return view('home.index', [
            'stats'   => WasteReport::statistik(),
            'artikel' => Article::published()->orderByDesc('created_at')->limit(4)->get(),
        ]);
    }
}
