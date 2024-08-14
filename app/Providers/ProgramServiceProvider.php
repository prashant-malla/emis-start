<?php

namespace App\Providers;

use App\Contracts\ProgramInterface;
use App\Repositories\ProgramRepository;
use Illuminate\Support\ServiceProvider;

class ProgramServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this
            ->app
            ->bind(
                ProgramInterface::class,
                ProgramRepository::class
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
