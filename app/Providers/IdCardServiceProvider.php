<?php

namespace App\Providers;

use App\Contracts\IdCardInterface;
use App\Repositories\IdCardRepository;
use Illuminate\Support\ServiceProvider;

class IdCardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            IdCardInterface::class,
            IdCardRepository::class
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
