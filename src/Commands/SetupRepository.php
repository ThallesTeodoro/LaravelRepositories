<?php

namespace ThallesTeodoro\Repositories\Commands;

use Illuminate\Console\Command;

class SetupRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->call('repository:add', ['name' => 'Repository']);
        $this->call('interface:add', ['name' => 'RepositoryInterface']);
        $this->call('unit-of-work:interface', ['name' => 'UnitOfWorkInterface']);
        $this->call('unit-of-work:repository', ['name' => 'UnitOfWork']);
        $this->line('Add the following line on register method of AppServiceProvider:');
        $this->info('$this->app->singleton("App\Interfaces\UnitOfWorkInterface", "App\Repositories\UnitOfWork");');
    }
}
