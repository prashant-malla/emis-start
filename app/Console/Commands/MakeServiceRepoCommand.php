<?php

namespace App\Console\Commands;

use ReflectionClass;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class MakeServiceRepoCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:service-repo {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Artisan::call('make:interface', [
            'name' => $this->argument('name') . 'Interface'
        ]);

        $this->info('Interface created successfully.');

        Artisan::call('make:service', [
            'name' => $this->argument('name')
        ]);

        $this->info('Service created successfully.');

        Artisan::call('make:repository', [
            'name' => $this->argument('name')
        ]);

        $this->info('Repository created successfully.');

        Artisan::call('make:provider', [
            'name' => $this->argument('name') . 'ServiceProvider'
        ]);

        $this->info('Service provider created successfully.');

        $codeToAdd = "\n\t\t\$this->app->bind(\n" .
        "\t\t\t\\App\\Contracts\\" . str_replace('/', '\\', $this->argument('name')) . "::class,\n" .
        "\t\t\t\\App\\Services\\" . str_replace('/', '\\', $this->argument('name')) . "::class\n" .
        "\t\t);\n";

        $serviceProviderFile = app_path('Providers/' . $this->argument('name') . 'ServiceProvider.php');

        $serviceProviderClass = '\App\Providers\\' . $this->argument('name') . 'ServiceProvider';

        $reflectionClass = new ReflectionClass($serviceProviderClass);

        $reflectionMethod = $reflectionClass->getMethod('register');

        $methodBody = file($serviceProviderFile);

        $endLine = $reflectionMethod->getEndLine() - 1;

        array_splice($methodBody, $endLine, 0, $codeToAdd);
        $modifiedCode = implode('', $methodBody);

        file_put_contents($serviceProviderFile, $modifiedCode);

        $this->info('Interface and service binded successfully.');
    }
}
