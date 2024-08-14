<?php

namespace App\Providers;

use App\Contracts\StaffDirectoryInterface;
use App\Repositories\StaffDirectoryRepository;
use Illuminate\Support\ServiceProvider;

class StaffDirectoryProvider extends ServiceProvider
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
                StaffDirectoryInterface::class,
                StaffDirectoryRepository::class
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
