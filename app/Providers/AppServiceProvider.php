<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ApplicantServiceInterface;
use App\Services\ApplicantService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // サービス
        $this->app->singleton(ApplicantServiceInterface::class, ApplicantService::class);
    }
}
