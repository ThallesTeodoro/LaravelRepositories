<?php

namespace ThallesTeodoro\Repositories\Commands;

use Illuminate\Console\Command;

class NewRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'repository:new {name} {model}';

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
        $name = $this->argument('name');
        $model = $this->argument('model');
        $interfaceName = $name . 'Interface';

        $this->call('repository:create', ['name' => $name, 'model' => $model]);
        $this->call('interface:create', ['name' => $interfaceName]);
        $this->line('Add the following line on registrer method of AppServiceProvider:');
        $this->info('$this->app->singleton("App\Interfaces\\' . $interfaceName . '", "App\Repositories\\' . $name . '");');
    }
}
