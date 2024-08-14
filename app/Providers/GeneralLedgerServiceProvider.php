<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GeneralLedgerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Contracts\GeneralLedgerInterface::class,
            \App\Repositories\GeneralLedgerRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
