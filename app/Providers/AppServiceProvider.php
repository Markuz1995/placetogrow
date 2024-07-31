<?php

namespace App\Providers;

use App\Domains\Category\Repositories\CategoryRepository;
use App\Domains\Microsite\Repositories\MicrositeRepository;
use App\Domains\PaymentRecord\Repositories\PaymentRecordRepository;
use App\Domains\Role\Repositories\RoleRepository;
use App\Domains\User\Repositories\UserRepository;
use App\Infrastructure\Persistence\CategoryRepositoryEloquent;
use App\Infrastructure\Persistence\MicrositeRepositoryEloquent;
use App\Infrastructure\Persistence\PaymentRecordRepositoryEloquent;
use App\Infrastructure\Persistence\RoleRepositoryEloquent;
use App\Infrastructure\Persistence\UserRepositoryEloquent;
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
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
        $this->app->bind(RoleRepository::class, RoleRepositoryEloquent::class);
        $this->app->bind(PaymentRecordRepository::class, PaymentRecordRepositoryEloquent::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
