<?php

namespace App\Providers;

use App\Contracts\CertificateInterface;
use App\Repositories\CertificateRepository;
use Illuminate\Support\ServiceProvider;

class CertificateServiceProvider extends ServiceProvider
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
                CertificateInterface::class,
                CertificateRepository::class
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
