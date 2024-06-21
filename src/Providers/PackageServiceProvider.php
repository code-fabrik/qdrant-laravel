<?php

declare(strict_types=1);

namespace Codefabrik\QdrantLaravel\Providers;

use Codefabrik\QdrantLaravel\Console\Commands\QdrantSetup;
use Illuminate\Support\ServiceProvider;

final class PackageServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                commands: [
                    QdrantSetup::class,
                ],
            );
        }

        $this->publishes([
            __DIR__.'/../../config/qdrant.php' => config_path('qdrant.php'),
        ]);
    }

    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/qdrant.php', 'qdrant'
        );
    }
}
