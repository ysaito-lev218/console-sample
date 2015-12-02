<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ApplicantInterface;
use App\Repositories\ApplicantRepository;

/**
 * Class RepositoryProvider
 * @package App\Providers
 */
class RepositoryProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // インターフェースとリポジトリの連結
        $this->app->bind(ApplicantInterface::class, ApplicantRepository::class);
    }
}
