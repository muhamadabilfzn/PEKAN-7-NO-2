<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;

class NotificationController extends Controller
{
    public function read(Notifikasi $notif)
    {
        if ((int) $notif->user_id === (int) session('user_id')) {
            $notif->update(['is_read' => 1]);
        }

        return redirect()->route(AuthController::dashboardRoute(session('role')));
    }

    public function readAll()
    {
        Notifikasi::where('user_id', session('user_id'))->where('is_read', 0)->update(['is_read' => 1]);

        return redirect()->route(AuthController::dashboardRoute(session('role')))
            ->with('success', 'Semua notifikasi ditandai sudah dibaca.');
    }
}
