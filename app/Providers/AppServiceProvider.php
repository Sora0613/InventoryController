<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;
use Illuminate\Pagination\Paginator;

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
    public function boot(): void
    {
        // メアドを追加しとく。
        LogViewer::auth(function ($request) {
            return $request->user()
                && $request->user()->email === '';
        });
        Paginator::useBootstrap();
    }
}
