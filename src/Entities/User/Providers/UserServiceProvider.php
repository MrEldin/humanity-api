<?php

namespace Humanity\Entities\User\Providers;

use Illuminate\Support\ServiceProvider;
use Humanity\Entities\User\Contracts\UserRepository;
use Humanity\Entities\User\Repositories\UserRepositoryEloquent;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepository::class, UserRepositoryEloquent::class);
    }
}
