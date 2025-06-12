<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Notifikasi;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $notifikasi = Notifikasi::where('user_id', Auth::id())
                    ->latest()
                    ->take(5)
                    ->get();

                $adaNotif = Notifikasi::where('user_id', Auth::id())
                    ->where('dibaca', false)
                    ->exists();

                $view->with([
                    'notifikasi' => $notifikasi,
                    'adaNotif' => $adaNotif,
                ]);
            }
        });
    }


}
