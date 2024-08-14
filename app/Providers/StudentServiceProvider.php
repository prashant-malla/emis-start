<?php

namespace App\Providers;

use App\Contracts\StudentInterface;
use App\Repositories\StudentRepository;
use Illuminate\Support\ServiceProvider;

class StudentServiceProvider extends ServiceProvider
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
                StudentInterface::class,
                StudentRepository::class
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
