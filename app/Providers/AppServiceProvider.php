<?php

namespace App\Providers;

use App\Domains\Category\Repositories\CategoryRepository;
use App\Domains\Microsite\Repositories\MicrositeRepository;
use App\Infrastructure\Persistence\CategoryRepositoryEloquent;
use App\Infrastructure\Persistence\MicrositeRepositoryEloquent;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryRepository::class, CategoryRepositoryEloquent::class);
        $this->app->bind(MicrositeRepository::class, MicrositeRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
