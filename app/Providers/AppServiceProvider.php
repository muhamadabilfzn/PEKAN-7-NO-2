<?php

namespace App\Providers;

use App\Models\Notifikasi;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Pagination memakai tampilan Bootstrap 5 (sama dengan CSS proyek)
        Paginator::useBootstrapFive();

        // Data notifikasi untuk header (dipakai di layout utama pada semua halaman)
        View::composer('partials.header', function ($view) {
            $notifCount = 0;
            $notifList  = collect();

            if (session('is_login')) {
                $query = Notifikasi::where('user_id', session('user_id'))->where('is_read', 0);
                $notifCount = (clone $query)->count();
                $notifList  = $query->orderByDesc('created_at')->limit(5)->get();
            }

            $view->with(compact('notifCount', 'notifList'));
        });
    }
}
