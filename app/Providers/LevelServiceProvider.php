<?php

namespace App\Providers;

use App\Contracts\LevelInterface;
use App\Repositories\LevelRepository;
use Illuminate\Support\ServiceProvider;

class LevelServiceProvider extends ServiceProvider
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
                LevelInterface::class,
                LevelRepository::class
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
