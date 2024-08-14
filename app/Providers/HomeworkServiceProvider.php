<?php

namespace App\Providers;

use App\Services\HomeworkService;
use App\Contracts\HomeworkInterface;
use Illuminate\Support\ServiceProvider;

class HomeworkServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            HomeworkInterface::class,
            HomeworkService::class
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
