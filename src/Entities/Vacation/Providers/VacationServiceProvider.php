<?php

namespace Humanity\Entities\Vacation\Providers;

use Humanity\Entities\Vacation\Contracts\VacationDateRepository;
use Humanity\Entities\Vacation\Repositories\VacationDateRepositoryEloquent;
use Illuminate\Support\ServiceProvider;
use Humanity\Entities\Vacation\Contracts\VacationRepository;
use Humanity\Entities\Vacation\Repositories\VacationRepositoryEloquent;

class VacationServiceProvider extends ServiceProvider
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
        $this->app->bind(VacationRepository::class, VacationRepositoryEloquent::class);
        $this->app->bind(VacationDateRepository::class, VacationDateRepositoryEloquent::class);
    }
}
