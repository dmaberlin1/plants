<?php

namespace App\Providers;

use App\Repositories\PlantRepository;
use App\Repositories\PlantRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Dependency Injection - binding interface to implementation
        $this->app->bind(PlantRepositoryInterface::class, PlantRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
