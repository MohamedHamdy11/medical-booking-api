<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Repositories\Interfaces\AvailableTimeRepositoryInterface;
use App\Repositories\AvailableTimeRepository;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\AppointmentRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            AvailableTimeRepositoryInterface::class,
            AvailableTimeRepository::class
        );
        $this->app->bind(
            AppointmentRepositoryInterface::class,
            AppointmentRepository::class
        );
    }

    
    public function boot(): void
    {
        //
    }

}