<?php

namespace App\Providers;

use App\Models\NonCredit;
use App\Contracts\NonCreditInterface;
use Illuminate\Support\ServiceProvider;
use App\Repositories\NonCreditRepository;

class NonCreditServiceProvider extends ServiceProvider
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
                NonCreditInterface::class,
                NonCreditRepository::class
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
