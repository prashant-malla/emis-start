<?php

namespace App\Providers;

use App\Contracts\YearSemesterInterface;
use App\Repositories\YearSemesterRepository;
use Illuminate\Support\ServiceProvider;

class YearSemesterServiceProvider extends ServiceProvider
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
                YearSemesterInterface::class,
                YearSemesterRepository::class
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
