<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class VoucherServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Contracts\VoucherInterface::class,
            \App\Repositories\VoucherRepository::class
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
