<?php

namespace App\Providers;

use App\Repositories\BoxRepository;
use App\Repositories\BoxRepositoryInterface;
use App\Repositories\PalletRepository;
use App\Repositories\PalletRepositoryInterface;
use Illuminate\Support\ServiceProvider;

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
        $this->app->bind(
            PalletRepositoryInterface::class,
            PalletRepository::class
        );

        $this->app->bind(
            BoxRepositoryInterface::class,
            BoxRepository::class
        );
    }
}
