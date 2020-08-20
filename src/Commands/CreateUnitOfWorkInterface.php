<?php

namespace ThallesTeodoro\Repositories\Commands;

use Illuminate\Console\GeneratorCommand;

class CreateUnitOfWorkInterface extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'unit-of-work:interface {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the Unit Of Work Interface';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Interface';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/unit-of-work-interface.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return "{$rootNamespace}\Interfaces";
    }
}
