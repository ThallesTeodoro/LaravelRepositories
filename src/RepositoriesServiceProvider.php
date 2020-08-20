<?php

namespace ThallesTeodoro\Repositories;

use Illuminate\Support\ServiceProvider;
use ThallesTeodoro\Repositories\Commands\NewRepository;
use ThallesTeodoro\Repositories\Commands\SetupRepository;
use ThallesTeodoro\Repositories\Commands\CreateInterface;
use ThallesTeodoro\Repositories\Commands\CreateRepository;
use ThallesTeodoro\Repositories\Commands\CreateNewInterface;
use ThallesTeodoro\Repositories\Commands\CreateNewRepository;
use ThallesTeodoro\Repositories\Commands\CreateUnitOfWork;
use ThallesTeodoro\Repositories\Commands\CreateUnitOfWorkInterface;

class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootCommands();
    }

    /**
     * Boot the custom commands
     *
     * @return void
     */
    private function bootCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                NewRepository::class,
                SetupRepository::class,
                CreateInterface::class,
                CreateRepository::class,
                CreateNewInterface::class,
                CreateNewRepository::class,
                CreateUnitOfWork::class,
                CreateUnitOfWorkInterface::class,
            ]);
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function registre()
    {

    }
}
