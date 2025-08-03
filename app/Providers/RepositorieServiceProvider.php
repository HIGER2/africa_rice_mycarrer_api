<?php

namespace App\Providers;

use App\Interface\stepIterface;
use App\Interface\rapportInterface;
use App\Interface\settingInterface;
use App\Interface\employeeInterface;
use App\Interface\jobInterface;
use App\Repositorie\stepRepositorie;
use App\Interface\objectiveInterface;
use App\Repositorie\rapportRepositorie;
use App\Repositorie\settingRepositorie;
use Illuminate\Support\ServiceProvider;
use App\Repositorie\employeeRepositorie;
use App\Repositorie\jobRepositorie;
use App\Repositorie\objectiveRepositorie;

class RepositorieServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(employeeInterface::class, employeeRepositorie::class);
        $this->app->bind(rapportInterface::class, rapportRepositorie::class);
        $this->app->bind(settingInterface::class, settingRepositorie::class);
        $this->app->bind(objectiveInterface::class, objectiveRepositorie::class);
        $this->app->bind(stepIterface::class, stepRepositorie::class);
        $this->app->bind(stepIterface::class, stepRepositorie::class);
        $this->app->bind(jobInterface::class, jobRepositorie::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
