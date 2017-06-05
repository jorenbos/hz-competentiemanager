<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\CompetencyRepository;
use App\Repositories\CompetencyRepositoryContract;
use App\Repositories\ProjectRepository;
use App\Repositories\ProjectRepositoryContract;
use App\Repositories\SlotRepository;
use App\Repositories\SlotRepositoryContract;
use App\Repositories\StudentRepository;
use App\Repositories\StudentRepositoryContract;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryContract;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }


    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CompetencyRepositoryContract::class, CompetencyRepository::class);
        $this->app->bind(ProjectRepositoryContract::class, ProjectRepository::class);
        $this->app->bind(SlotRepositoryContract::class, SlotRepository::class);
        $this->app->bind(StudentRepositoryContract::class, StudentRepository::class);
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
