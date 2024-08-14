<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LedgerAccountServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Contracts\LedgerAccountInterface::class,
            \App\Repositories\LedgerAccountRepository::class
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
