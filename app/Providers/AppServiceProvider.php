<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DownloaderData;
use App\Observers\DownloaderDataObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DownloaderData::observe(DownloaderDataObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
