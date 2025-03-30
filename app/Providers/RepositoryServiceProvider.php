<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UrlRepositoryInterface;
use App\Repositories\Eloquent\UrlRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UrlRepositoryInterface::class, UrlRepository::class);
        // Aquí se añadirán más bindings cuando creemos más repositorios
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
